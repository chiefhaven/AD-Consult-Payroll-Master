<?php

use App\Livewire\Clients\AddClient;
use App\Livewire\Clients\UpdateClient;
use App\Livewire\AddTaxRate;
use App\Livewire\AddUser;
use App\Livewire\Attendances;
use App\Livewire\Leaves;
use App\Livewire\Notifications;
use App\Livewire\Payroll;
use App\Livewire\Reports;
use App\Livewire\Settings;
use App\Livewire\TaxRateList;
use App\Livewire\UserList;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PayrollController;
use App\Livewire\Employees\AddEmployee;
use App\Livewire\Employees\UpdateEmployee;
use App\Livewire\Employees\ViewEmployee;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['auth']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['auth']);

Route::get('/employees', [EmployeeController::class, 'index'])->name('employees')->middleware(['auth']);
Route::get('/add-employee/{client}', [EmployeeController::class, 'create'])->middleware(['auth'])->name('add-employee');
Route::get('/view-employee/{employee}', [EmployeeController::class, 'show'])->name('view-employee')->middleware(['auth']);
Route::post('/edit-employee/{id}', [EmployeeController::class, 'edit'])->name('edit-employee')->middleware(['auth']);
Route::get('/update-employee/{id}', UpdateEmployee::class)->name('update-employee')->middleware(['auth']);

Route::get('/clients', [ClientController::class, 'index'])->middleware(['auth'])->name('clients');
Route::get('/addclient', AddClient::class)->middleware(['auth'])->name('addclient');
Route::get('/client/{client}', [ClientController::class, 'show'])->name('view-client')->middleware(['auth']);
Route::get('/update-client/{id}', UpdateClient::class)->name('update-employee')->middleware(['auth']);

Route::get('/add-payroll/{client}', [PayrollController::class, 'create'])->name('add-payroll')->middleware(['auth']);
Route::post('/save-payroll', [PayrollController::class, 'store'])->name('save-payroll')->middleware(['auth']);
Route::get('/view-payroll/{payroll}', [PayrollController::class, 'show'])->name('show-payroll')->middleware(['auth']);
Route::post('/update-payroll/{payroll}', [PayrollController::class, 'edit'])->name('update-payroll')->middleware(['auth']);
Route::delete('/delete-payroll/{payroll}', [PayrollController::class, 'destroy'])->name('delete-payroll')->middleware(['auth']);

Route::get('/leaves', Leaves::class)->middleware(['auth']);

Route::get('/attendances', Attendances::class)->middleware(['auth']);

Route::get('/tax-rates', TaxRateList::class)->middleware(['auth']);
Route::get('/add-tax-rate', AddTaxRate::class)->middleware(['auth']);

Route::get('/notifications', Notifications::class)->middleware(['auth']);

Route::get('/reports', Reports::class)->middleware(['auth']);

Route::get('/users', UserList::class)->middleware(['auth']);
Route::get('/add-user', AddUser::class)->middleware(['auth']);

Route::get('/settings', Settings::class)->middleware(['auth']);
