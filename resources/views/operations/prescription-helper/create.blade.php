@extends('layouts.app')

@section('title') {{ config('app.name', 'Laravel') }}

@endsection

@section('content')
    <div class="box box-primary">

        <div class="box-header with-border">
            <h3 class="box-title">{{ __('prescription-helper.create') }}</h3>
        </div>

        <form action="{{ route('prescription-helper.store')  }}" method="post" id="form">
            @csrf
            <div class="box-body">
                <div class="form-group">
                    <label for="">{{ __('prescription-helper.helper_text') }}</label>
                    <textarea required name="helper_text" id="" cols="30" rows="5" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="">{{ __('prescription-helper.category') }}</label>
                    <select required name="category" id="" class="form-control">
                        <option value="0">All</option>
                        <option value="1">Chief Complains</option>
                        <option value="2">On Examinations</option>
                        <option value="3">Provisional Diagnosis</option>
                        <option value="4">Differential Diagnosis</option>
                        <option value="5">Lab Workup</option>
                        <option value="6">Advices</option>
                    </select>

                </div>
            </div>

            <div class="box-footer">
                <button class="btn btn-primary" type="submit">{{ __('actions.submit') }}</button>
            </div>

        </form>

    </div>
@endsection

@section('js')

@endsection

