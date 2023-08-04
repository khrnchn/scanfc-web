<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\FileAccessController;
use App\Http\Controllers\PermissionController;

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

// view exemption file
Route::get('/exemption/serve/{fileName}', [FileAccessController::class, 'exemptionServe']);

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard', function () {
        return view('dashboard');
    })
    ->name('dashboard');

Route::get('/read-nfc', 'NFCController@readNFC');

Route::prefix('/')
    ->middleware(['auth:sanctum', 'verified'])
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('attendances', AttendanceController::class);
        Route::resource('classes', ClassroomController::class);
        Route::resource('faculties', FacultyController::class);
        Route::resource('lecturers', LecturerController::class);
        Route::resource('users', UserController::class);
        Route::resource('subjects', SubjectController::class);
        Route::resource('students', StudentController::class);
        Route::resource('sections', SectionController::class);
    });
