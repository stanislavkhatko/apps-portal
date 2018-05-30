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



//Route::get('hoi', function () {
//    Theme::set('apps_theme_1');
//    return view('apps_theme_1::welcome');
//});

Route::group(['middleware' => ['currentPortal', 'locale']], function() {
    Route::get('authenticate', 'AuthController@show');
    Route::post('authenticate', 'AuthController@login');
    Route::get('authenticate/challenge/{token}', 'AuthController@challenge');

    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::get('/category', 'HomeController@showCategory');
    Route::get('/detail', 'HomeController@showDetail');
    Route::get('page/{page}', ['as' => 'view.page', 'uses' => 'HomeController@viewPage']);
    Route::get('/cancel', ['as' => 'subscription.cancel', 'uses' => 'AuthController@cancelSubscription']);
    Route::post('/cancel', ['as' => 'subscription.unsubscribe', 'uses' => 'AuthController@unsubscribe']);
    Route::post('/change-language', ['as' => 'view.change.language', 'uses' => 'HomeController@changeLocale']);
    Route::get('/exit', ['as' => 'exit', 'uses' => 'HomeController@exit']);

    Route::get('/item/{contentItem}', ['as' => 'view.contentitem', 'uses' => 'HomeController@showItem']);
    Route::get('/contenttype/{localContentType}', ['as' => 'view.contenttype', 'uses' => 'HomeController@showContentType']);
    Route::get('/contenttype/{localContentType}/categories', ['as' => 'view.categories', 'uses' => 'HomeController@showCategories']);
    Route::get('/contenttype/{localContentType}/categories/{localCategory}', ['as' => 'view.category', 'uses' => 'HomeController@showCategory']);
    Route::get('/play-trial/{contentItem}', ['as' => 'play-trial.contentitem', 'uses' => 'HomeController@playTrial']);
});

Route::group(['middleware' => 'portal'], function() {
    Route::post('/search', 'HomeController@search');
    Route::get('/play/{contentItem}', ['as' => 'play.contentitem', 'uses' => 'HomeController@playOnline']);
    Route::get('/download/{contentItem}', ['as' => 'download.contentitem', 'uses' => 'HomeController@downloadItem']);

    Route::group(['prefix' => 'api'], function() {
        Route::get('/contenttype/{contentType}/contentitems', ['uses' => 'HomeController@loadContentType']);
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    
    Route::group(['namespace' => 'Backend'], function() {
        Route::resource('content-items', 'ContentItemController', ['except'=>['show']]);
        Route::resource('categories', 'CategoryController');        
        Route::resource('content-types', 'ContentTypeController');
        // Route::resource('local-categories', 'LocalCategoryController');
        Route::resource('local-content-types', 'LocalContentTypeController');
        Route::resource('portal', 'ContentPortalController');
        Route::resource('portal-theme', 'ContentPortalThemeController');
        Route::resource('downloads', 'ContentDownloadController');
        Route::resource('translations', 'TranslationController');
    });

    Route::group(['middleware' => 'auth', 'prefix' => 'api', 'namespace' => 'Api'], function() {

        /** portal **/
        Route::get('/portal/contentitem/{id}', ['uses' => 'ContentPortalController@fetchContentItem']);
        Route::get('/portal/contentitems/{search}', ['uses' => 'ContentPortalController@searchContentItems']);
        Route::get('/portal/contentitem/{id}', ['uses' => 'ContentPortalController@fetchContentItem']);
        Route::get('/portal/{portal}', ['uses' => 'ContentPortalController@show']);
        Route::post('/portal/featured-app/{id}/upload-banner', ['uses' => 'ContentPortalController@uploadFeateredAppBanner']);
        Route::post('/portal', ['uses' => 'ContentPortalController@store']);
        Route::patch('/portal/{id}', ['uses' => 'ContentPortalController@update']); 

        /** portal theme **/
        Route::patch('/portal-theme/{id}', ['uses' => 'ContentPortalThemeController@update']);
        Route::post('/portal-theme/header/{id}/upload', ['uses' => 'ContentPortalThemeController@uploadHeaderImage']);
        Route::post('/portal-theme/navbar/{id}/upload', ['uses' => 'ContentPortalThemeController@uploadNavbarImage']);
        Route::post('/portal-theme/body/{id}/upload', ['uses' => 'ContentPortalThemeController@uploadBodyImage']);
        Route::post('/portal-theme/footer/{id}/upload', ['uses' => 'ContentPortalThemeController@uploadFooterImage']);
        Route::post('/portal-theme/contentTypeHeader/{id}/upload', ['uses' => 'ContentPortalThemeController@uploadContentTypeHeaderImage']);

        /** content type ***/
        Route::get('/content-type/categories/{search}', ['uses' => 'ContentTypeController@searchCategories']);  
        Route::post('/content-type/', ['uses' => 'ContentTypeController@store']);
        Route::patch('/content-type/{id}', ['uses' => 'ContentTypeController@update']); 

        /** categories **/
        Route::post('/category', ['uses' => 'CategoryController@store']);
        Route::patch('/category/{id}', ['uses' => 'CategoryController@update']); 

        /** local content type **/
        Route::get('/local-content-type/provider/{provider}/{search}', ['uses' => 'LocalContentTypeController@searchContentTypes']); 
        Route::get('/local-content-type/categories/provider/{provider}/{search}', ['uses' => 'LocalContentTypeController@searchCategories']); 
        Route::get('/local-content-type/local-category/{localID}/category/{providerID}/content-items', ['uses' => 'LocalContentTypeController@getContentItemsFromLocalCategoryAndCategory']);   
        Route::post('/local-content-type', ['uses' => 'LocalContentTypeController@store']);
        Route::patch('/local-content-type/{content_item}', ['uses' => 'LocalContentTypeController@update']);  
        Route::post('/local-content-type/content-items/sync', ['uses' => 'LocalContentTypeController@syncContentItems']);
        Route::post('/local-content-type/{id}/upload-icon', ['uses' => 'LocalContentTypeController@uploadIcon']);

        /** content item ***/
        Route::post('/content-item/{id}/upload-image', ['uses' => 'ContentItemController@uploadContentItemImage']);
        Route::post('/content-item/{id}/upload-file', ['uses' => 'ContentItemController@uploadContentItemFile']);
        Route::post('/content-item', ['uses' => 'ContentItemController@store']);
        Route::patch('/content-item/{content_item}', ['uses' => 'ContentItemController@update']);  
        Route::get('/content-item/content-type/{id}/categories', ['uses' => 'ContentItemController@getCategories']); 
        Route::get('/content-item/content-type/{id}/categories/{search}', ['uses' => 'ContentItemController@searchCategories']);  

        /** translations **/
        Route::post('/translations', ['uses' => 'TranslationController@store']);
        Route::patch('/translations', ['uses' => 'TranslationController@update']);  
    });

});
Route::get('{msisdn}', 'AuthController@validateMsisdn');
