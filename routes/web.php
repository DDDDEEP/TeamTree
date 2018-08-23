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
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test', 'TestController@index')->name('test');


Route::get('/{project}/tree', 'HomeController@showTree')->name('show_tree');
Route::get('/{project}', 'HomeController@showProject')->name('show_project');
Route::get('/{project}/info', 'HomeController@showInfo')->name('show_info');

/*
|--------------------------------------------------------------------------
| Permissions Routes
|--------------------------------------------------------------------------
*/
Route::match(['put', 'patch'], 'nodes/{node}/update_status', 'NodesController@updateStatus')->name('nodes.update.update_status');

/*
|--------------------------------------------------------------------------
| Resource Routes
|--------------------------------------------------------------------------
*/
Route::apiResource('nodes', 'NodesController');
Route::apiResource('node_user', 'NodeUserController');
Route::apiResource('permissions', 'PermissionsController');
Route::apiResource('permission_role', 'PermissionRoleController');
Route::get('/projects/{project}/get_tree', 'ProjectsController@getTree')->name('projects.index.get_tree');
Route::apiResource('projects', 'ProjectsController');
Route::apiResource('project_user', 'ProjectUserController');
Route::apiResource('roles', 'RolesController');
Route::apiResource('users', 'UsersController');
// Route::get('/users/{user}/get_project', 'UsersController@getProject')->name('users.index.get_project');