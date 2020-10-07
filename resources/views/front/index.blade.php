@extends('front.components.app')

@section('title')
{{ __('website.nav.home') }}
@endsection
@section('content')
<!-- Intro section -->
<section class="g-py-30 g-mb-50">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-lg-5 intro-div">
				<div class="order-1 w-100 u-ns-bg-v1-bottom g-bg-white g-z-index-1 g-px-50">
					<h3 class="h5 g-color-primary g-font-weight-700 text-uppercase g-mb-10 intro-text">Introducing Video
						Consultations.</h3>
					<p class="mb-3 text-uppercase">Don’t delay your health concerns.</p>
					<img src="{{asset('front/assets/images/doctor-appointment.png')}}" class="img-fluid" alt="Logo">
				</div>
			</div>
			<div class="col-xs-12 col-lg-7">
				<div class="row">
					<div class="col-sm-6 g-mb-30">
						<!-- Article -->
						<article class="u-block-hover" id="filter_button">
							<a style="text-decoration:none;" href="{{ route('w.doctors') }}">
								<figure class="g-overflow-hidden u-divider-center">
									<img class="img-fluid u-block-hover__main--zoom-v1" src="{{asset('front/assets/images/doctor_online.png')}}" alt="Search Doctors" style="cursor:pointer;">
								</figure>
								<div class="g-bg-purple g-color-white g-pa-10">
									<h3 class="h4 text-uppercase g-font-weight-600 g-mb-10">Find doctors</h3>
									<p>Select prefered doctor and time to book an in-clinic and video consultation</p>
								</div>
							</a>
						</article>
						<!-- End Article -->
					</div>

					<div class="col-sm-6 g-mb-30">
						<!-- Article -->
						<article class="u-block-hover">
						<a style="text-decoration:none;" href="{{route('specialities')}}">
							<figure class="g-overflow-hidden u-divider-center">
								<img class="img-fluid u-block-hover__main--zoom-v1" src="{{asset('front/assets/images/specialities.png')}}" alt="Specialities" style="width:225px; cursor:pointer;">
							</figure>

							<div class="g-bg-purple g-color-white g-pa-10">
								<h3 class="h4 text-uppercase g-font-weight-600 g-mb-10">Specialities</h3>
								<p>Tell us your health concern and we will assign you a top doctor</p>
							</div>					
						</article>
						</a>
						<!-- End Article -->
					</div>
				</div>
			</div>
		</div>
</section>
<!-- Speciality start -->
 <div class="container g-pt-30 g-pos-rel g-z-index-1 g-mb-90" id="filter_div">
 <div class="row mx-5 mb-3">
			<div class="col-12">
				<div class="u-heading-v2-1--bottom g-mb-30">
					<h2 class="u-heading-v2__title g-mb-10 text-uppercase g-color-primary g-font-weight-600">Search Doctors</h2>
					<h4 class="g-font-weight-200">Find experience doctors for your problem</h4>
				</div>
			</div>
		</div>
        <!-- Input Group -->
        <form method="GET" action="{{route('w.doctors')}}">
             <div class="row justify-content-center">
               <div class="col-sm-4 col-lg-3 g-mb-30">
              <!-- Button Group -->
              <select class="js-custom-select w-100 u-select-v1 g-brd-gray-light-v3 g-color-black g-color-primary--hover g-bg-white g-py-12" name="department" data-placeholder="Department" data-open-icon="fa fa-angle-down" data-close-icon="fa fa-angle-up">
                <option></option>
               @foreach($specialities as $d)
                  <option class="g-brd-none g-color-black g-color-white--hover g-color-white--active g-bg-primary--hover g-bg-primary--active" value="{{$d->slug}}">{{$d->title}}</option>
                @endforeach
              </select>
              <!-- End Button Group -->
            </div>
            <div class="col-sm-4 col-lg-3 g-mb-30">
              <!-- Button Group -->
              <select class="js-custom-select w-100 u-select-v1 g-brd-gray-light-v3 g-color-black g-color-primary--hover g-bg-white g-py-12" name="gender" data-placeholder="Gender" data-open-icon="fa fa-angle-down" data-close-icon="fa fa-angle-up">
				<option></option>
                <option  class="g-brd-none g-color-black g-color-white--hover g-color-white--active g-bg-primary--hover g-bg-primary--active" value="Any">Any</option>
                <option  class="g-brd-none g-color-black g-color-white--hover g-color-white--active g-bg-primary--hover g-bg-primary--active" value="Male">Male</option>
                <option class="g-brd-none g-color-black g-color-white--hover g-color-white--active g-bg-primary--hover g-bg-primary--active" value="Female">Female</option>
                <option class="g-brd-none g-color-black g-color-white--hover g-color-white--active g-bg-primary--hover g-bg-primary--active" value="Other">Other</option>
              </select>
              <!-- End Button Group -->
            </div>

            <div class="col-sm-4 col-lg-3 g-mb-30">
              <!-- Button Group -->
              <select class="js-custom-select w-100 u-select-v1 g-brd-gray-light-v3 g-color-black g-color-primary--hover g-bg-white g-py-12" name="consultation_fee" data-placeholder="Consultation Fee" data-open-icon="fa fa-angle-down" data-close-icon="fa fa-angle-up">
                <option></option>
                <option class="g-brd-none g-color-black g-color-white--hover g-color-white--active g-bg-primary--hover g-bg-primary--active" value="free">Free</option>
                <option class="g-brd-none g-color-black g-color-white--hover g-color-white--active g-bg-primary--hover g-bg-primary--active" value="300">NPR.1-300</option>
                <option class="g-brd-none g-color-black g-color-white--hover g-color-white--active g-bg-primary--hover g-bg-primary--active" value="500">NPR.300-500</option>
                <option class="g-brd-none g-color-black g-color-white--hover g-color-white--active g-bg-primary--hover g-bg-primary--active" value="1000">NPR.500-1000</option>
				<option class="g-brd-none g-color-black g-color-white--hover g-color-white--active g-bg-primary--hover g-bg-primary--active" value="1000+">NPR.1000+</option>
                <option class="g-brd-none g-color-black g-color-white--hover g-color-white--active g-bg-primary--hover g-bg-primary--active" value="Any">Any</option>
              </select>
              <!-- End Button Group -->
            </div>
            
          </div>
          <div class="row justify-content-center g-mx-5--md">
            <div class="col-sm-9 col-lg-7 g-px-0--sm g-mb-30">
              <input name="doctor" class="form-control rounded-0 g-brd-gray-light-v3 g-px-20 g-py-15" type="text" placeholder="Search by Doctor name">
            </div>

            <div class="col-sm-3 col-lg-2 g-px-0--sm g-mb-30">
              <button class="btn btn-block u-btn-primary g-color-white g-bg-primary-dark-v1--hover g-font-weight-600 rounded-0 g-px-18 g-py-15" type="submit">
                Search
              </button>
            </div>
          </div>
        </form>
        <!-- End Input Group -->
      </div>
<section>
	<div class="container">
		<div class="row mt-20">
			<div class="row mx-5 mb-3">
				<div class="col-12">
					<div class="u-heading-v2-1--bottom g-mb-30">
						<h2 class="u-heading-v2__title g-mb-10 text-uppercase g-color-primary g-font-weight-600"> Consult top doctors online for any health concern</h2>
						<h4 class="g-font-weight-200">Private online consultations with verified doctors in all specialists</h4>
					</div>
				</div>
			</div>
		</div>
		<!-- Team Block -->
		<div class="row feature-doctor-div">
		@foreach($specialities as $s)
			<div class="col-6 col-sm-4 col-lg-2 g-mb-40">
				<a href="{{route('w.department',$s->slug)}}" class="g-font-size-14 g-color-primary--hover" style="cursor:pointer; text-decoration:none;">
					<!-- Figure -->
					<figure class="text-center">
						<!-- Figure Image -->
						<div class="mx-auto g-width-130 g-height-130 g-mb-15">
							<img class="g-width-120 g-height-120 rounded-circle" src="{{asset($s->photo ? $s->photo :'front/assets/images/placeholder.jpg')}}" alt="{{$s->title}}">
						</div>
						<!-- End Figure Image -->
						<!-- Figure Info -->
						<h4 class="h6 g-color-black g-font-weight-700 g-mb-5">{{$s->title}}</h4>
						Consult Now
						<!-- End Info -->
					</figure>
					<!-- End Figure -->
				</a>
			</div>
		@endforeach
			<div class="col text-center">
				<a href="{{ route('specialities') }}" class="btn btn-primary">See More</a>
			</div>
		</div>
	</div>
	<!-- End Team Block -->
</section>
<!-- Speciality end -->
<!-- Article start -->
{{-- <section>
	<div class="row no-gutters">
		<!-- Info Image -->
		<div class="col-lg-5 g-min-height-360 g-bg-size-cover g-bg-pos-center" data-bg-img-src="{{asset('front/assets/images/article.jpg')}}"></div>
		<!-- End Info Image -->

		<div class="col-lg-7 g-bg-gray-dark-v1 g-pt-100 g-pb-80 g-px-80">
			<header class="text-uppercase g-mb-35">
				<div class="g-mb-30">
					<h2 class="h2 g-color-white g-font-weight-700 mb-0">
						Read top articles from health experts
					</h2>
				</div>
				<div class="g-width-70 g-brd-bottom g-brd-2 g-brd-primary"></div>
			</header>

			<p class="g-color-white-opacity-0_7 g-mb-30">
				Health articles that keep you informed about good health practices and achieve your goals.
			</p>
			<a href="#!" class="btn btn-md u-btn-primary g-mr-10 g-mb-25">
				Read all
			</a>

			<div class="row align-items-stretch">
				<div class="col-sm-6 g-mb-30">
					<!-- Article -->
					<article class="h-100 g-flex-middle g-brd-left g-brd-3 g-brd-primary g-brd-white--hover g-bg-black-opacity-0_8 g-transition-0_3 g-pa-20">
						<div class="g-flex-middle-item">
							<h4 class="h6 g-color-white g-font-weight-600 text-uppercase g-mb-10">Agency Search</h4>
							<p class="g-color-white-opacity-0_7 mb-0">
								Interprofessional Healthcare: Leading the Way to Improved Quality of Care
							</p>
						</div>
					</article>
					<!-- End Article -->
				</div>

				<div class="col-sm-6 g-mb-30">
					<!-- Article -->
					<article class="h-100 g-flex-middle g-brd-left g-brd-3 g-brd-primary g-brd-white--hover g-bg-black-opacity-0_8 g-transition-0_3 g-pa-20">
						<div class="g-flex-middle-item">
							<h4 class="h6 g-color-white g-font-weight-600 text-uppercase g-mb-10">Management &amp; Marketing</h4>
							<p class="g-color-white-opacity-0_7 mb-0">
								Dementia and a Healthy Diet - What is the Connection?
							</p>
						</div>
					</article>
					<!-- End Article -->
				</div>
			</div>

			<div class="row align-items-stretch">
				<div class="col-sm-6 g-mb-30">
					<!-- Article -->
					<article class="h-100 g-flex-middle g-brd-left g-brd-3 g-brd-primary g-brd-white--hover g-bg-black-opacity-0_8 g-transition-0_3 g-pa-20">
						<div class="g-flex-middle-item">
							<h4 class="h6 g-color-white g-font-weight-600 text-uppercase g-mb-10">Coaching &amp; Planning</h4>
							<p class="g-color-white-opacity-0_7 mb-0">
								Guidelines for a Happy, Healthy New Year
							</p>
						</div>
					</article>
					<!-- End Article -->
				</div>

				<div class="col-sm-6 g-mb-30">
					<!-- Article -->
					<article class="h-100 g-flex-middle g-brd-left g-brd-3 g-brd-primary g-brd-white--hover g-bg-black-opacity-0_8 g-transition-0_3 g-pa-20">
						<div class="g-flex-middle-item">
							<h4 class="h6 g-color-white g-font-weight-600 text-uppercase g-mb-10">Consulation Services</h4>
							<p class="g-color-white-opacity-0_7 mb-0">
								Supporting global automotive innovation with adhesive technology
							</p>
						</div>
					</article>
					<!-- End Article -->
				</div>
			</div>
		</div>
	</div>
	<!-- End Info Blocks -->
</section> --}}
<!-- Article end -->
<!--  Feature doctor start -->
<section>
	<div class="container g-pt-30">
		<!-- Title -->
		<div class="row mx-5 mb-3">
			<div class="col-12">
				<div class="u-heading-v2-1--bottom g-mb-30">
					<h2 class="u-heading-v2__title g-mb-10 text-uppercase g-color-primary g-font-weight-600">FEATURED DOCTOR</h2>
					<h4 class="g-font-weight-200">Find experience doctors for your problem</h4>
				</div>
			</div>
		</div>
		<!-- End title -->
		<!-- Doctor row start -->
		<div class="row mx-5">
			@foreach($doctors as $doctor)
		
			<div class="col-md-6 col-lg-4 g-mb-30">
				<a class="g-color-primary--hover" style="text-decoration:none;" href="{{route('w.doctor.details',$doctor->slug)}}">
				<div class="media g-mb-25">
					<img class="d-flex align-self-center g-brd-around g-brd-4 g-brd-white rounded-circle mr-4" src="{{ asset($doctor->photo ? $doctor->photo : 'web/images/avatar.png') }}" height="100" width="100" alt="Image Description">

					<div class="media-body align-self-center" style="cursor:pointer;">
						<h4 class="h5 g-font-weight-700 g-mb-3">{{ $doctor->title }} {{ str_limit($doctor->full_name,15,'...') }}</h4>
						<em class="d-block g-color-gray-dark-v5 g-font-style-normal g-font-size-13">{{ $doctor->department->title }}</em>
						<i class="icon-check g-pos-rel g-top-1 g-color-gray-dark-v5 g-mr-5"></i> Verified
					</div>
					
				</div>
				</a>
			</div>
			
			@endforeach
		</div>
	</div>
	<!-- Doctor row end -->

</section>
<!-- Feature doctor end -->
<!-- Testimonials start -->
{{-- <section>
	<div class="row">
		<div class="col-12 u-divider-center">
			<h3 class="u-heading-v2__title g-mb-10 text-uppercase g-color-primary g-font-weight-600">What our users have to say
			</h3>
		</div>
	</div>
	<div class="row mb-5">
		<div class="col-12">
			<div class="js-carousel g-pb-70" data-infinite="true" data-arrows-classes="u-arrow-v1 g-width-40 g-height-40 g-color-gray-dark-v5 g-bg-white g-color-white--hover g-bg-primary--hover rounded g-absolute-centered--x g-bottom-0" data-arrow-left-classes="fa fa-angle-left g-ml-minus-25" data-arrow-right-classes="fa fa-angle-right g-ml-25">
				<div class="js-slide">
					<!-- Testimonials Advanced -->
					<div class="row justify-content-center">
						<div class="col-lg-8">
							<div class="text-center">
								<img class="d-inline-block g-width-120 g-height-120 g-brd-around g-brd-5 g-brd-white rounded-circle" src="{{asset('front/assets/img-temp/125x125/img4.jpg')}}" alt="Image Description">

								<div class="g-py-25">
									<h4 class="h5 g-color-black text-uppercase g-mb-0">Mary Brown</h4>
									<em class="g-color-primary">Designer</em>
								</div>

								<blockquote class="lead g-line-height-1_8 g-mb-25">" Thanks a lot. You have no idea how much I appreciate all your help. You are not just a great designer but an amazing human being, because so many people won't give a rat ass about what happen to their clients AFTER THE SALE,
									and you are not. Again, thanks a lot. "</blockquote>

								<div class="js-rating align-self-center g-color-yellow" data-rating="5" data-spacing="5" data-backward-icons-classes="fa fa-star"></div>
							</div>
						</div>
					</div>
					<!-- End Testimonials Advanced -->
				</div>

				<div class="js-slide">
					<!-- Testimonials Advanced -->
					<div class="row justify-content-center">
						<div class="col-lg-8">
							<div class="text-center">
								<img class="d-inline-block g-width-120 g-height-120 g-brd-around g-brd-5 g-brd-white rounded-circle" src="{{asset('front/assets/img-temp/125x125/img5.jpg')}}" alt="Image Description">

								<div class="g-py-25">
									<h4 class="h5 g-color-black text-uppercase g-mb-0">Alex Moura</h4>
									<em class="g-color-primary">Developer</em>
								</div>

								<blockquote class="lead g-line-height-1_8 g-mb-25">" Your customer support is the best I have experienced with any theme I have purchased. You have a theme that far exceeds all others. Thanks for providing such a fantastic theme, all your efforts are greatly appreciated on our
									end. "</blockquote>

								<div class="js-rating align-self-center g-color-yellow" data-rating="5" data-spacing="5" data-backward-icons-classes="fa fa-star"></div>
							</div>
						</div>
					</div>
					<!-- End Testimonials Advanced -->
				</div>
			</div>
		</div>
	</div>
</section> --}}
<!-- End Testimonials -->
@endsection
