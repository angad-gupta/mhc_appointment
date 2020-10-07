<?php

Route::get('/', 'InstallerController@welcome');


    Route::get('/personalization', 'InstallerController@personalization')->name('install.personalization');
    Route::post('/personalization', 'InstallerController@postPersonalization');
    Route::get('/database', 'InstallerController@database')->name('install.database');
    Route::post('database', 'InstallerController@postDatabase');
    Route::get('/mail', 'InstallerController@mail')->name('install.mail');
    Route::post('/mail', 'InstallerController@postMail');
    Route::post('skipping-mail','InstallerController@skippingMail')->name('install.skipping-mail');
    Route::get('admin', 'InstallerController@admin')->name('install.admin');
    Route::post('admin', 'InstallerController@storeAdmin');
    Route::get('install-done','InstallerController@installDone')->name('install.done');
    Route::post('install-done','InstallerController@saveInstallDone');
