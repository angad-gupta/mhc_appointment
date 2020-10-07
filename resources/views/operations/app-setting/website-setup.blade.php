@extends('layouts.app')

@section('title') Website Setup @endsection

@section('css')
    <style>
        #priveAboutPhoto {
            background-size: cover;
            background-repeat: no-repeat;
            @if($about)
                 height: 100px;
        @endif





        }
    </style>

@endsection
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h4 class="box-title">Website Setup</h4>

        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <h3>About Us</h3>
                    <form role="form" id="update_form" action="{{ route('store.about') }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">About Us</label>
                                <textarea name="about_us" cols="30" rows="5" required
                                          class="form-control">{{ $about ? $about->about_us : '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Opening Hours</label>
                                <textarea name="opening_hours" cols="30" rows="5" required
                                          class="form-control">{{ $about ? $about->opening_hours : '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="">About Us Photo</label>
                                <input type="file" name="about_us_image" class="form-control">
                            </div>

                            <div id="priveAboutPhoto"
                                 style="background-image: url('{{ asset($about ? $about->about_us_image : '') }}')">

                            </div>

                            <p class="text-center">Or</p>
                            <div class="form-group">
                                <label for="">About Us Video</label>
                                <input type="url" class="form-control" name="about_us_video"
                                       value="{{ $about ? $about->about_us_video : '' }}">
                                <p class="help-block">Youtube video only.</p>
                            </div>

                            <label class="radio-inline">
                                <input type="radio" name="image_or_video"
                                       {{ $about ? $about->image_or_video == 1 ? 'checked' : '' : 'checked' }}   id="inlineRadio1"
                                       value="1"> Show Image in website
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="image_or_video"
                                       {{ $about ? $about->image_or_video == 2 ? 'checked' : '' : '' }} id="inlineRadio2"
                                       value="2"> Show Video in website
                            </label>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <h3>Contact US</h3>

                    <form role="form" class="update_form" action="{{ route('store.contact') }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Phone</label>
                                <input type="text" class="form-control" value="{{ $contact ? $contact->phone : '' }}"
                                       name="phone" placeholder="Enter Phone number">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Email</label>
                                <input type="email" class="form-control" value="{{ $contact ? $contact->mail : '' }}"
                                       name="mail" placeholder="Email Address">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Address</label>
                                <textarea name="address" cols="30" rows="2" class="form-control"
                                          placeholder="Address">{{ $contact ? $contact->address : '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Google Map</label>
                                <textarea name="google_map" cols="30" rows="3" class="form-control"
                                          placeholder="Google Map">{{ $contact ? $contact->google_map : '' }}</textarea>
                                <p class="help-block">use <a href="{{ asset('dash/img/google-embeded-code.png') }}" target="_blank">src</a>
                                    from google map embed code. <a href="{{ asset('dash/img/google-embeded-code.png') }}" target="_blank">click here for details</a> </p>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Facebook</label>
                                <input type="url" name="fb_link" value="{{ $contact ? $contact->fb_link : '' }}"
                                       class="form-control" placeholder="Address">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Twitter</label>
                                <input type="url" name="twitter_link"
                                       value="{{ $contact ? $contact->twitter_link : '' }}" class="form-control"
                                       placeholder="Address">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Linked In</label>
                                <input type="url" name="linked_in_link"
                                       value="{{ $contact ? $contact->linked_in_link : '' }}" class="form-control"
                                       placeholder="Address">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Instragram</label>
                                <input type="url" name="instragram_link"
                                       value="{{ $contact ? $contact->instragram_link : '' }}" class="form-control"
                                       placeholder="Address">
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection