<div class="media">
    <div class="media-body">
        <h4 class="media-heading">{{ $appointment->doctor->title }} {{ $appointment->doctor->full_name }}</h4>
        <p><span class="label label-success">{{ $appointment->doctor->department->title }} </span></p>
        <p>{{ $appointment->doctor->phone }}</p>
    </div>
</div>