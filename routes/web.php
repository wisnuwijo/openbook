<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    
    Route::get('/', 'HomeController@index')->name('home');

    Route::group(['prefix' => 'documentation'], function() {
        
        Route::get('/view','PostController@view');
        Route::get('/setting/{id}','PostController@setting');
        Route::post('/setting/{id}','PostController@update');
        
        Route::get('/validate-topic-url','PostController@validateTopicUrl');
        Route::get('/new-topic','PostController@newTopicAndVersion');
        Route::post('/new-topic','PostController@newTopicAndVersionSave');

        Route::get('/update','PostController@gotoDocsBulder');
        Route::get('/doc-breakdown','PostController@docsBuilder');

        Route::post('/delete/{id}','PostController@deleteDocs');
    });

    Route::group(['prefix' => 'user-management'], function() {
        
        Route::get('/manage-permission','UserManagementController@managePermission');
        Route::get('/view-user-list','UserManagementController@viewUserList');
        
        Route::get('/create','UserManagementController@create');
        Route::get('/verify-email','UserManagementController@verifyEmail');
        Route::post('/store','UserManagementController@storeUser');
        
        Route::get('/edit/{userId}','UserManagementController@edit');
        Route::post('/update/{userId}','UserManagementController@updateUser');

        Route::post('/delete/{userId}','UserManagementController@deleteUser');
        
        Route::group(['prefix' => 'permission'], function() {
            Route::get('/{roleId}','UserManagementController@getPermission');
            Route::post('/','UserManagementController@updatePermission');
        });
        
    });
    
    Route::group(['prefix' => 'profile'], function() {
        
        Route::get('/','ProfileController@index');

        Route::post('/update/avatar','ProfileController@updateAvatar');
        Route::post('/update/email','ProfileController@updateEmail');
        Route::post('/update/name','ProfileController@updateName');
        Route::post('/update/password','ProfileController@updatePassword');
    });
    
});

Route::group(['prefix' => 'api', 'middleware' => 'auth'], function() {

    Route::group(['prefix' => 'datatable'], function() {
        
        Route::get('topic-list','Api\TopicController@topicList');
        Route::get('user-list','Api\UserController@userList');

    });
    
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
        
        Route::post('topic/update','Api\DocumentationController@updateTopic');
    });
});
