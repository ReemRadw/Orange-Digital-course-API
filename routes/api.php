<?php

use App\Http\Controllers\Authcontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Skill\SkillController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Instructor\InstructorController;
use GuzzleHttp\Psr7\Request;

Route::post('/auth/login', [Authcontroller::class, 'login'])->name('login');
Route::post('/auth/register', [Authcontroller::class, 'register']);

Route::get('/students/search/{$fname}',[StudentController::class,'search']);

Route::group(["middleware" => "auth:sanctum"], function () {
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{id}', [CourseController::class, 'show']);
    Route::post('/courses', [CourseController::class, 'store']);
    Route::put('/courses/{id}', [CourseController::class, 'update']);
    Route::delete('/courses/{id}', [CourseController::class, 'delete']);
    Route::get('/courses/{id}/students', [CourseController::class, 'getCourseStudents']);
    Route::get('/courses/{id}/instructor', [CourseController::class, 'getCourseInstructor']);
    Route::get('/courses/{id}/requiredskills', [CourseController::class, 'checkCourseHasRequiredSkills']);
    Route::get('/courses/{id}/skills', [CourseController::class, 'getSkillsAfterCompletionOfCourse']);
    Route::put('/courses/{id}/skills', [CourseController::class, 'updateSkills']);
    Route::post('/courses/{id}/addskills', [CourseController::class, 'attachNewSkills']);

    Route::get('/students', [StudentController::class, 'index']);
    Route::get('/students/{id}', [StudentController::class, 'show']);
    Route::post('/students', [StudentController::class, '       store']);
    Route::put('/students/{id}', [StudentController::class, 'update']);
    Route::delete('/students/{id}', [StudentController::class, 'delete']);
    Route::get('/students/{id}/courses', [StudentController::class, 'getStudentCourses']);
    Route::get('/students/{id}/skills', [StudentController::class, 'getStudentSkills']);
    Route::post('/students/{id}/addskills', [StudentController::class, 'attachNewSkills']); //
    Route::delete('/students/{id}/removeskills', [StudentController::class, 'detachSkills']); //
    Route::post('/students/{id}/addcourse', [StudentController::class, 'attachNewCourse']);
    Route::get('/students/{id}/recommend',[StudentController::class,'recommendation']);


    Route::get('/skills', [SkillController::class, 'index']);
    Route::get('/skills/{id}', [SkillController::class, 'show']);
    Route::post('/skills', [SkillController::class, 'store']);
    Route::put('/skills/{id}', [SkillController::class, 'update']);
    Route::delete('/skills/{id}', [SkillController::class, 'delete']);
    Route::get('/skills/{id}/courses', [SkillController::class, 'getCoursesThatHaveSkill']);
    Route::get('/skills/{id}/students', [SkillController::class, 'getStudentsThatHaveSkill']);


    Route::get('/instructors', [InstructorController::class, 'index']);
    Route::get('/instructors/{id}', [InstructorController::class, 'show']);
    Route::post('/instructors', [InstructorController::class, 'store']);
    Route::put('/instructors/{id}', [InstructorController::class, 'update']);
    Route::delete('/instructors/{id}', [InstructorController::class, 'delete']);
    Route::get('/instructors/{id}/courses', [InstructorController::class, 'getCoursesThatBelongToInstructor']);


    Route::post('/auth/logout', [Authcontroller::class, 'logout']);
});



