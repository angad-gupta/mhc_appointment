<!-- Widget: user widget style 1 -->
<div class="box box-widget widget-user widget-patient">
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <div class="widget-user-header bg-custom">
        <h3 class="widget-user-username"><sub>{{ $patient->title }}</sub> {{ $patient->full_name }}</h3>
        <h5 class="widget-user-desc">{{ $patient->cell_phone }} <br> {{ $patient->sex }} </h5>
    </div>
    <div class="widget-user-image">
        <img class="img-circle"
             src="{{ asset($patient->photo ? $patient->photo : 'dash/img/avatar2.png') }}"
             alt="User Avatar">
    </div>
    <div class="box-footer">
        <div class="row">
            <div class="col-sm-4 border-right">
                <div class="description-block">
                    <h5 class="description-header">{{ $patient->payments->sum('payment_amount') }}</h5>
                    <span class="description-text">{{ __('payment.title') }}</span>
                </div>
                <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4 border-right">
                <div class="description-block">
                    <h5 class="description-header">{{ $patient->appointments->where('status',2)->count() }}</h5>
                    <span class="description-text">{{ __('appointment.appointment') }}</span>
                </div>
                <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4">
                <div class="description-block">
                    <h5 class="description-header">{{ $patient->prescriptions->count() }}</h5>
                    <span class="description-text">{{ __('prescription.prescription') }}</span>
                </div>
                <!-- /.description-block -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>

    <div class="widget-patient-actions">
        <div class="btn-group btn-group-justified" role="group" aria-label="...">
            <div class="btn-group" role="group">
                <button type="button" class="btn bg-olive btn-flat dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-calendar"></i>
                    More
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('patient.payments',['id'=>encrypt($patient->id)]) }}">
                            <i class="fa fa-money text-success"></i> {{ __('payment.title') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('patient.documents',['id'=>encrypt($patient->id)]) }}">
                            <i class="fa fa-file-pdf-o text-primary"></i>{{ __('document.document') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('patient.notes',['id'=>encrypt($patient->id)]) }}">
                            <i class="fa fa-file-text-o text-navy"></i> {{ __('note.note') }} </a>
                    </li>
                    <li><a href="{{ route('prescription.index','date_range=&patient='.$patient->id) }}"><i
                                    class="fa fa-file-pdf-o"></i> {{ __('prescription.prescription') }}</a></li>
                    @doctor
                    <li>
                        <a href="{{ route('patient-reefer.edit',['id'=>encrypt($patient->id)]) }}"><i
                                    class="fa fa-share text-fuchsia"></i>Refereed to other doctor</a>
                    </li>
                    @enddoctor
                </ul>
            </div>

            {{--appointment start--}}
            <div class="btn-group" role="group">
                <button type="button" class="btn bg-orange btn-flat dropdown-toggle" style="padding-right: 10px"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-calendar"></i>
                    {{ __('appointment.appointment') }}
                    <i class="fa fa-angle-down" aria-hidden="true"></i>

                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('appointment.create').'?patient='.encrypt($patient->id) }}">
                            <i class="fa fa-pencil text-success"></i> {{ __('appointment.create_appointment') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('patient.timeline',['id'=>encrypt($patient->id)]) }}">
                            <i class="fa fa-history text-navy"></i> Timeline</a>
                    </li>
                    @doctor
                    <li>
                        <a href="javascript:void(0)" onclick="document.getElementById('qaForm{{$key}}').submit()">
                            <i class="fa fa-history text-navy"></i> {{ __('appointment.start_appointment') }} </a>
                    </li>

                    <form action="{{ route('quick.appointment') }}" id="qaForm{{$key}}" method="post">
                        @csrf
                        <input type="hidden" value="{{ encrypt($patient->id) }}" name="patient_id">
                    </form>
                    @enddoctor
                </ul>
            </div>
            {{--appointment end--}}

            {{--Setting button start--}}
            <div class="btn-group" role="group">
                <button type="button" class="btn bg-maroon btn-flat dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-cogs"></i>
                    {{ __('settings.settings') }}
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('patient.edit',['id'=>encrypt($patient->id)]) }}">
                            <i class="fa fa-pencil text-success"></i> {{ __('actions.edit') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('patient.show',['id'=>encrypt($patient->id)]) }}">
                            <i class="fa fa-eye text-primary"></i>{{ __('actions.view') }}</a>
                    </li>

                    <li>
                        <a href="javascript:void(0)" onclick="$(this).confirmDelete($('#deleteForm{{$key}}'))">
                            <i class="fa fa-trash text-danger"></i> {{ __('actions.delete') }}</a>
                    </li>
                    <form action="{{ route('patient.destroy',['id'=>$patient->id]) }}" method="post"
                          id="deleteForm{{$key}}">
                        @csrf
                        @method('delete')
                    </form>
                </ul>
            </div>
            {{--Setting button end--}}
        </div>
    </div>
</div>
<!-- /.widget-user -->

