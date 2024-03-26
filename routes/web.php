<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\ProjectController;
use App\Services\FetchUserRoles;


Route::get('/', function () {
    return view('welcome');
});
//Auth Routes
Route::get('register', [AuthController::class, 'create'])->name('register');
Route::post('register', [AuthController::class, 'store']);
Route::get('login', [AuthController::class, 'index'])->name('auth.login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);

//Users Routes

Route::group(['middleware' => ['auth', 'role:']], function () {

    Route::resource('users', UserController::class);
    Route::resource('invites', InviteController::class);

});
Route::get('/assign-role', [UserController::class, 'assignRoleForm'])->name('user.assignRoleForm');
Route::post('/assign-role', [UserController::class, 'assignRole'])->name('user.assignRole');

//Admin Routes
Route::resource('admins', AdminController::class);
Route::delete('/admins/{id}', 'AdminController@destroy')->name('admins.destroy');

//Projects Routes
Route::resource('projects', ProjectController::class);


//Roles and Permissions
Route::resource('permissions', PermissionController::class);
Route::delete('permissions/{id}', 'PermissionController@destroy')->name('permissions.destroy');
Route::resource('roles', RoleController::class);
Route::delete('roles/{id}', 'RoleController@destroy')->name('roles.destroy');
Route::get('roles/{roleid}/give-permissions', [RoleController::class, 'addPermissiontoRole'])->name('addPermissiontoRole');
Route::put('roles/{roleid}/give-permissions', [RoleController::class, 'givePermissiontoRole'])->name('givePermissiontoRole');
Route::resource('users', UserController::class);
Route::delete('users/{id}', 'UserController@destroy')->name('user.destroy');
