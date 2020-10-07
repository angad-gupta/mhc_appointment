@extends('layouts.app')

@section('title') Edit Prescription Helper {{ config('app.name', 'Laravel') }}

@endsection

@section('content')
    <div class="box box-primary">

        <div class="box-header with-border">
            <h3 class="box-title">{{ __('prescription-helper.edit') }}</h3>
        </div>

        <form action="{{ route('prescription-helper.update',['id'=>encrypt($helper->id)])  }}" method="post" id="update_form">
            @csrf
            @method('put')
            <div class="box-body">
                <div class="form-group">
                    <label for="">{{ __('prescription-helper.helper_text') }}</label>
                    <textarea required name="helper_text" id="" cols="30" rows="5" class="form-control">{{ $helper->helper_text }}</textarea>
                </div>
                <div class="form-group">
                    <label for="">{{ __('prescription-helper.category') }}</label>
                    <select required name="category" id="" class="form-control">
                        <option {{ $helper->category == 0 ? 'selected' : '' }} value="0">All</option>
                        <option {{ $helper->category == 1 ? 'selected' : '' }} value="1">Chief Complains</option>
                        <option {{ $helper->category == 2 ? 'selected' : '' }} value="2">On Examinations</option>
                        <option {{ $helper->category == 3 ? 'selected' : '' }} value="3">Provisional Diagnosis</option>
                        <option {{ $helper->category == 4 ? 'selected' : '' }} value="4">Differential Diagnosis</option>
                        <option {{ $helper->category == 5 ? 'selected' : '' }} value="5">Lab Workup</option>
                        <option {{ $helper->category == 6 ? 'selected' : '' }} value="6">Advices</option>
                    </select>

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

