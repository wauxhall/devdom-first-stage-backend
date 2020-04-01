<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'prefix' => 'app',
    'namespace' => 'Api\Auth'
], function() {
    Route::post('register', 'RegisterController@registerAppUser');
    Route::post('login', 'LoginController@loginByAppSign');
});

Route::group([
    'middleware' => 'auth:api',
    'namespace' => 'Api'
], function() {

    Route::get( 'study_materials', 'StudyMaterialController@index');
    Route::get( 'study_materials/{study_material}', 'StudyMaterialController@show');
    Route::post('study_materials/create', 'StudyMaterialController@create');
    Route::post('study_materials/update/{study_material}', 'StudyMaterialController@update');
    Route::post('study_materials/delete/{study_material}', 'StudyMaterialController@destroy');

    Route::get( 'categories', 'StudyMaterialCategoryController@index');
    Route::get( 'categories/{category}', 'StudyMaterialCategoryController@show');
    Route::post('categories/create', 'StudyMaterialCategoryController@create');
    Route::post('categories/update/{category}', 'StudyMaterialCategoryController@update');
    Route::post('categories/delete/{category}', 'StudyMaterialCategoryController@destroy');

    Route::post('study_material_links/create', 'StudyMaterialLinkController@create');
    Route::post('study_material_links/update', 'StudyMaterialLinkController@update');
    Route::post('study_material_links/delete', 'StudyMaterialLinkController@destroy');
});

Route::get( 'study_material_types', 'Api\StudyMaterialTypeController@index');
Route::get( 'author_types', 'Api\AuthorTypeController@index');
