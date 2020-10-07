<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
    

    Route::post('patient/registration','API\AuthController@Register');
    Route::post('login','API\AuthController@Login');
    Route::get('home', 'API\ApiController@Index');
    Route::get('departments','API\ApiController@Specialities');
    Route::get('department/{slug}', 'API\ApiController@DoctorsInDepartment')->name('api.department');
    Route::get('doctors/search', 'API\ApiController@Search')->name('api.doctors');    
    Route::get('doctor/{slug}', 'API\ApiController@Doctor')->name('api.doctors');    
    Route::get('get/doctor/schedule','API\ApiController@DoctorSchedule')->name('api.get_schedule');
    Route::get('booking','API\ApiController@Booking')->name('api.booking');
     Route::middleware('auth:api', 'active.user', 'patient.only')->group(function () {
        Route::get('check_if_video_active','API\ApiController@CheckIfVideoActive')->name('api.check_if_video_active');
        //booking and payment verification api
        Route::post('book/appointment','API\ApiController@PayNow')->name('api.book_now');
        Route::post('khalti/verification', 'API\APIController@khaltiVerification')->name('api.khalti_verification');
        //End Booking and payment verfication api
         Route::prefix('patient')->group(function () {
             Route::get('appointments', 'API\PatientAPIController@appointments')->name('my.appointments');
             Route::get('appointment/{id}', 'API\PatientAPIController@appointment')->name('my.appointment');
             Route::get('prescriptions', 'API\PatientAPIController@prescriptions')->name('api.web.patient.prescriptions');
             Route::get('payments', 'API\PatientAPIController@payments')->name('api.web.patient.payments');
             Route::get('notes', 'API\PatientAPIController@notes')->name('api.web.patient.notes');
             Route::get('documents', 'API\PatientAPIController@documents')->name('api.web.patient.documents');
             Route::put('my-account','API\PatientAPIController@updateAccount')->name('api.web.patient.update-account');
         });
         Route::prefix('settings')->group(function () {
            Route::post('change-password', 'API\ProfileSettingController@updatePassword')->name('api.update.password');
            Route::post('change-email', 'API\ProfileSettingController@updateEmail')->name('api.update.email');
            Route::post('change-username', 'API\ProfileSettingController@updateUserName')->name('api.update.username');
        });
     });
