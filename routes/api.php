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

    'prefix' => 'auth'

], function () {
	Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});


Route::apiResource('/users','UserController');
Route::apiResource('/roles','RoleController');
Route::apiResource('/classes','ClassController');
Route::apiResource('/teachers','TeacherController');
Route::apiResource('/class/pupils','ClasspupilsController');
Route::apiResource('/tests','TestController');
Route::apiResource('/subjects','SubjectController');
Route::apiResource('/teacher/subjects','TeacherSubjectController');
Route::apiResource('/pupils','PupilsController');
Route::apiResource('/grades','GradeController');
Route::apiResource('/archives','ArchiveController');
Route::apiResource('/profiles','ProfileController');