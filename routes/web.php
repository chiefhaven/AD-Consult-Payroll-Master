<?php

use App\Livewire\AddClient;
use App\Livewire\AddEmployee;
use App\Livewire\AddTaxRate;
use App\Livewire\AddUser;
use App\Livewire\Attendances;
use App\Livewire\ClientList;
use App\Livewire\EmployeeList;
use App\Livewire\Leaves;
use App\Livewire\Notifications;
use App\Livewire\Payroll;
use App\Livewire\Reports;
use App\Livewire\Settings;
use App\Livewire\TaxRateList;
use App\Livewire\UserList;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware();

Route::get('/employees', EmployeeList::class)->middleware();
Route::get('/add-employee', AddEmployee::class)->middleware();

Route::get('/clients', ClientList::class)->middleware();
Route::get('/add-client', AddClient::class)->middleware();

Route::get('/payroll', Payroll::class)->middleware();

Route::get('/leaves', Leaves::class)->middleware();

Route::get('/attendances', Attendances::class)->middleware();

Route::get('/tax-rates', TaxRateList::class)->middleware();
Route::get('/add-tax-rate', AddTaxRate::class)->middleware();

Route::get('/notifications', Notifications::class)->middleware();

Route::get('/reports', Reports::class)->middleware();

Route::get('/users', UserList::class)->middleware();
Route::get('/add-user', AddUser::class)->middleware();

Route::get('/settings', Settings::class)->middleware();
