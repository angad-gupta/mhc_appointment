<?php

namespace App\Http\Controllers;

use App\Models\PrescriptionDrug;
use App\Models\PrescriptionInspection;
use App\Models\Template\PrescriptionTemplate;
use App\Models\Template\PrescriptionTemplateDrug;
use App\Models\Template\PrescriptionTemplateInspection;
use App\Traits\DrugTrait;
use Illuminate\Http\Request;

class PrescriptionTemplateController extends Controller
{

    use DrugTrait;

    /**
     * return all templates by doctor
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMyTemplates()
    {
        $prescription_tempaltes = PrescriptionTemplate::where('doctor_id', auth()->user()->doctor->id)->get();
        return response()->json($prescription_tempaltes);
    }

    /**
     * Return template with drugs and inspection
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTemplateById($id)
    {
        $template = PrescriptionTemplate::where('id', $id)->with('drugs', 'inspection')->first();
        return response()->json($template);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $template = PrescriptionTemplate::query();
        if (auth()->user()->role == 2) {
            $template->where('doctor_id', auth()->user()->doctor->id);
        }
        return view('operations.prescription-template.index', [
            'templates' => $template->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('operations.prescription-template.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $prescription_template = new PrescriptionTemplate();
            $prescription_template->fill($request->template);
            $prescription_template->save();
            $this->storeTemplateInspection($prescription_template, $request->inspection);
            foreach ($request->drugs as $drug) {
                $this->storeTemplateDrug($prescription_template, $drug);
            }
            return response()->json($prescription_template, 200);
        } catch (\Exception $e) {
            return response()->json($e, 400);
        }
    }

    /**
     * Store template drug
     * @param PrescriptionTemplate $template
     * @param $drug
     */
    public function storeTemplateDrug(PrescriptionTemplate $template, $drug)
    {
        $this->saveDrugIfNotExist($drug['name']);
        $template_drug = new PrescriptionTemplateDrug();
        $template_drug->fill($drug);
        $template_drug->prescription_template_id = $template->id;
        $template_drug->save();
    }

    /**
     * Store template inspection
     * @param PrescriptionTemplate $template
     * @param $inspection
     */
    public function storeTemplateInspection(PrescriptionTemplate $template, $inspection)
    {
        $template_inspection = new PrescriptionTemplateInspection();
        $template_inspection->prescription_template_id = $template->id;
        $template_inspection->fill($inspection);
        $template_inspection->save();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('operations.prescription-template.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('operations.prescription-template.edit', [
            'template_id' => $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $prescription_template = PrescriptionTemplate::findOrFail($id);
        $prescription_template->fill($request->all());
        if ($prescription_template->save()) {
            PrescriptionTemplateDrug::where('prescription_template_id', $prescription_template->id)->delete();
            PrescriptionTemplateInspection::where('prescription_template_id', $prescription_template->id)->delete();
            $this->storeTemplateInspection($prescription_template, $request->inspection);
            foreach ($request->drugs as $drug) {
                $this->storeTemplateDrug($prescription_template, $drug);
            }
        }
        return response()->json($prescription_template, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prescription_template = PrescriptionTemplate::findOrFail(encrypt($id));
        PrescriptionTemplateDrug::where('prescription_template_id', $prescription_template->id)->delete();
        PrescriptionTemplateInspection::where('prescription_template_id', $prescription_template->id)->delete();
        if ($prescription_template->delete()) {
            return redirect()->back('success', 'Prescription Template Has been deleted successfully');
        }
    }

    /**
     * Print template by id
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function print($id)
    {
        try {
            $_id = decrypt($id);
        } catch (\Exception $ex) {
            abort(404);
        }
        return view('operations.prescription-template.print', [
            'template' => PrescriptionTemplate::findOrFail($_id)
        ]);
    }
}
