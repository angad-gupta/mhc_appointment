<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Title -->
  <title>@yield('title') - {{ config('app.name') }}</title>

  <!-- Required Meta Tags Always Come First -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <!-- Favicon -->
  <link rel="shortcut icon" href="{{asset('front/favicon.ico')}}">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- CSS Global Compulsory -->
  <link rel="stylesheet" href="{{asset('front/assets/vendor/bootstrap/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('front/assets/vendor/bootstrap/offcanvas.css')}}">
  <!-- CSS Global Icons -->
  <link rel="stylesheet" href="{{asset('front/assets/vendor/icon-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('front/assets/vendor/icon-line/css/simple-line-icons.css')}}">
  <link rel="stylesheet" href="{{asset('front/assets/vendor/icon-etlinefont/style.css')}}">
  <link rel="stylesheet" href="{{asset('front/assets/vendor/icon-line-pro/style.css')}}">
  <link rel="stylesheet" href="{{asset('front/assets/vendor/icon-hs/style.css')}}">
  <link rel="stylesheet" href="{{asset('front/assets/vendor/chosen/chosen.css')}}">
  <link rel="stylesheet" href="{{asset('front/assets/vendor/dzsparallaxer/dzsparallaxer.css')}}">
  <link rel="stylesheet" href="{{asset('front/assets/vendor/dzsparallaxer/dzsscroller/scroller.css')}}">
  <link rel="stylesheet" href="{{asset('front/assets/vendor/dzsparallaxer/advancedscroller/plugin.css')}}">
  <link rel="stylesheet" href="{{asset('front/assets/vendor/animate.css')}}">
  <link  rel="stylesheet" href="{{asset('fromt/assets/vendor/custombox/custombox.min.css')}}">
  <link rel="stylesheet" href="{{asset('front/assets/vendor/hamburgers/hamburgers.min.css')}}">
  <link rel="stylesheet" href="{{asset('front/assets/vendor/hs-megamenu/src/hs.megamenu.css')}}">
  <link rel="stylesheet" href="{{asset('front/assets/vendor/malihu-scrollbar/jquery.mCustomScrollbar.min.css')}}">
  <link rel="stylesheet" href="{{asset('front/assets/vendor/slick-carousel/slick/slick.css')}}">
  <link rel="stylesheet" href="{{asset('front/assets/vendor/fancybox/jquery.fancybox.css')}}">
  <link rel="stylesheet" href="{{asset('front/assets/vendor/jquery-ui/themes/base/jquery-ui.min.css')}}">


  <!-- CSS Unify -->
  <link rel="stylesheet" href="{{asset('front/assets/css/unify-core.css')}}">
  <link rel="stylesheet" href="{{asset('front/assets/css/unify-components.css')}}">
  <link rel="stylesheet" href="{{asset('front/assets/css/unify-globals.css')}}">

  <!-- CSS Customization -->
  <link rel="stylesheet" href="{{asset('front/assets/css/custom.css')}}">
  <style>
    .r_modal{
        max-width:100%;
    }
    @media only screen and (min-width: 600px)
    {
        .r_modal{
            max-width:100%;
        }
    }
    @media only screen and (min-width: 768px)
    {
        .r_modal{
            max-width:50%;
        }
    }
    @media only screen and (min-width: 1100px)
    {
        .r_modal{
            max-width:50%;
        }
    }
</style>
  @yield('css')

  @php
        $contact = \App\Models\Contact::first();
        $about = \App\Models\About::first()

    @endphp
    @yield('payment_gateway')
</head>
@include('front.components.navbar')
@if (Session::has('success'))
<div class="container">
  <div class="row">
    <div>
      <div data-notify="container" class="col-xs-11 col-sm-4 alert alert-success alert-dismissible fade show" role="alert" data-notify-position="bottom-right" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out; z-index: 1031; bottom: 20px; right: 10px; animation-iteration-count: 1;">
        <button type="button" class="close u-alert-close--light" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
        </button>
        <h4 class="h5">
        <i class="fa fa-check-circle-o"></i>
        Success!
        </h4>
        <p>{{Session::get('success')}}</p>
      </div>
    </div>
  </div>
</div>
@endif
@if (Session::has('error'))
<div class="container">
  <div class="row">
    <div>
      <div data-notify="container" class="col-xs-11 col-sm-4 alert alert-danger alert-dismissible fade show" role="alert" data-notify-position="bottom-right" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out; z-index: 1031; bottom: 20px; right: 10px; animation-iteration-count: 1;">
        <button type="button" class="close u-alert-close--light" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
        </button>
        <h4 class="h5">
        <i class="fa fa-check-circle-o"></i>
        Error!
        </h4>
        <p>{{Session::get('error')}}</p>
      </div>
    </div>
  </div>
</div>
@endif
@if (Session::has('appointment_submission'))
<div class="container">
  <div class="row">
    <div>
      <div data-notify="container" class="col-xs-11 col-sm-4 alert alert-success alert-dismissible fade show" role="alert" data-notify-position="bottom-right" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out; z-index: 1031; bottom: 20px; right: 10px; animation-iteration-count: 1;">
        <button type="button" class="close u-alert-close--light" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
        </button>
        <h4 class="h5">
        <i class="fa fa-check-circle-o"></i>
        Appointment Submitted succesfully
        </h4>
        <p>{!!Session::get('appointment_submission')!!}</p>
      </div>
    </div>
  </div>
</div>
@endif
@if(Session::has('video_call_status'))
<div class="container">
  <div class="row">
    <div>
      <div data-notify="container" class="col-xs-11 col-sm-4 alert alert-success alert-dismissible fade show" role="alert" data-notify-position="bottom-right" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out; z-index: 1031; bottom: 20px; right: 10px; animation-iteration-count: 1;">
        <button type="button" class="close u-alert-close--light" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
        </button>
        <h4 class="h5">
                <i class="fa fa-check-circle-o"></i>
                Video Appointment Started
            </h4>
            @php
                $searchId = Session::get('video_call_status');
                $id = \App\Models\Appointment::where('search_id', $searchId)->first()->id;
            @endphp
            <p class="g-mb-10">Your Appointment <strong>{{Session::get('video_call_status')}}</strong> has begun. Please Click the button below to start the video call</p>
            {{-- <a href="{{route('join.video_room',Session::get('video_call_status'))}}" target="_blank" class="btn u-btn-outline-darkgray btn-xs rounded-0"> --}}
            <a href="{{route('join.patient_room',Session::get('video_call_status'))}}" target="_blank" class="btn u-btn-outline-darkgray btn-xs rounded-0"> 
              <i class="fa fa-flask g-mr-2"></i>
                Join Call
            </a>
      </div>
    </div>
  </div>
</div>
@endif


@yield('content')


@include('front.components.footer')

<script src="{{asset('front/assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('front/assets/vendor/jquery-ui/jquery-ui.min.js')}}"></script>
  <script src="{{asset('front/assets/vendor/jquery-migrate/jquery-migrate.min.js')}}"></script>
  <script src="{{asset('front/assets/vendor/popper.min.js')}}"></script>
  <script src="{{asset('front/assets/vendor/bootstrap/bootstrap.min.js')}}"></script>

  <script src="{{asset('front/assets/vendor/bootstrap/offcanvas.js')}}"></script>

  <!-- JS Implementing Plugins -->
  <script src="{{asset('front/assets/vendor/hs-megamenu/src/hs.megamenu.js')}}"></script>
  <script src="{{asset('front/assets/vendor/dzsparallaxer/dzsparallaxer.js')}}"></script>
  <script src="{{asset('front/assets/vendor/dzsparallaxer/dzsscroller/scroller.js')}}"></script>
  <script src="{{asset('front/assets/vendor/dzsparallaxer/advancedscroller/plugin.js')}}"></script>
  <script src="{{asset('front/assets/vendor/masonry/dist/masonry.pkgd.min.js')}}"></script>
  <script src="{{asset('front/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
  <script src="{{asset('front/assets/vendor/chosen/chosen.jquery.js')}}"></script>
  <script src="{{asset('front/assets/vendor/malihu-scrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
  <script src="{{asset('front/assets/vendor/slick-carousel/slick/slick.js')}}"></script>
  <script src="{{asset('front/assets/vendor/fancybox/jquery.fancybox.min.js')}}"></script>
  <script  src="{{asset('front/assets/vendor/custombox/custombox.min.js')}}"></script>
  

  <!-- JS Unify -->
  <script src="{{asset('front/assets/js/hs.core.js')}}"></script>
  <script src="{{asset('front/assets/js/components/hs.header.js')}}"></script>
  <script src="{{asset('front/assets/js/helpers/hs.hamburgers.js')}}"></script>
  <script src="{{asset('front/assets/js/components/hs.dropdown.js')}}"></script>
  <script src="{{asset('front/assets/js/components/hs.scrollbar.js')}}"></script>
  <script src="{{asset('front/assets/js/components/hs.popup.js')}}"></script>
  <script src="{{asset('front/assets/js/components/hs.carousel.js')}}"></script>
  <script src="{{asset('front/assets/js/components/hs.select.js')}}"></script>
  <script src="{{asset('front/assets/js/components/hs.go-to.js')}}"></script>
  <script  src="{{asset('front/assets/js/components/hs.modal-window.js')}}"></script>

  <!-- JS Custom -->
  <script src="{{asset('front/assets/js/custom.js')}}"></script>


  <!-- JS Plugins Init. -->
  <script>
    $(document).on('ready', function () {
      // initialization of go to
      $.HSCore.components.HSModalWindow.init('[data-modal-target]');
      $.HSCore.components.HSGoTo.init('.js-go-to');
      setTimeout(function() { // important in this case
          $.HSCore.components.HSSelect.init('.js-custom-select');
        }, 1);
      // initialization of carousel
      $.HSCore.components.HSCarousel.init('.js-carousel');

      // $.HSCore.components.HSDatepicker.init('#datepickerDefault, #datepickerInline, #datepickerInlineFrom, #datepickerFrom');

      // initialization of HSDropdown component
      $.HSCore.components.HSDropdown.init($('[data-dropdown-target]'), {
        afterOpen: function(){
          $(this).find('input[type="search"]').focus();
        }
      });

      // initialization of range datepicker
      // $.HSCore.components.HSRangeDatepicker.init('.js-range-datepicker');
  

      // initialization of HSScrollBar component
      $.HSCore.components.HSScrollBar.init($('.js-scrollbar'));
 
      // initialization of masonry
      $('.masonry-grid').imagesLoaded().then(function () {
        $('.masonry-grid').masonry({
          columnWidth: '.masonry-grid-sizer',
          itemSelector: '.masonry-grid-item',
          percentPosition: true
        });
      });

      // initialization of popups
      $.HSCore.components.HSPopup.init('.js-fancybox');
    });

    $(window).on('load', function () {
      // initialization of header
      $.HSCore.components.HSHeader.init($('#js-header'));
      $.HSCore.helpers.HSHamburgers.init('.hamburger');

      // initialization of HSMegaMenu component
      $('#dropdown-megamenu').HSMegaMenu({
        event: 'hover',
        pageContainer: $('.container'),
        breakpoint: 767
      });
   
    });
  </script>
    @yield('js')
</body>

</html>


