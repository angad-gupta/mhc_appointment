<div class="row">
    <form action="{{ route('patient-note.store') }}" method="post">
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

    @foreach($appointment->notes as $note)

        <div class="col-md-12 note-block">
            {!! $note->note !!}
            <form action="{{ route('patient-note.destroy',[$note->id]) }}" method="post"
                  onsubmit="return validate(this)">
                @csrf
                @method('delete')
                <input type="hidden" value="{{ encrypt($appointment->id) }}" name="appointment_id">
                <div class="btn-group" role="group" aria-label="...">
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                </div>
            </form>

        </div>

    @endforeach

</div>

<script>
    function validate(form) {
        var con = confirm('You want to delete this ?');
        if (con) {
            return true;
        } else {
            return false;
        }
    }
</script>