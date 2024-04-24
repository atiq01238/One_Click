<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserTaskController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReportedTaskController;
// use Illuminate\Support\Facades\Gate;



Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');
});
//Auth Routes
Route::get('register', [AuthController::class, 'create'])->name('register');
Route::post('register', [AuthController::class, 'store']);
Route::get('login', [AuthController::class, 'index'])->name('auth.login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);


Route::group(['middleware' => ['auth',]], function () {

    //Users Routes
    Route::resource('users', UserController::class);
    //Task Route
    Route::resource('tasks', TaskController::class);
    Route::put('/tasks/{id}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    //Projects Routes
    Route::resource('projects', ProjectController::class);
    //Admin Routes
    Route::resource('admins', AdminController::class);
    //Roles and Permissions
    Route::resource('permissions', PermissionController::class);
    Route::delete('permissions/{id}', 'PermissionController@destroy')->name('permissions.destroy');
    Route::resource('roles', RoleController::class);
    Route::delete('roles/{id}', 'RoleController@destroy')->name('roles.destroy');
    Route::get('roles/{roleid}/give-permissions', [RoleController::class, 'addPermissiontoRole'])->name('addPermissiontoRole');
    Route::put('roles/{roleid}/give-permissions', [RoleController::class, 'givePermissiontoRole'])->name('givePermissiontoRole');
    Route::resource('users', UserController::class);
    Route::delete('users/{id}', 'UserController@destroy')->name('user.destroy');
    Route::get('/assign-role', [UserController::class, 'assignRoleForm'])->name('user.assignRoleForm');
    Route::post('/assign-role', [UserController::class, 'assignRole'])->name('user.assignRole');

});
//Invite Routes
Route::resource('invites', InviteController::class);
//Profile Route
Route::resource('profiles', ProfileController::class);
Route::post('/profiles/storeOrUpdate', [ProfileController::class, 'storeOrUpdate'])->name('profiles.storeOrUpdate');
//UserTask Route
Route::resource('usertasks', UserTaskController::class);
Route::put('/usertasks/{id}/update-status', [UserTaskController::class, 'updateStatus'])->name('usertasks.updateStatus');
//Notifi Route
Route::get('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
//Search Route
Route::get('/search', [SearchController::class, 'search'])->name('search');
//Report Route
Route::resource('reports', ReportedTaskController::class);

// Route::get('tasks/{id}', 'TaskController@show')->name('tasks.show');

