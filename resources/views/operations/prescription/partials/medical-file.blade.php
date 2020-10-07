<div class="row">
    <form action="{{ route('patient-document.store') }}" method="post" enctype="multipart/form-data">
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
                <label for="">File</label>
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
            <button class="btn btn-success">Save</button>
        </div>
    </form>

    {{--{{ $appointment->documents }}--}}

    <div class="col-md-12">
        <div class="row">
            @foreach($appointment->documents as $key=>$document)
                <div class="col-md-4">
                    <div class="document-block">
                        <iframe src="{{ showStorageImage($document->directory) }}" frameborder="0"></iframe>
                        <div class="expand btn-group">
                            <a href="javascript:void(0)" class=" btn btn-success"
                               onclick="openPopUp('{{showStorageImage($document->directory)}}')"><i class="fa fa-expand"
                                                                                                    aria-hidden="true"></i></a>
                            <button onclick="$(this).confirmDelete($('#delete{{$key}}'))" class="btn btn-danger"><i
                                        class="fa fa-trash"></i></button>
                            <form id="delete{{$key}}"
                                  action="{{ route('patient-document.destroy',[encrypt($document->id)]) }}"
                                  method="post">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="appointment_id" value="{{ encrypt($appointment->id) }}">
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


</div>