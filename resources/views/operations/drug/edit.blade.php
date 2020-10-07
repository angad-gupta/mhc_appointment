@extends('layouts.app')

@section('title')
    {{ __('drug.edit_drug') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/plugins/image-preview/jquery.imagePreview.css') }}">
@endsection

@section('content')
    <div class="box box-primary">

        <div class="box-header with-border">
            <h3 class="box-title">{{ __('drug.edit_drug') }}</h3>
        </div>

        <form action="{{ route('drug.update',['id'=>encrypt($drug->id)]) }}" id="update_form" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div id="image-preview"
                             style="background-image: url('{{asset($drug->image != null ? $drug->image :'dash/img/boxed-bg.jpg')}}')">
                            <label for="" id="image-label">{{ __('drug.drug_image') }}</label>
                            <input name="image" type="file" id="image-upload">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="">{{ __('drug.trade_name') }} <span class="text-danger">*</span> </label>
                            <input type="text" name="trade_name" class="form-control" required
                                   value="{{ $drug->trade_name }}"
                                   placeholder="{{ __('drug.trade_name') }}">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('drug.generic_name') }} <span class="text-danger">*</span> </label>
                            <input type="text" name="generic_name" class="form-control" required
                                   value="{{ $drug->generic_name }}"
                                   placeholder="{{ __('drug.generic_name') }}">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('department.department') }} <span class="text-danger">*</span> </label>
                            <select name="department_id" id="" class="form-control" required>
                                <option value="">Select One</option>
                                <option {{ $drug->department_id == 0 ? 'selected' : '' }} value="0">All Department</option>
                                @foreach($departments as $department)
                                    <option {{ $department->id == $drug->department_id ? 'selected' : '' }} value="{{ $department->id }}">{{ $department->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('drug.note') }}</label>
                            <textarea name="note" id="" cols="30" rows="3"
                                      class="form-control">{{ $drug->note }}</textarea>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="status" {{ $drug->status == 1 ? 'checked' : '' }}>
                                Active
                            </label>
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

