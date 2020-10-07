<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceSettingRequest;
use App\Models\InvoiceSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;

class InvoiceSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoice_setting = InvoiceSetting::first();
        if (is_object($invoice_setting)) {
            return view('operations.invoice-setting.edit', [
                'invoice_setting' => $invoice_setting
            ]);
        } else {
            return view('operations.invoice-setting.create');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceSettingRequest $request)
    {
        $invoice_setting = InvoiceSetting::first();
        if (!is_object($invoice_setting)) {
            $invoice_setting = new InvoiceSetting();
        }
        $invoice_setting->fill($request->all());
        if ($invoice_setting->save()) {
            return response()->json(['Success', 'Invoice setting has been saved successfully'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
