<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'admin'], function() {
    
    Route::get('/', 'HomeController@index')->name('home');

    Route::group(['prefix' => 'post'], function() {
        
        Route::get('/view','PostController@view');
        
        Route::get('/new-topic','PostController@newTopic');
        Route::post('/new-topic','PostController@newTopicSave');
    });
    
});

Route::get('/template', function () {
    return view('template');
});