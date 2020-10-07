<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua-gradient">
            <div class="inner">
                <h3 id="createdPatient">{{ \App\Models\Patient::where('created_by',$user->id)->count() }}</h3>
                <p>Patients</p>
            </div>
            <div class="icon">
                <i class="ion ion-android-contact"></i>
            </div>
{{--            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-light-blue-gradient">
            <div class="inner">
                <h3>{{ \App\Models\Doctor::where('created_by', $user->id)->count() }}</h3>

                <p>Doctors</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
{{--            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue-gradient">
            <div class="inner">
                <h3>{{ \App\Models\Assistant::where('created_by', $user->id)->count() }}</h3>

                <p>Assistant</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
{{--            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-light-blue-active">
            <div class="inner">
                <h3>{{ \App\Models\Appointment::where('created_by', $user->id)->count() }}</h3>

                <p>Appointment</p>
            </div>
            <div class="icon">
                <i class="ion ion-calendar"></i>
            </div>
{{--            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-maroon">
            <div class="inner">
                <h3>{{ \App\Models\Drug::where('created_by', $user->id)->count() }}</h3>

                <p>Drugs</p>
            </div>
            <div class="icon">
                <i class="ion ion-medkit"></i>
            </div>
{{--            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-maroon-active">
            <div class="inner">
                <h3>{{ \App\Models\Department::where('created_by', $user->id)->count() }}</h3>

                <p>Department</p>
            </div>
            <div class="icon">
                <i class="ion ion-android-clipboard"></i>
            </div>
{{--            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-fuchsia-active">
            <div class="inner">
                <h3>{{ \App\Models\Admin::where('created_by', $user->id)->count() }}</h3>

                <p>Admin</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-stalker"></i>
            </div>
{{--            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-fuchsia">
            <div class="inner">
                <h3>{{ \App\Models\PatientPayment::where('created_by', $user->id)->count() }}</h3>

                <p>Payment</p>
            </div>
            <div class="icon">
                <i class="ion ion-cash"></i>
            </div>
{{--            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-gray-active">
            <div class="inner">
                <h3>{{ \App\Models\PatientMedicalDocument::where('created_by', $user->id)->count() }}</h3>

                <p>Medical Document</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-medical"></i>
            </div>
{{--            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-black-gradient">
            <div class="inner">
                <h3>{{ \App\Models\PatientMedicalNote::where('created_by', $user->id)->count() }}</h3>

                <p>Medical Note</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-medical"></i>
            </div>
{{--            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
        </div>
    </div>
</div>

