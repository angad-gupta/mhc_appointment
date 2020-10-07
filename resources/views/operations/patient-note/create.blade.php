@extends('layouts.app')

@section('title')
    {{ __('note.patient_note') }}
@endsection
@section('css')
    <style>
        .document-block {
            position: relative;
        }

        .document-block iframe {
            height: 250px;
            width: 100%;
        }

        .document-block .expand {
            position: absolute;
            top: 0;
            right: 0;
        }

        .note-block {
            border: 1px solid #e4e4e4;
            margin-top: 25px;
            border-radius: 2px;
            margin-left: 5px;
            margin-right: 5px;
            min-height: 150px;
            position: relative;
        }

        .note-block .btn-group {
            position: absolute;
            right: 0;
            top: -10px;
        }

        .p-5 {
            padding: 25px;

        }

        .prescriptions {
            position: relative;
        }

        .prescriptions .btn-group {
            position: absolute;
            top: 30%;
            right: 20px;
        }

        li.active {
            border-top-color: var(--color-primary) !important;
        }
    </style>
@endsection


@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('note.patient_note') }}</h3>
        </div>
        <div class="box-body">

            @include('operations.patient.patient-card-small', ['appointment'=>$appointment])


            <form action="{{ route('patient-note.store','redirect_back=1') }}" method="post">
                @csrf
                <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                <input type="hidden" value="{{ $appointment->patient_id }}" name="patient_id">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">{{ __('note.note') }}</label>
                        <textarea name="note" cols="30" rows="4" required minlength="10"
                                  class="form-control html-editor"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">{{ __('actions.submit') }}</button>
                </div>

            </form>
        </div>

        <div class="box-footer">
            <h4>{{ __('note.patient_note') }}</h4>
            <div class="row">
                @forelse($appointment->notes as $key=>$note)
                    <div class="col-md-12 note-block p-5">
                        {!! $note->note !!}

                            <div class="btn-group" onclick="$(this).confirmDelete($('#delete{{$key}}'))" role="group" aria-label="...">
                                <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i>
                                </button>
                            </div>

                    </div>

                    <form action="{{ route('patient-note.destroy',[$note->id]) }}" id="delete{{$key}}" method="post">
                        @csrf
                        @method('delete')
                        <input type="hidden" value="{{ encrypt($appointment->id) }}" name="appointment_id">

                    </form>

                @empty
                    <div class="not-found">
                        <h1>{{ __('actions.nothing_found') }}</h1>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection

