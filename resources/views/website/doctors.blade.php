@extends('website.components.app')

@section('title') {{ __('doctor.all_doctor') }} @endsection

@section('content')
    <div class="page-banner"
         style="background-image: url('{{ asset('web/images/b8cb9975d682ff9c6c1aa57192db086e.jpg') }}')">
        <h4 class="title text-center pt-4">{{ __('website.title_subtitle.meet_doctor') }}
            <span>{{ __('website.title_subtitle.meet_doctor_subtitle') }}</span></h4>
    </div>

    <div class="container">
        <form action="{{ route('w.doctors') }}" method="get">
            <div class="form-row" id="doctorFilterForm">
                <div class="col-md-5">
                    <input type="text" name="doctor" value="{{ request()->query('doctor') }}" class="form-control"
                           placeholder="{{ __('website.form.search_doctor') }}"/>
                </div>
                <div class="col-md-5">
                    <select name="department" class="form-control">
                        <option value="">{{ __('website.form.select_department') }}</option>
                        @foreach($departments as $department)
                            <option {{ setSelectOption(request()->query('department'), $department->id) }} value="{{ $department->id }}">{{ $department->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-block btn-primary rounded-0"><i
                                class="fas fa-search"></i> {{ __('website.form.search') }}</button>
                </div>
            </div>
        </form>


        <div class="row justify-content-md-center">
            @foreach($doctors as $doctor)
                <div class="col-md-4">
                    <div class="card doctor mb-4">
                        <div class="doctor-img">
                            <img src="{{ asset($doctor->photo ? $doctor->photo : 'web/images/avatar.png') }}"
                                 class="card-img-top" alt="..."/>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $doctor->title }} {{ str_limit($doctor->full_name,12,'...') }}
                                <span>{{ $doctor->department->title }}</span></h5>
                            <p class="card-text">
                                {{ $doctor->info }}
                            </p>
                            <a href="{{ route('w.appointment','doctor='.encrypt($doctor->id)) }}"
                               class="btn btn-primary rounded-0">{{ __('website.nav.get_appointment') }}</a>
                            <a href="{{ route('w.doctor.details',['encrypted_id'=> $doctor->slug]) }}"
                               class=" btn btn-link float-right"> {{ __('website.learn_more') }} <i
                                        class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row pt-4 pb-5">
            <div class="col-md-6">
                <h5>Showing doctors {{ $doctors->firstItem() }} to {{ $doctors->lastItem() }} out
                    of {{ $doctors->total() }}</h5>
            </div>
            <div class="col-md-6">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        {{ $doctors->appends(request()->all())->links() }}
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection