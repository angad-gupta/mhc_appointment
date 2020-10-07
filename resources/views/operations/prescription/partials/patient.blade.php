<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="{{ asset($patient->photo ? $patient->photo : 'dash/img/avatar2.png') }}"
                 alt="User profile picture">

            <h3 class="profile-username text-center">{{ $patient->title . ' ' .$patient->full_name }}</h3>

            <p class="text-muted text-center">{{ $patient->occupation }}</p>

            <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                    <b>Registered At</b> <a class="pull-right">{{ $patient->created_at->format('l d-M-Y') }}</a>
                </li>
                <li class="list-group-item">
                    <b>Total Appointment</b> <a class="pull-right">543</a>
                </li>
                <li class="list-group-item">
                    <b>Last Appointment</b> <a class="pull-right">13,287</a>
                </li>
                <li class="list-group-item">
                    <b>Next Followup</b> <a class="pull-right">13,287</a>
                </li>
            </ul>


        </div>
    </div>

    <div class="col-md-6">
        <h4>{{ __('patient.contact_information') }}</h4>
        <dl class="dl-horizontal">
            <dt>{{ __('patient.cell_phone') }}</dt>
            <dd>{{ $patient->cel_phone }}</dd>
            <dt>{{ __('actions.email') }}</dt>
            <dd>{{ $patient->contact_email }}</dd>
            <dt>{{ __('patient.address') }}</dt>
            <dd>{{ $patient->address }}</dd>
            <dt>{{ __('patient.city') }}</dt>
            <dd>{{ $patient->city }}</dd>
            <dt>{{ __('patient.country') }}</dt>
            <dd>{{ $patient->country }}</dd>
        </dl>
    </div>
    <div class="col-md-6">
        <h4>Medical Info</h4>
        <dl class="dl-horizontal">
            <dt>{{ __('patient.sex') }}</dt>
            <dd>{{ $patient->sex }}</dd>
            <dt>{{ __('patient.height') }}</dt>
            <dd>{{ $patient->height }}</dd>
            <dt>{{ __('patient.weight') }}</dt>
            <dd>{{ $patient->weight }}</dd>
        </dl>
    </div>
</div>