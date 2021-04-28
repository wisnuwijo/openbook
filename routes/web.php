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
        Route::get('/doc-breakdownx1','PostController@docBreakdownx1');

        Route::get('/react',function () {
            return view('react');
        });
    });
    
});

Route::group(['prefix' => 'api', 'middleware' => 'auth'], function() {
    Route::get('doc-breakdown','Api\DocumentationController@getDocBreakdown');

    Route::group(['prefix' => 'builder'], function() {
        
        Route::group(['prefix' => 'version'], function() {
            Route::get('get','Api\DocumentationController@getVersion');
            Route::post('save','Api\DocumentationController@saveVersion');
        });

        Route::group(['prefix' => 'breakdown'], function() {
            Route::get('get','Api\DocumentationController@getBreakdown');
            Route::post('save','Api\DocumentationController@saveDocBreakdown');
        });

        Route::group(['prefix' => 'breadcrumb'], function() {
            Route::get('get','Api\DocumentationController@getDocBreakcrumb');
            Route::post('update','Api\DocumentationController@updateDocBreakcrumb');
            Route::post('delete','Api\DocumentationController@deleteDocBreakcrumb');
        });
                
        Route::group(['prefix' => 'editor'], function() {
            Route::get('get','Api\DocumentationController@getDocDetail');
            Route::post('save','Api\DocumentationController@saveDocDetail');
        });
        
    });
});
