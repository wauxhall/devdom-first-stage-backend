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

Route::post('register', 'Api\RegisterApiUserController@register');

Route::group([
    'middleware' => 'auth:api',
    'namespace' => 'Api'
], function() {

    Route::get('study_materials', 'StudyMaterialController@index');
    Route::get('study_materials/{study_material}', 'StudyMaterialController@show');
    Route::post('study_materials/create', 'StudyMaterialController@create');
    Route::post('study_materials/update/{study_material}', 'StudyMaterialController@update');
    Route::post('study_materials/delete/{study_material}', 'StudyMaterialController@destroy');

    Route::post('study_material_links/create', 'StudyMaterialLinkController@create');
    Route::post('study_material_links/update', 'StudyMaterialLinkController@update');
    Route::post('study_material_links/delete', 'StudyMaterialLinkController@destroy');
});
