@extends('front.components.app')
@section('title')
{{ __('website.nav.home') }}
@endsection
@section('content')
<section class="g-pt-50 g-pb-90">
      <div class="container">
        <div class="row">
            @include('front.components.booking')
        </div>
      </div>
</section>
@endsection