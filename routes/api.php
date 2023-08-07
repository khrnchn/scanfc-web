<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\FacultyController;
use App\Http\Controllers\Api\SubjectController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\LecturerController;
use App\Http\Controllers\Api\ClassroomController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\UserStudentsController;
use App\Http\Controllers\Api\UserLecturersController;
use App\Http\Controllers\Api\FacultyStudentsController;
use App\Http\Controllers\Api\FacultySubjectsController;
use App\Http\Controllers\Api\SubjectSectionsController;
use App\Http\Controllers\Api\StudentSectionsController;
use App\Http\Controllers\Api\SectionStudentsController;
use App\Http\Controllers\Api\FacultyLecturersController;
use App\Http\Controllers\Api\LecturerSubjectsController;
use App\Http\Controllers\Api\SubjectLecturersController;
use App\Http\Controllers\Api\SubjectClassroomsController;
use App\Http\Controllers\Api\SectionClassroomsController;
use App\Http\Controllers\Api\LecturerClassroomsController;
use App\Http\Controllers\Api\StudentAttendancesController;
use App\Http\Controllers\Api\ClassroomAttendancesController;
use App\Http\Controllers\StudentController as ControllersStudentController;
use App\Models\Classroom;

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

// login
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {

        // logout
        Route::get('logout', [AuthController::class, 'logout']);

        // get current login user details
        Route::get('me', [AuthController::class, 'me']);

        // displaying list of today's classes
        Route::get('classrooms', [ClassroomController::class, 'classrooms']);

        // registering nfc card into profile
        Route::post('user/register_nfc', [StudentController::class, 'register_nfc'])->name('user.register_nfc');

        // face to face class (qr) -> attend class (status)
        Route::post('classrooms/{classroom}/attend_online_class', [ClassroomController::class, 'attend_online_class'])->name('classroom.attend_online_class');

        // displaying history of attendance
        Route::get('history', [AttendanceController::class, 'history']);

        // uploading exemption -> file, remarks 
        Route::post('history/{attendance}/upload_exemption', [AttendanceController::class, 'upload_exemption'])->name('attendance.upload_exemption');

        // changing password -> current password, new password
        Route::post('change_password', [AuthController::class, 'change_password']);




        // face to face class (nfc) -> attend class (status)
        // Route::post('classrooms/{classroom}/attend_class', [ClassroomController::class, 'attend_class'])->name('classroom.attend_class');
        
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('attendances', AttendanceController::class);

        // Classroom Attendances
        Route::get('/classrooms/{classroom}/attendances', [
            ClassroomAttendancesController::class,
            'index',
        ])->name('classrooms.attendances.index');
        Route::post('/classrooms/{classroom}/attendances', [
            ClassroomAttendancesController::class,
            'store',
        ])->name('classrooms.attendances.store');

        Route::apiResource('faculties', FacultyController::class);

        // Faculty Students
        Route::get('/faculties/{faculty}/students', [
            FacultyStudentsController::class,
            'index',
        ])->name('faculties.students.index');
        Route::post('/faculties/{faculty}/students', [
            FacultyStudentsController::class,
            'store',
        ])->name('faculties.students.store');

        // Faculty Lecturers
        Route::get('/faculties/{faculty}/lecturers', [
            FacultyLecturersController::class,
            'index',
        ])->name('faculties.lecturers.index');
        Route::post('/faculties/{faculty}/lecturers', [
            FacultyLecturersController::class,
            'store',
        ])->name('faculties.lecturers.store');

        // Faculty Subjects
        Route::get('/faculties/{faculty}/subjects', [
            FacultySubjectsController::class,
            'index',
        ])->name('faculties.subjects.index');
        Route::post('/faculties/{faculty}/subjects', [
            FacultySubjectsController::class,
            'store',
        ])->name('faculties.subjects.store');

        Route::apiResource('lecturers', LecturerController::class);

        // Lecturer Classrooms
        Route::get('/lecturers/{lecturer}/classrooms', [
            LecturerClassroomsController::class,
            'index',
        ])->name('lecturers.classrooms.index');
        Route::post('/lecturers/{lecturer}/classrooms', [
            LecturerClassroomsController::class,
            'store',
        ])->name('lecturers.classrooms.store');

        // Lecturer Subjects
        Route::get('/lecturers/{lecturer}/subjects', [
            LecturerSubjectsController::class,
            'index',
        ])->name('lecturers.subjects.index');
        Route::post('/lecturers/{lecturer}/subjects/{subject}', [
            LecturerSubjectsController::class,
            'store',
        ])->name('lecturers.subjects.store');
        Route::delete('/lecturers/{lecturer}/subjects/{subject}', [
            LecturerSubjectsController::class,
            'destroy',
        ])->name('lecturers.subjects.destroy');

        Route::apiResource('users', UserController::class);

        // User Students
        Route::get('/users/{user}/students', [
            UserStudentsController::class,
            'index',
        ])->name('users.students.index');
        Route::post('/users/{user}/students', [
            UserStudentsController::class,
            'store',
        ])->name('users.students.store');

        // User Lecturers
        Route::get('/users/{user}/lecturers', [
            UserLecturersController::class,
            'index',
        ])->name('users.lecturers.index');
        Route::post('/users/{user}/lecturers', [
            UserLecturersController::class,
            'store',
        ])->name('users.lecturers.store');

        Route::apiResource('subjects', SubjectController::class);

        // Subject Sections
        Route::get('/subjects/{subject}/sections', [
            SubjectSectionsController::class,
            'index',
        ])->name('subjects.sections.index');
        Route::post('/subjects/{subject}/sections', [
            SubjectSectionsController::class,
            'store',
        ])->name('subjects.sections.store');

        // Subject Classrooms
        Route::get('/subjects/{subject}/classrooms', [
            SubjectClassroomsController::class,
            'index',
        ])->name('subjects.classrooms.index');
        Route::post('/subjects/{subject}/classrooms', [
            SubjectClassroomsController::class,
            'store',
        ])->name('subjects.classrooms.store');

        // Subject Lecturers
        Route::get('/subjects/{subject}/lecturers', [
            SubjectLecturersController::class,
            'index',
        ])->name('subjects.lecturers.index');
        Route::post('/subjects/{subject}/lecturers/{lecturer}', [
            SubjectLecturersController::class,
            'store',
        ])->name('subjects.lecturers.store');
        Route::delete('/subjects/{subject}/lecturers/{lecturer}', [
            SubjectLecturersController::class,
            'destroy',
        ])->name('subjects.lecturers.destroy');

        Route::apiResource('students', StudentController::class);

        // Student Attendances
        Route::get('/students/{student}/attendances', [
            StudentAttendancesController::class,
            'index',
        ])->name('students.attendances.index');
        Route::post('/students/{student}/attendances', [
            StudentAttendancesController::class,
            'store',
        ])->name('students.attendances.store');

        // Student Sections
        Route::get('/students/{student}/sections', [
            StudentSectionsController::class,
            'index',
        ])->name('students.sections.index');
        Route::post('/students/{student}/sections/{section}', [
            StudentSectionsController::class,
            'store',
        ])->name('students.sections.store');
        Route::delete('/students/{student}/sections/{section}', [
            StudentSectionsController::class,
            'destroy',
        ])->name('students.sections.destroy');

        Route::apiResource('sections', SectionController::class);

        // Section Classrooms
        Route::get('/sections/{section}/classrooms', [
            SectionClassroomsController::class,
            'index',
        ])->name('sections.classrooms.index');
        Route::post('/sections/{section}/classrooms', [
            SectionClassroomsController::class,
            'store',
        ])->name('sections.classrooms.store');

        // Section Students
        Route::get('/sections/{section}/students', [
            SectionStudentsController::class,
            'index',
        ])->name('sections.students.index');
        Route::post('/sections/{section}/students/{student}', [
            SectionStudentsController::class,
            'store',
        ])->name('sections.students.store');
        Route::delete('/sections/{section}/students/{student}', [
            SectionStudentsController::class,
            'destroy',
        ])->name('sections.students.destroy');
    });
