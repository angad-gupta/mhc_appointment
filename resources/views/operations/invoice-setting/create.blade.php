@extends('layouts.app')

@section('title')
    Invoice Setting
@endsection

@section('content')
    <div class="box box-primary">

        <div class="box-header with-border">
            <h3 class="box-title">Invoice Setting</h3>
        </div>
        <form action="{{ route('invoice-setting.store') }}" method="post" enctype="multipart/form-data" id="update_form">
            @csrf
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group"><label for="">Currency Name <span class="text-danger">*</span></label><input required name="currency_symbol" type="text" class="form-control"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group"><label for="">Currency Symbol <span class="text-danger">*</span></label><input required name="currency_name" type="text" class="form-control"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group"><label for="">Phone <span class="text-danger">*</span></label><input required name="phone" type="text" class="form-control"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group"><label for="">Email <span class="text-danger">*</span></label><input required name="email" type="text" class="form-control"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group"><label for="">Address <span class="text-danger">*</span></label><input required name="address" type="text" class="form-control"></div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group"><label for="">Invoice Text <span class="text-danger">*</span></label>
                            <textarea name="invoice_text" required id="" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </form>


    </div>
@endsection

@section('js')

@endsection

