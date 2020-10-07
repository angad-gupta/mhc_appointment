@extends('layouts.app')

@section('title')
    Prescription Setting
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('dash/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
@endsection

@section('content')
    <div class="box box-primary presription">
        <div class="box-header with-border">
            <h3 class="box-title">Prescription Setting</h3>
        </div>
        <form action="{{ route('prescription-settings.update',['id'=>encrypt($prescription_setting->id)]) }}"
              method="post" id="update_form">
            @csrf
            @method('put')


            <input type="hidden" name="doctor_id" value="{{ encrypt($prescription_setting->doctor_id) }}">

            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input name="show_top_left" type="checkbox"
                                           {{ $prescription_setting->show_top_left == 1 ? 'checked' : '' }} id="topLeft">
                                    <label for="topLeft">Show Top Left</label>
                                </div>
                                <div class="form-group">
                                    <label for="">Top Left Text</label>
                                    <textarea name="top_left" id="" cols="30" rows="10"
                                              class="form-control editor">{{ $prescription_setting->top_left }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input name="show_top_right" type="checkbox"
                                           {{ $prescription_setting->show_top_right == 1 ? 'checked' : '' }} id="topRight">
                                    <label for="topRight">Show Top Left</label>
                                </div>
                                <div class="form-group">
                                    <label for="">Top Right Text</label>
                                    <textarea name="top_right" id="" cols="30" rows="10"
                                              class="form-control editor"><p>{{ $prescription_setting->top_right }}</p></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-success btn-flat">Submit</button>
            </div>
        </form>

    </div>
@endsection

@section('js')
    <script src="{{ asset('dash/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <script>
        $(function () {
            $('.editor').wysihtml5({
                toolbar: {
                    image: false,
                    link: false
                },

            });
        })
    </script>
@endsection


