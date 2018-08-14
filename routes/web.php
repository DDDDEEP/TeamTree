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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*
|--------------------------------------------------------------------------
| Resource Routes
|--------------------------------------------------------------------------
*/
Route::apiResource('nodes', 'NodesController');
Route::apiResource('node_user', 'NodeUserController');
Route::apiResource('permissions', 'PermissionsController');
Route::apiResource('permission_role', 'PermissionRoleController');
Route::apiResource('projects', 'ProjectsController');
Route::apiResource('project_user', 'ProjectUserController');
Route::apiResource('roles', 'RolesController');
Route::apiResource('users', 'UsersController');
