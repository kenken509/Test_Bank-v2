<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SubjectCodeController;
use App\Http\Controllers\UserManagementController;

Route::get('/', function () {
    return inertia('Index/Index');
});

Route::controller(AuthController::class)->group(function(){
    Route::get('/login', 'create')->name('login.show');
    Route::post('/login', 'store')->name('login.store');
    Route::delete('/logout', 'destroy')->name('logout');
});

Route::controller(UserManagementController::class)->group(function(){
    Route::get('/test_bank/users', 'showUsers')->name('users.show');
    Route::get('/test_bank/user/add', 'showAddUser' )->name('user.add');
    Route::post('/test_bank/new-user/store', 'storeUser')->name('user.store');
    Route::delete('test_bank/user/delete/{id}', 'deleteUser')->name('user.delete');
    Route::get('test_bank/user/update/{id}', 'updateUserShow')->name('user.update');
    Route::put('test_bank/user/update/store', 'updateUserStore')->name('user.update.store');
});

Route::controller(DashboardController::class)->group(function(){
    Route::get('/dashboard', 'showDashboard')->name('dashboard.show');
});



Route::controller(DepartmentController::class)->group(function(){
    Route::get('/departments', 'showDepartment')->name('departments.show');
    Route::get('/department/add', 'addDepartment')->name('department.add');
    Route::delete('/test_bank/departments/delete/{id}','destroy')->name('department.delete');
    Route::post('/test_bank/departments/store', 'storeDepartment')->name('department.store');
    Route::get('/test_bank/departments/update/{id}','updateDepartmentShow')->name('department.update.show');
    Route::put('/test_bank/departments/update/store', 'updateDepartment')->name('department.update');
});

Route::controller(DivisionController::class)->group(function(){
    Route::get('/test_bank/divisions', 'showDivision')->name('division.show');
    Route::delete('/test_bank/divisions/delete/{id}', 'destroy')->name('division.delete');
    Route::get('/test_bank/divisions/add', 'addDivision')->name('division.add');
    Route::post('/test_bank/divisions/store', 'storeDivision')->name('division.store');
    Route::get('/test_bank/divisions/update/{id}', 'updateShow')->name('division.update.show');
    Route::put('/test_bank/divisions/update/store', 'storeUpdate')->name('division.update.store');
});

Route::controller(SubjectCodeController::class)->group(function(){
    Route::get('/test_bank/subject_codes', 'showSubjectCodes')->name('subject.codes.show');
    Route::delete('/test_bank/subject_code/delete/{id}', 'destroy')->name('subject.codes.delete');
    Route::get('/test_bank/subject_codes/add', 'showAddSubjectCode')->name('subject.codes.add.show');
    Route::post('/test_bank/subject_codes/store', 'store')->name('subject.codes.store');
    Route::get('/test_bank/subject_codes/update/{id}', 'updateShow')->name('subject.codes.update.show');
    Route::put('/test_bank/subject_codes/update/store', 'update')->name('subject.codes.update');
});

Route::controller(QuestionController::class)->group(function(){
    Route::get('/test_bank/questions', 'showQuestions')->name('questions.show');
    Route::delete('/test_bank/questions/delete/{id}', 'destroy')->name('questions.delete');
    Route::get('/test_bank/questions/add', 'showAddQuestion')->name('question.add');
    Route::post('/test_bank/question/store', 'storeQuestion')->name('question.store');
});