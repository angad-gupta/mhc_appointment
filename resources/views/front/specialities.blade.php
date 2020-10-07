
@extends('front.components.app')
@section('title')
{{ __('website.nav.home') }}
@endsection
@section("content")
<section class="g-bg-gray-light-v5 g-py-50" style="background-image: url({{asset('front/assets/img/bg/pattern2.png')}});">
  <div class="container">
    <div class="d-sm-flex text-center">
      <div class="align-self-center">
        <h2 class="h3 g-font-weight-300 w-100 g-mb-10 g-mb-0--md">Specialities</h2>
      </div>

      <div class="align-self-center ml-auto">
        <ul class="u-list-inline">
          <li class="list-inline-item g-mr-5">
            <a class="u-link-v5 g-color-main" href="{{URL::to('/')}}">Home</a>
            <i class="g-color-gray-light-v2 g-ml-5">/</i>
          </li>
          <li class="list-inline-item g-color-primary">
            <span>Specialities</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>
<section class="g-mt-30">
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
				<!-- Figure -->
				<figure class="text-center">
					<!-- Figure Image -->
					<div class="mx-auto g-width-130 g-height-130 g-mb-15">
						<img class="g-width-120 g-height-120 rounded-circle" src="{{asset($s->photo ? $s->photo :'front/assets/images/placeholder.jpg')}}" alt="{{$s->title}}">
					</div>
					<!-- End Figure Image -->
					<!-- Figure Info -->
					<h4 class="h6 g-color-black g-font-weight-700 g-mb-5">{{$s->title}}</h4>
					<a href="{{route('w.department',$s->slug)}}" class="g-font-size-14 g-color-primary--hover" style="cursor:pointer; text-decoration:none;">Consult Now</a>
					<!-- End Info -->
				</figure>
				<!-- End Figure -->
			</div>
		@endforeach
		</div>
	</div>
	<!-- End Team Block -->
</section>
@endsection