<div class="row" style="padding: 10px 20px;">
    <div class="col-md-6" style="margin-top: 3%;">
        <div class="media">
            <div class="media-left">
                <a href="#">
                    <img class="media-object img-circle" src="{{ asset('dash/img/avatar.png') }}"
                         height="40px" alt="...">
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading">{{ $appointment->patient->full_name }}</h4>
                <p>{{ $appointment->patient->cell_phone }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <h4>Appointment ID : <a href="{{ route('appointment.show',['id'=>encrypt($appointment->id)]) }}">{{ $appointment->search_id }}</a>
        </h4>
    </div>
</div>