@if(Session::has('video_call_status'))
<div class="alert alert-success" role="alert">
    <div class="row">
        <div class="col-lg-9 col-sm-6 col-md-9 text-left">
            Your video appointment has started. Click the <strong>Join Call</strong> button to start appointment
        </div>
        <div class="col-lg-3 col-sm-6 col-md-3 text-right">
            <a href="{{route('join.patient_room',Session::get('video_call_status'))}}" target="_blank" class="btn u-btn-outline-darkgray btn-xs rounded-0">
                <i class="fa fa-flask g-mr-2"></i>
                Join Call
            </a>
        </div>
    </div>
</div>
@endif