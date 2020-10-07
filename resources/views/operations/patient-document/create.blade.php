@extends('layouts.app')

@section('title')
    {{ __('document.patient_document') }}
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
            <h3 class="box-title">{{ __('document.patient_document') }}</h3>
        </div>
        <div class="box-body">
            @include('operations.patient.patient-card-small',['appointment'=>$appointment])

            <form action="{{ route('patient-document.store','redirect_back=1') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ encrypt($appointment->id) }}" name="appointment_id">
                <input type="hidden" value="{{ encrypt($appointment->patient_id) }}" name="patient_id">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">{{ __('doctor.title') }}</label>
                        <input type="text" class="form-control" name="title">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">{{ __('actions.file') }}</label>
                        <input required type="file" accept="image/*,application/pdf" class="form-control"
                               name="document">
                        <small>Accept only : pdf and image file</small>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">{{ __('note.note') }}</label>
                        <textarea name="note" id="" cols="30" rows="3" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-success">{{ __('actions.submit') }}</button>
                </div>
            </form>
        </div>

        <div class="box-footer">
            <div class="row">
                @forelse($appointment->documents as $document)
                    <div>
                        <div class="col-md-4">
                            <div class="document-block">
                                <iframe src="{{ showStorageImage($document->directory) }}"
                                        frameborder="0"></iframe>
                                <a href="javascript:void(0)" class="expand btn btn-success"
                                   onclick="openPopUp('{{showStorageImage($document->directory)}}')"><i
                                            class="fa fa-expand" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
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
    <script>
        function openPopUp(src) {
            let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,
width=0,height=0,left=-1000,top=-1000`;
            window.open(src, 'Open', params);
        }

    </script>
@endsection

