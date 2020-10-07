@section("payment_gateway")
 <script src="https://unpkg.com/khalti-checkout-web@latest/dist/khalti-checkout.iffe.js"></script>
@endsection
<div class="row">
  <div class="col-lg-6">
    <!-- User Block -->
    <div class="g-brd-around g-brd-gray-light-v4 g-pa-20 g-mb-40">
      <div class="row">
        <div class="col">
          <!-- User Details -->
          <div class="d-flex align-items-center justify-content-sm-between g-mb-5">
            <h2 class="g-font-weight-300 g-mr-10">{{ $doctor->title }} {{ $doctor->full_name }}  {!!$video ? '<i class="fa fa-phone" aria-hidden="true"></i>':''!!}</h2>
            <img class="g-height-90 g-width-90 rounded-circle g-mr-5"
              src="{{ asset($doctor->photo ? $doctor->photo : 'web/images/avatar.png') }}"
              alt="{{ $doctor->title }} {{ $doctor->full_name }}">
          </div>

          <!-- End User Details -->

          <!-- User Position -->
          <h4 class="h6 g-font-weight-300 g-mb-10">
            <i class="icon-badge g-pos-rel g-top-1 g-mr-5 g-color-gray-dark-v5"></i> {{ $doctor->department->title }}
          </h4>
          <!-- End User Position -->


          <!-- User Info -->
          <ul class="list-inline g-font-weight-300">
            @if($doctor->location)
            <li class="list-inline-item g-mr-20">
              <i class="icon-location-pin g-pos-rel g-top-1 g-color-gray-dark-v5 g-mr-5"></i> {{$doctor->location}}
            </li>
            @endif
            <li class="list-inline-item g-mr-20">
              <i class="icon-check g-pos-rel g-top-1 g-color-gray-dark-v5 g-mr-5"></i> Verified User
            </li>
            @if($video)
                @if($doctor->video_consultation_fee)
                  <h4 class="h6 g-font-weight-300 g-mb-5 g-mt-5">
                      Rs. {{$doctor->video_consultation_fee}} for video consultation
                  </h4>
                @else
                  <h4 class="h6 g-font-weight-300 g-mb-5 g-mt-5">
                    Rs. 300 for video consultation
                  </h4>
                @endif
              @else
                @if($doctor->normal_consultation_fee)
                    <h4 class="h6 g-font-weight-300 g-mb-5 g-mt-5">
                        Rs. {{$doctor->normal_consultation_fee}} at clinic
                    </h4>
                @endif
              @endif
            </ul>
          <!-- End User Info -->


          @if($doctor->info)
          <hr class="g-brd-gray-light-v4 g-my-20">

          <p class="lead g-line-height-1_8">{{$doctor->info}}</p>
          @endif
          <hr class="g-brd-gray-light-v4 g-my-20">

          <!-- User Skills -->
          <div class="d-flex justify-content-between text-uppercase g-mb-25">
            <div class="g-line-height-1">
              <h5 class="h6 g-font-weight-600">Appointment Date</h5>
              <div class="js-counter g-font-size-16" data-comma-separated="true">{{$date}}</div>
            </div>

            <div class="text-right g-line-height-1">
              <h5 class="h6 g-font-weight-600">Time</h5>
              <div class="js-counter g-font-size-16" data-comma-separated="true">{{ date('h:i A', strtotime($start_time)) }} - {{ date('h:i A', strtotime($end_time)) }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End User Block -->
  </div>

  <!-- Form -->
  <div class="col-lg-6">
    @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show d-flex" role="alert">
              <span class="check-icon"><i class="icofont icofont-close"></i></span>
              <div class="g-px-15">
                  <h4 class="mt-0"> Oops! Correct the following errors</h4>
                  <ul class="mb-0 p-0">
                      @foreach ($errors->all() as $error)
                      <li>{!! $error !!}</li>
                      @endforeach
                  </ul>
              </div>
              <button type="button" class="close" data-dismiss="alert">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
      @endif
            <div hidden role="alert" id="validation-error-container" hidden>
              <div class="g-px-15">
                  <h4 class="mt-0"> Oops! Correct the following errors</h4>
                  <ul class="mb-0 p-0" id="validation-errors">
              
                  </ul>
              </div>
          </div>

    <form class="validate" method="post" id="appointment-form">
    @csrf
    @guest
      <input type="hidden" name="schedule_date" value="{{$date}}"/>
      <input type="hidden" name="schedule_id" value="{{$schedule->id}}"/>
      <input type="hidden" name="doctor_id" value="{{ $doctor->encrypted_id }}"/>
      <input type="hidden" name="schedule_time" value="{{$start_time}} To {{$end_time}}"/>
      @if($video)
      <input type="hidden" name="video" value="{{ $video ? true:false }}"/>
      @endif
      <h1 class="title">Fill up the form below</h1>
      <div class="form-row">
        <div class="col-md-3">
          <div class="form-group">
            <label for="">{{ __('patient.title') }}</label>
            <input type="text" name="title" value="{{ old('title') }}" required
              class="form-control {{ $errors->has('title') ? ' parsley-error' : '' }}" />
          </div>
        </div>
        <div class="col-md-7">
          <div class="form-group">
            <label for="">{{ __('website.form.full_name') }}</label>
            <input type="text" name="full_name" value="{{ old('full_name') }}" required
              class="form-control {{ $errors->has('full_name') ? ' parsley-error' : '' }}" />
       
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <label for="">Gender</label>
            <select name="sex" required class="form-control {{ $errors->has('sex') ? ' parsley-error' : '' }}">
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Other">Other</option>
            </select>
       
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">{{ __('patient.birth_date') }}</label>
            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required autocomplete="off"
              class="form-control date_of_birth {{ $errors->has('date_of_birth') ? ' parsley-error' : '' }}" />
      
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label for="">{{ __('patient.cell_phone') }}</label>
            <input type="text" name="cell_phone" value="{{ old('cell_phone') }}" required
              class="form-control {{ $errors->has('cell_phone') ? ' parsley-error' : '' }}" />
          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
            <label for="">{{ __('patient.address') }}</label>
            <textarea cols="30" name="address" required rows="3"
              class="form-control {{ $errors->has('address') ? ' parsley-error' : '' }}">{{ old('address') }}</textarea>
          </div>
        </div>
        <div class="col-md-12">
          <h5>{{ __('actions.account_information') }}</h5>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label for="">{{ __('actions.email') }}</label>
            <input type="email" name="email" required
              class="form-control {{ $errors->has('email') ? ' parsley-error' : '' }}" value="{{ old('email') }}" />
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">{{ __('actions.password') }}</label>
            <input type="password" name="password" required
              class="form-control {{ $errors->has('password') ? ' parsley-error' : '' }}" />
          </div>
        </div>
        <div class="col-md-6 repass">
          <div class="form-group">
            <label for="">{{ __('actions.re_type_password') }}</label>
            <input type="password" name="password_confirmation"
              class="form-control {{ $errors->has('password_confirmation') ? ' parsley-error' : '' }}" />
          </div>
        </div>
        <div class="col-md-6 mb-3">
          <div class="custom-control custom-checkbox">
              <label class="form-check-label g-mb-20">
                <input type="checkbox" name="new_user" class="form-check-input" {{ old('new_user') ? 'checked' : '' }}
              id="registerCheck" />
              </label>
            <label class="custom-control-label" for="registerCheck">{{ __('website.form.new_user') }}</label>
            <br>
            <small id="rpasssText">{{ __('website.form.new_user_warn') }}</small>
          </div>
        </div>
      </div>
      @else
      <input type="hidden" name="schedule_date" value="{{$date}}"/>
      <input type="hidden" name="schedule_id" value="{{$schedule->id}}"/>
      <input type="hidden" name="doctor_id" value="{{ $doctor->encrypted_id }}"/>
      <input type="hidden" name="schedule_time" value="{{$start_time}} To {{$end_time}}"/>
      @if($video)
      <input type="hidden" name="video" value="{{ $video ? true:false }}"/>
      @endif
      <div class="g-brd-around g-brd-gray-light-v4 g-brd-left-4 g-brd-green-left g-line-height-1_8 g-rounded-3 g-pa-20 g-mb-30" role="alert">
      <h3 class="g-color-green g-font-weight-600">Procced to Pay</h3>
      <p class="mb-0 g-font-size-16">Payment options of Khalti and Esewa are available</p>
      </div>
      @endguest
   <div class="text-center" style="margin-top: 10px;" id="pay_now_button_container">
                                <div class="form-group">
                                    <button class="btn btn-md btn-primary" id="pay_now" type="button" disabled="" title="Proceed to make Purchase" style="border-radius:30px;"><i class="icon-check"></i> <span class="btn-txt"> Proceed for payment</span> <i class="loading-icon fa fa-spinner fa-spin" aria-hidden="true" hidden></i></button>
                                </div>

                            </div>
      <div class="payment_options">

      </div>
          
    </form>
  </div>
</div>

@section('js')
<script src="{{asset('web/form.bundle.js')}}"></script>

    <script>
    $(document).on("change",'#khalti_payment_option',function(){
          $('.submit-button').removeAttr("id");
          $('.submit-button').attr("id","pay-with-khalti");
    });
     $(document).on("change",'#esewa_payment_option',function(){
          $('.submit-button').removeAttr("id");
          $('.submit-button').attr("id","pay-with-esewa");
    });
    </script>
    <script>
      $(document).ready(function(){
        $('#pay_now').click(function(){
          $('.loading-icon').removeAttr("hidden");
            var form = $("#appointment-form");
            var url = form.attr('action');
            
            $.ajax({
                  type: "POST",
                  url: "{{route('pay_now')}}",
                  data: form.serialize(),
                  success: function(data)
                  {
                      $('#pay_now_button_container').remove();
                      $('.payment_options').append(data);
                  },
                   error:function(data)
                  {
                    $('.loading-icon').attr("hidden","true");
                    $('#validation-error-container').removeAttr("hidden");
                    $("#validation-errors").empty();
                    $.each(data.responseJSON.errors, function(key,value) {
                      $('#validation-errors').append('<li>'+value+'</li>');
                    });                
                  }
                });
            });
          });

      $(window).on('load',function(){
        $("#pay_now").removeAttr("disabled");
      });
    </script>
 

    
@endsection