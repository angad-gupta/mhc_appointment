<?php

Route::get('get-appointment-by-id/{id}','AppointmentController@getAppointmentById');

// JSON APIs for prescription
Route::get('prescription-by-patient/{patient_id}', 'PrescriptionController@prescriptionByPatient');
Route::get('prescription-by-id/{prescription_id}', 'PrescriptionController@prescriptionById');

// JSON APIs for prescription template
Route::get('my-templates','PrescriptionTemplateController@getMyTemplates');
Route::get('my-template-by-id/{id}','PrescriptionTemplateController@getTemplateById');

// JSON APIs for patient reefer
Route::get('appended-doctor/{patient_id}','PatientReeferController@appendedDoctor');
Route::get('detached-doctor/{patient_id}','PatientReeferController@detachedDoctor');


Route::get('drug-by-doctor-department', 'DrugController@getDrugByDoctor');

Route::get('get-all-helpers','PrescriptionHelperController@getHelpers');