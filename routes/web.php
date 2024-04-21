<?php

use App\Livewire\EmployeeList;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware();

Route::get('/employees', EmployeeList::class);
