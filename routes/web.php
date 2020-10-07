<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'WebSiteController@index')->name('/');
Route::get('/lang/{lang}', 'WebSiteController@changeLang')->name('change-language');
Route::get('/contact', 'WebSiteController@contact')->name('contact');
Route::get('/success', 'WebSiteController@success')->name('success');

Route::get('patient/home', 'PatientHomeController@index');

Route::get('schedule-details/date={date}/doctor={doctor_id}', 'WebAppointmentController@getScheduleDetails');
//this needs to be reactivated
//Route::post('save-appointment', 'WebAppointmentController@storeAppointment')->name('save-appointment');

// Web routes
Route::prefix('mero')->middleware('video_call_on')->group(function () {
    Route::get('appointment', 'WebSiteController@appointment')->name('w.appointment');
    Route::get('specialities','WebsiteController@Specialities')->name('w.specialities');
    Route::get('doctors', 'WebSiteController@Search')->name('w.doctors');
    Route::get('specialities','WebSiteController@Specialities')->name('specialities');
    Route::get('department/{slug}', 'WebSiteController@DepartmentDoctors')->name('w.department');
    Route::get('doctor/{slug}', 'WebSiteController@doctor')->name('w.doctor.details');
    Route::get('get/schedules','WebSiteController@GetSchedules')->name('get.schedules');
    Route::get('get/doctor','WebSiteController@GetDoctor')->name('get.doctor');    
    Route::post("pay-now",'WebSiteController@PayNow')->name('pay_now');
    Route::post('khalti_verification','WebSiteController@khaltiVerification')->name('khalti_verification');
    Route::get('payment_success','WebSiteController@PayMentSuccess')->name('payment_success');
    Route::get('payment_failed','WebSiteController@PayMentFailed')->name('payment_failed');
    Route::get('payment_success_khalti','WebSiteController@PayMentSuccessKhalti')->name('payment_success_khalti');

    Route::get('booking','WebSiteController@Booking')->name('start.booking')->middleware('auth:extra_user');

    Route::middleware('auth:extra_user')->group(function () {
        Route::prefix('patient')->group(function () {
            Route::get('appointments', 'PatientOperationController@appointments')->name('web.patient.appointments');
            Route::get('appointment/{id}', 'PatientOperationController@appointment')->name('web.patient.appointment');
            Route::get('prescriptions', 'PatientOperationController@prescriptions')->name('web.patient.prescriptions');
            Route::get('payments', 'PatientOperationController@payments')->name('web.patient.payments');
            Route::get('notes', 'PatientOperationController@notes')->name('web.patient.notes');
            Route::get('documents', 'PatientOperationController@documents')->name('web.patient.documents');
            Route::put('my-account','PatientOperationController@updateAccount')->name('web.patient.update-account');
            Route::get('setting', 'PatientOperationController@setting')->name('web.patient.setting'); 
            Route::post('change-password', 'PatientOperationController@updatePassword')->name('patient.update.password'); 
        });
        
        Route::prefix('room')->group(function() {
            Route::get('/patient/join/{roomName}', 'AppointmentController@patientRoom')->name('join.patient_room');
        });
    });
});

Route::prefix('test')->group(function(){
    Route::get('/',function(){
        return view('front.index');
    });
    Route::get('/appointment',function(){
        return view('front.appointment');
    });
    Route::get('/doctors',function(){
        return view('front.doctors');
    });
    Route::get('/contact',function(){
        return view('front.contact');
    });
    Route::get('/search',function(){
        return view('front.search');
    });
    Route::get('/booking',function(){
        return view('front.booking');
    });
    Route::get('signup',function(){
        return view('front.signup');
    });
});



Auth::routes();
//patient register
Route::get("register/user",'Auth\SecondaryAuth\RegisterController@ShowPatientRegistrationForm')->name('register.patient_form');
Route::post("user/register",'Auth\SecondaryAuth\RegisterController@RegisterPatients')->name('register.patients');
//doctor register
Route::post("register/doctors",'Auth\RegisterController@RegisterDoctors')->name('register.doctors');

//admin login
Route::group(['prefix' => 'admin'], function () {        
    Route::get('/login', 'Auth\LoginController@showAdminLoginForm');
    Route::post('/login', 'Auth\LoginController@checkAdminLogin')->name('admin.login');
});

//doctor login
Route::group(['prefix' => 'doctor'], function() {
    Route::post('/login', 'Auth\LoginController@checkDoctorLogin')->name('doctor.login');
});

//patient login
Route::group(['prefix' => 'patient'], function() {
    Route::get('/login', 'Auth\SecondaryAuth\LoginController@showPatientLoginForm')->name('patient.login');
    Route::post('/login', 'Auth\SecondaryAuth\LoginController@checkPatientLogin')->name('patient.login');
    Route::post('/logout', 'Auth\SecondaryAuth\LoginController@logout')->name('patient.logout');

    Route::post('/password/email','Auth\SecondaryAuth\ForgotPasswordController@sendResetLinkEmail')->name('patient_password.email');
	Route::post('/password/reset','Auth\SecondaryAuth\ResetPasswordController@reset');
	Route::get('/password/reset','Auth\SecondaryAuth\ForgotPasswordController@showLinkRequestForm')->name('patient_password.request');
	Route::get('/password/reset/{token}','Auth\SecondaryAuth\ResetPasswordController@showResetForm')->name('patient_password.reset');
    
    Route::get('auth/{provider}', 'Auth\SecondaryAuth\SocialRegisterController@redirectToProvider')->name('social-provider');

    Route::get('/email/verify','Auth\SecondaryAuth\VerificationController@show')->name('patient_verification.notice');
    Route::get('/email/resend','Auth\SecondaryAuth\VerificationController@resend')->name('patient_verification.resend');
    Route::get('/email/verify/{code}','Auth\SecondaryAuth\VerificationController@verify')->name('patient_verification.verify');
});
Route::get('signin/{provider}/callback', 'Auth\SecondaryAuth\SocialRegisterController@handleProviderCallback');


// Print prescription by id
Route::get('print/prescription/{id}', 'PrescriptionController@print')->name('prescription.print');

//Print Payment by id
Route::get('print/payment/{id}', 'PatientPaymentController@print')->name('payment.print');

// Contact query
Route::resource('contact-query', 'ContactQueryController');

// Active user only
Route::middleware('auth', 'active.user','video_call_on')->group(function () {

    // App Setup
    Route::get('settings/app-setup', 'AppSetupController@index')->name('app.setup')->middleware('super.admin');
    Route::post('mail-setup', 'AppSetupController@saveMail')->name('mail.setup')->middleware('super.admin');
    Route::post('app-setup', 'AppSetupController@saveApp')->name('store.app.setup')->middleware('super.admin');
    Route::post('config-cache', 'AppSetupController@configCache')->name('config.cache')->middleware('super.admin');
    Route::get('settings/website-setup', 'WebSiteController@webSiteSetup')->name('website.setup');
    Route::post('save-about', 'WebSiteController@saveAbout')->name('store.about')->middleware('super.admin');
    Route::post('save-contact', 'WebSiteController@saveContact')->name('store.contact');

    // Home page for auth user
    Route::get('/home', 'HomeController@index')->name('home');
    Route::prefix('room')->group(function() {
        Route::get('doctor/join/{roomName}', 'AppointmentController@doctorRoom')->name('join.doctor_room');
        Route::get('destroy/{roomName}', 'AppointmentController@destroyRoom')->name('destroy.room');
    });

    Route::prefix('settings')->group(function () {
        Route::post('change-password', 'ProfileSettingController@updatePassword')->name('update.password');
        Route::post('change-email', 'ProfileSettingController@updateEmail')->name('update.email');
        Route::post('change-username', 'ProfileSettingController@updateUserName')->name('update.username');
    });

    // Route for admin, doctor and assistant only
    Route::middleware('not.patient')->group(function () {


        // Mail routes
        Route::prefix('mail')->group(function () {
            Route::post('prescription', 'MailController@prescription')->name('mail.prescription');
            Route::post('payment', 'MailController@payment')->name('mail.payment');
            Route::post('follow-up', 'MailController@followUp')->name('mail.follow-up');
        });

        // Report routes
        Route::prefix('report')->group(function () {
            Route::get('appointment', 'ReportController@appointment')->name('report.appointment');
            Route::get('prescription', 'ReportController@prescription')->name('report.prescription');
            Route::get('drug', 'ReportController@drug')->name('report.drug');
            Route::get('drug-pdf', 'ReportController@drugReportPDF')->name('report.drug.pdf');
            Route::get('payment', 'ReportController@payment')->name('report.payment');
            Route::get('follow-up', 'ReportController@followUp')->name('report.follow-up');

        });

        // Datatables
        Route::get('datatables/appointments', 'AppointmentController@appointmentsDatatable')->name('datatable.appointment');

        Route::resource('admin', 'AdminController');
        Route::resource('drug', 'DrugController');

        // Doctor
        Route::resource('doctor', 'DoctorController');
        Route::post('doctor/approve/listed/{id}','DoctorController@DoctorApprove')->name("doctor.approve");
        Route::post('doctor/reject/listed/{id}','DoctorController@DoctorReject')->name("doctor.reject");
        Route::get('get-doctor/{id}', 'DoctorController@getDoctorByEncId');
        Route::post('update-doctor-profile', 'DoctorController@updateProfile')->name('update.doctor.profile');

        // Patients
        Route::resource('patient', 'PatientController');
        Route::get('patient/{id}/timeline', 'PatientController@timeline')->name('patient.timeline');
        Route::resource('patient-reefer', 'PatientReeferController');

        Route::get('all-patient', 'PatientController@getAllPatient');
        Route::get('get-patient/{id}', 'PatientController@getPatientByEncId');

        // Assistant
        Route::resource('assistant', 'AssistantController');
        Route::post('/update-assistant-profile','AssistantController@updateProfile')->name('update.assistant.profile');

        // Department
        Route::resource('department', 'DepartmentController');

        // Appointment
        Route::resource('appointment', 'AppointmentController');
        Route::post('appointment-status-change', 'AppointmentController@changeStatus')->name('appointment.status.change');
        Route::get('follow-up', 'AppointmentController@followUp')->name('follow-up');
        Route::get('appointment-recent', 'AppointmentController@recentAppointment')->name('recent.appointment');
        Route::get('appointment-on-process', 'AppointmentController@onProcessAppointment')->name('on-process.appointment');
        Route::post('quick-appointment', 'AppointmentController@quickAppointment')->name('quick.appointment');
        Route::post('finish-appointment', 'AppointmentController@finishAppointment')->name('finish.appointment');
        Route::post('start-appointment', 'AppointmentController@startAppointment')->name('start.appointment');
         

        // Appointment Follow Up
        Route::resource('follow-up-note', 'FollowUpNoteController');

        // Prescription
        Route::resource('prescription', 'PrescriptionController');


        // Prescription template
        Route::resource('prescription-template', 'PrescriptionTemplateController')->middleware('doctor.only');
        Route::get('print/prescription-template/{id}', 'PrescriptionTemplateController@print');

        // Prescription Typeahead
        Route::get('typeahead/drug-strength', 'PrescriptionTypeaheadController@drugStrength');
        Route::get('typeahead/drug-dose', 'PrescriptionTypeaheadController@drugDose');
        Route::get('typeahead/drug-advice', 'PrescriptionTypeaheadController@drugAdvice');
        Route::get('typeahead/drug-type', 'PrescriptionTypeaheadController@drugType');

        // Prescription Helpers
        Route::resource('prescription-helper', 'PrescriptionHelperController');

        // Prescription Settings
        Route::resource('prescription-settings', 'PrescriptionSettingController');


        // Medical Document
        Route::resource('patient-document', 'PatientMedicalDocumentController');
        Route::get('patient/{id}/documents', 'PatientMedicalDocumentController@medicalDocuments')->name('patient.documents');

        Route::resource('patient-note', 'PatientMedicalNoteController');
        Route::get('patient/{id}/notes', 'PatientMedicalNoteController@medicalNotes')->name('patient.notes');

        // Patient PaymentTrait
        Route::resource('patient-payment', 'PatientPaymentController');
        Route::get('patient/{id}/payments', 'PatientPaymentController@payments')->name('patient.payments');


        // Calender
        Route::get('calender', 'CalenderController@index')->name('calender');
        Route::get('events', 'CalenderController@events');
        Route::get('event-by-date/{date}', 'CalenderController@getEventsByDate');

        // Schedules
        Route::get('get-schedule-by-dates/{date}', 'ScheduleController@getSchedulesByDate');

        Route::prefix('settings')->group(function () {
            Route::get('mail', 'SettingController@mail')->middleware('super.admin');
            Route::post('mail', 'SettingController@storeMail');

            Route::get('schedule', 'ScheduleController@schedule')->name('my-schedule');
            Route::get('schedule/{id}/create', 'ScheduleController@createSchedule');
            Route::post('schedule', 'ScheduleController@storeSchedule');
            // Route::get('schedule/{id}/edit','ScheduleController@edit')->name('edit-schedule');
            Route::put('schedule/{id}/edit','ScheduleController@updateSchedule');
            Route::delete('schedule/{id}/delete','ScheduleController@deleteSchedule')->name('delete-schedule');

            Route::get('change-password', 'ProfileSettingController@changePassword')->name('change.password');


            Route::get('change-profile', 'ProfileSettingController@changeProfile')->name('change.profile');


            Route::get('profile', 'ProfileSettingController@profile')->name('profile');

            // Invoice Setting
            Route::resource('invoice-setting', 'InvoiceSettingController')->middleware('super.admin');
        });
    });


});


