<?php

namespace App\Http\Controllers;

use App\Models\PrescriptionDrug;
use Illuminate\Http\Request;

class PrescriptionTypeaheadController extends Controller
{
    /**
     * Get drug strength
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function drugStrength(Request $request)
    {
        $drug_strength = PrescriptionDrug::select('strength')
            ->groupBy('strength')
            ->where('strength','like','%'.$request->query('keyword').'%')
            ->pluck('strength');
        return response()->json($drug_strength);
    }

    /**
     * Get drug doses
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function drugDose(Request $request)
    {
        $drug_strength = PrescriptionDrug::select('dose')
            ->groupBy('dose')
            ->where('dose','like','%'.$request->query('keyword').'%')
            ->pluck('dose');
        return response()->json($drug_strength);
    }

    /**
     * Get drug advices
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function drugAdvice(Request $request)
    {
        $drug_strength = PrescriptionDrug::select('advice')
            ->groupBy('advice')
            ->where('advice','like','%'.$request->query('keyword').'%')
            ->pluck('advice');
        return response()->json($drug_strength);
    }

    /**
     * Get durg type
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function drugType(Request $request)
    {
        $drug_strength = PrescriptionDrug::select('type')
            ->groupBy('type')
            ->where('type','like','%'.$request->query('keyword').'%')
            ->pluck('type');
        return response()->json($drug_strength);
    }
}
