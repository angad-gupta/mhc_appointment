@extends('layouts.app')

@section('title')
    {{ __('drug.create_drug') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/plugins/image-preview/jquery.imagePreview.css') }}">
@endsection

@section('content')
    <div class="box box-primary">

        <div class="box-header with-border">
            <h3 class="box-title">{{ __('drug.create_drug') }}</h3>
        </div>

        <form action="{{ route('drug.store') }}" id="form" method="post">
            @csrf
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div id="image-preview">
                            <label for="" id="image-label">{{ __('drug.drug_image') }}</label>
                            <input name="image" type="file" id="image-upload">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="">{{ __('drug.trade_name') }} <span class="text-danger">*</span> </label>
                            <input type="text" name="trade_name" class="form-control" required
                                   placeholder="{{ __('drug.trade_name') }}">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('drug.generic_name') }} <span class="text-danger">*</span> </label>
                            <input type="text" name="generic_name" class="form-control" required
                                   placeholder="{{ __('drug.generic_name') }}">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('department.department') }} <span class="text-danger">*</span> </label>
                            <select name="department_id" id="" class="form-control" required>
                                <option value="">Select One</option>
                                <option value="0">All Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('drug.note') }}</label>
                            <textarea name="note" id="" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">{{ __('actions.submit') }}</button>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script src="{{ asset('dash/plugins/image-preview/jquery.imagePreview.js') }}"></script>
@endsection

