<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/students','App\Http\Controllers\StudentController@index')->name('student.index');
Route::post('/students','App\Http\Controllers\StudentController@store')->name('student.store');
Route::get('/fetch-students','App\Http\Controllers\StudentController@fetchStudent')->name('student.fetch');
Route::get('/delete_students/{id}','App\Http\Controllers\StudentController@deleteStudent')->name('student.delete');
Route::get('/edit_students/{id}','App\Http\Controllers\StudentController@EditStudent');
Route::post('/update_students/{id}','App\Http\Controllers\StudentController@updateStudent');


//task 

Route::get('/task','App\Http\Controllers\TaskController@index')->name('task.index');
Route::post('/addTask','App\Http\Controllers\TaskController@store')->name('task.store');
Route::get('/allTask','App\Http\Controllers\TaskController@all')->name('task.all');