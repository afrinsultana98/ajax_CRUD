<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\MailController; 



Route::get('/', function () {
    return view('welcome');
});
Route::get('/display/users',[CrudController::class,'showAllUsers']);
Route::get('/add/users',[CrudController::class,'addUser'])->name('addUser');
Route::get('/edit/user',[CrudController::class,'editUser'])->name('editUser');
Route::get('delete/user/{id}',[CrudController::class,'deleteUser'])->name('deleteUser');

Route::get('send-mail',[MailController::class,'index']);