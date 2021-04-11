<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    
    Route::get('/', 'HomeController@index')->name('home');

    Route::group(['prefix' => 'documentation'], function() {
        
        Route::get('/view','PostController@view');
        
        Route::get('/new-topic','PostController@newTopicAndVersion');
        Route::post('/new-topic','PostController@newTopicAndVersionSave');

        Route::get('/doc-breakdown','PostController@docBreakdown');
        Route::get('/doc-breakdownx','PostController@docBreakdownx');
        Route::get('/react',function () {
            return view('react');
        });
    });
    
});

Route::group(['prefix' => 'api', 'middleware' => 'auth'], function() {
    Route::get('doc-breakdown','Api\DocumentationController@getDocBreakdown');
    Route::post('doc-breakdown','Api\DocumentationController@getDocBreakdown');

    Route::post('save-doc-detail','Api\DocumentationController@saveDocDetail');
});
