<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\GradeController;
use App\Http\Controllers\Api\TeacherController;

//User
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::group(['middleware' => ["auth:sanctum"]], function(){
    Route::get('user-profile', [UserController::class, 'userProfile']);
    Route::get('logout', [UserController::class, 'logout']);

    //Teacher
Route::post('registerTeacher', [TeacherController::class, 'registerTeacher']);
Route::post('updateTeacher', [TeacherController::class, 'updateTeacher']);
Route::delete('deleteTeacher', [TeacherController::class, 'deleteTeacher']);
Route::post('readTeacher', [TeacherController::class, 'readTeacher']);

//Grade
Route::post('registerGrade', [GradeController::class, 'registerGrade']);
Route::post('updateGrade', [GradeController::class, 'updateGrade']);
Route::delete('deleteGrade', [GradeController::class, 'deleteGrade']);
Route::post('readGrade', [GradeController::class, 'readGrade']);

//Student
Route::post('registerStudent', [StudentController::class, 'registerStudent']);
Route::post('updateStudent', [StudentController::class, 'updateStudent']);
Route::delete('deleteStudent', [StudentController::class, 'deleteStudent']);
Route::post('readStudent', [StudentController::class, 'readStudent']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
