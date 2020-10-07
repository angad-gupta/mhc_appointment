@extends('layouts.app')

@section('title')
    {{ __('appointment.view_appointment') }}
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



    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary p-5">
                <p class="text-center text-success">{{ __('appointment.appointment') }} {{ __('schedule.date') }} :
                    <br> {{ $appointment->updated_at->format('l d-m-Y h:i A') }}</p>

                <img class="profile-user-img img-responsive img-circle"
                     src="{{ asset($appointment->patient->photo != null ? $appointment->patient->photo : 'dash/plugins/ckeditor/plugins/placeholder/icons/placeholder.png') }}"
                     alt="User profile picture">
                <h3 class="profile-username text-center">{{ $appointment->patient->user->name }}</h3>
                {{-- <p class="text-muted text-center">{{ $appointment->patient->occupation }}</p> --}}

                <p class="text-muted text-center">{{ $appointment->updated_at }}</p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>{{ __('patient.cell_phone') }}</b> <a class="pull-right">{{ $appointment->patient->user->phone }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>{{ __('actions.email') }}</b> <a class="pull-right">{{ $appointment->patient->user->email }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>{{ __('doctor.sex') }}</b> <a class="pull-right">{{ $appointment->patient->user->gender }}</a>
                    </li>
                </ul>

                <a href="{{ route('patient.show',['id'=>encrypt($appointment->patient->id)]) }}"
                   class="btn btn-link btn-block btn-xs"><b>{{ __('actions.view').  __('patient.patient') }}</b></a>

                @doctor
                @if($appointment->status == 1)
                    <button onclick="$(this).confirmSubmit($('#startAppointment{{$appointment->id}}'))" type="submit"
                            class="btn btn-primary btn-xs btn-block">
                        <i class="fa fa-play-circle-o"></i> {{ __('appointment.start_appointment') }}
                    </button>

                    <form action="{{ route('start.appointment') }}" id="startAppointment{{$appointment->id}}"
                          method="post">
                        @csrf
                        <input type="hidden" value="{{ encrypt($appointment->id) }}" name="appointment_id">
                    </form>
                @endif
                @enddoctor

            </div>
        </div>

        <div class="col-md-9">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs" id="mainTabs">
                    <li class="active">
                        <a href="#activity" data-toggle="tab"> {{ __('prescription.prescription') }}
                            <span class="label label-info"> {{ $appointment->prescriptions->count() }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#documents" data-toggle="tab"> {{ __('document.document') }}
                            <span class="label label-info">{{ $appointment->documents->count() }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#note" data-toggle="tab"> {{ __('note.note') }}
                            <span class="label label-info">{{ $appointment->notes->count() }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#payment" data-toggle="tab"> {{ __('payment.title') }}
                            <span class="label label-info">{{ $appointment->payments->count() }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#followUp" data-toggle="tab">{{ __('appointment.follow_up') }}
                            <span class="label label-info">{{ $appointment->followUpNotes->count() }}</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        @forelse($appointment->prescriptions as $prescription)
                            <div class="list-group prescriptions">
                                <a href="#" class="list-group-item">
                                    <p class="text-muted">{{ $prescription->created_at->format('l d-m-Y h:i A') }}</p>
                                    <h4 class="list-group-item-heading">{{ $prescription->inspection->chief_complains != null ? 'CC : '. $prescription->inspection->chief_complains :'Number of drug '. $prescription->drugs->count() }}</h4>
                                    <p class="list-group-item-text">
                                        @foreach($prescription->drugs as $drug)
                                            <span class="label label-success">{{ $drug->name }}</span>
                                        @endforeach
                                    </p>
                                </a>
                                <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                    <button type="button"
                                            onclick="openPopUp('{{ route('prescription.print',['id'=>encrypt($prescription->id)]) }}')"
                                            class="btn btn-success"><i class="fa fa-print"></i></button>
                                    @doctor
                                    <button onclick="$(this).confirmDelete($('#prescriptionDelete{{$prescription->id}}'))"
                                            type="button" class="btn btn-danger">
                                        <i
                                                class="fa fa-trash"></i></button>
                                    @enddoctor

                                    @superAdmin
                                    <button onclick="$(this).confirmDelete($('#prescriptionDelete{{$prescription->id}}'))"
                                            type="button" class="btn btn-danger">
                                        <i
                                                class="fa fa-trash"></i></button>
                                    @endsuperAdmin

                                </div>

                                <form action="{{ route('prescription.destroy',['id'=>encrypt($prescription->id)]) }}"
                                      method="post"
                                      id="prescriptionDelete{{$prescription->id}}">
                                    @csrf
                                    @method('delete')
                                </form>
                            </div>
                        @empty
                            <div class="not-found">
                                <h1>{{ __('actions.nothing_found') }}</h1>
                            </div>
                        @endforelse
                    </div>
                    <div class="tab-pane" id="documents">
                        <div class="text-right" style="padding-bottom: 30px;">
                            <a href="{{ route('patient-document.create','appointment='.encrypt($appointment->id)) }}"><i
                                        class="fa fa-plus-circle"></i> {{ __('document.create_document') }}</a>
                        </div>
                        <div class="row">
                            @forelse($appointment->documents as $d_key=>$document)
                                <div>
                                    <div class="col-md-4">
                                        <div class="document-block">
                                            <iframe src="{{ showStorageImage($document->directory) }}"
                                                    frameborder="0"></iframe>
                                            <a href="javascript:void(0)" class="expand btn btn-success"
                                               onclick="openPopUp('{{showStorageImage($document->directory)}}')"><i
                                                        class="fa fa-expand" aria-hidden="true"></i></a>
                                            <button onclick="$(this).confirmDelete($('#deleteDocument{{ $d_key }}'))"
                                                    class="btn btn-danger expand" style="margin-top: 40px;"><i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <form action="{{ route('patient-document.destroy',['id'=>encrypt($document->id),'redirect_back=1']) }}"
                                      method="post"
                                      id="deleteDocument{{ $d_key }}">
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
                    <div class="tab-pane" id="note">
                        <div class="text-right">
                            <a href="{{ route('patient-note.create','appointment='.encrypt($appointment->id)) }}"><i
                                        class="fa fa-plus-circle"></i> {{ __('note.create_note') }} </a>
                        </div>
                        <div class="row">
                            @forelse($appointment->notes as $note)
                                <div class="col-md-12 note-block p-5">
                                    {!! $note->note !!}
                                    <form action="{{ route('patient-note.destroy',[$note->id]) }}" method="post"
                                          onsubmit="return validate(this)">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" value="{{ encrypt($appointment->id) }}"
                                               name="appointment_id">
                                        <div class="btn-group" role="group" aria-label="...">
                                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            @empty
                                <div class="not-found">
                                    <h1>{{ __('actions.nothing_found') }}</h1>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="tab-pane" id="payment">
                        @forelse($appointment->payments as $key=>$payment)
                            <div class="list-group prescriptions">
                                <a href="#" class="list-group-item">
                                    <p class="text-muted">{{ $payment->created_at->format('l d-m-Y h:i A') }}</p>
                                    <h4 class="list-group-item-heading">{{ $payment->payment_amount }}</h4>
                                    {{-- <p class="list-group-item-text">
                                        {{ $payment->createdBy->user_name }}
                                    </p> --}}
                                </a>
                                <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                    <button type="button"
                                            onclick="openPopUp('{{ route('patient-payment.show',['id'=>encrypt($payment->id)]) }}')"
                                            class="btn btn-success"><i class="fa fa-print"></i></button>

                                    <button class="btn btn-primary" data-toggle="modal" data-target="#myModal{{$key}}">
                                        <i class="fa fa-envelope"></i></button>
                                    <div class="modal fade" id="myModal{{$key}}" tabindex="-1" role="dialog"
                                         aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title" id="myModalLabel">{{ __('payment.title') }} {{ __('actions.email') }}</h4>
                                                </div>
                                                <form action="{{ route('mail.payment') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="payment_id"
                                                           value="{{ encrypt($payment->id) }}">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="">{{ __('actions.email') }}</label>
                                                            <input type="email" required
                                                                   name="email"
                                                                   value="{{ $appointment->patient->contact_email }}"
                                                                   class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">{{ __('actions.cancel') }}
                                                        </button>
                                                        <button type="submit" class="btn btn-primary"> {{ __('mailbox.send_mail') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                    @admin
                                    <button onclick="$(this).confirmDelete($('#deletePayment{{$payment->id}}'))"
                                            type="button" class="btn btn-danger"><i
                                                class="fa fa-trash"></i></button>
                                    @endadmin
                                </div>
                                <form action="{{ route('patient-payment.destroy',['id'=>$payment->id]) }}"
                                      id="deletePayment{{$payment->id}}">
                                    @csrf
                                    @method('delete')
                                </form>
                            </div>
                        @empty
                            <div class="not-found">
                                <h1>{{ __('actions.nothing_found') }}</h1>
                            </div>
                        @endforelse
                    </div>
                    <div class="tab-pane" id="followUp">
                        <dl>
                            @if($appointment->next_followup)
                                <dt>{{ __('mail.your_next_followup_date') }}</dt>
                                <dd>{{ $appointment->next_followup }}</dd>
                            @endif

                            @if($appointment->note)
                                <dt>{{ __('appointment.follow_up_date') }}</dt>
                                <dd>{{ $appointment->note }}</dd>
                            @endif
                        </dl>

                        <div class="text-right">
                            <a href="{{ route('follow-up-note.create','appointment='.encrypt($appointment->id)) }}"><i
                                        class="fa fa-plus-circle"></i> {{ __('appointment.create_followup_note') }}</a>
                        </div>
                        @if($appointment->followUpNotes->count() > 0)
                            <h4 class="text-center">{{ __('appointment.follow_up_date') }}</h4>
                        @endif
                        @forelse($appointment->followUpNotes as $note)
                            <div class="list-group prescriptions">
                                <a href="#" class="list-group-item">
                                    <p class="text-muted">{{ $note->created_at->format('l d-m-Y h:i A') }}</p>
                                    <h4 class="list-group-item-heading">{!! $note->note !!}</h4>
                                    <p class="list-group-item-text">
                                        {{ $note->createdBy->user_name }}
                                    </p>
                                </a>
                                <div class="btn-group btn-group-sm" role="group" aria-label="...">

                                    <button type="button"
                                            onclick="window.location.replace('{{ route('follow-up-note.edit',['id'=>encrypt($note->id)]) }}')"
                                            class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                    <button onclick="$(this).confirmDelete($('#deleteNote{{$note->id}}'))" type="button"
                                            class="btn btn-danger"><i
                                                class="fa fa-trash"></i></button>
                                </div>
                                <form action="{{ route('follow-up-note.destroy',['id'=>encrypt($note->id)]) }}"
                                      method="post" id="deleteNote{{$note->id}}">
                                    @csrf
                                    @method('delete')
                                </form>
                            </div>
                        @empty
                            <div class="not-found">
                                <h1>{{ __('actions.nothing_found') }}</h1>
                            </div>
                        @endforelse
                    </div>
                </div>
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

        $(function () {
            var hash = window.location.hash;
            console.log(hash);
            if (hash != '') {
                $('#mainTabs a[href="' + hash + '"]').tab('show');
                $('.nav-tabs li').removeClass('active');
                $('.nav-tabs li a').each(function (index, value) {
                    if (value.hash == hash) {
                        value.parentNode.className = 'active';

                    }
                })
            }
        })

    </script>
@endsection