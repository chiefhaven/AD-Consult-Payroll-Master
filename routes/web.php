<?php

use App\Livewire\Clients\AddClient;
use App\Livewire\Clients\UpdateClient;
use App\Livewire\AddTaxRate;
use App\Livewire\AddUser;
use App\Livewire\Attendances;
use App\Livewire\Leaves;
use App\Livewire\Notifications;
use App\Livewire\Reports;
use App\Livewire\Settings;
use App\Livewire\TaxRateList;
use App\Livewire\UserList;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PayrollController;
use App\Livewire\Employees\UpdateEmployee;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\Common\BusinessUtil;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Artisan;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['auth']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['auth']);

Route::middleware(['auth'])->group(function () {
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees');
    Route::get('/add-employee/{client}', [EmployeeController::class, 'create'])->name('add-employee');
    Route::get('/view-employee/{employee}', [EmployeeController::class, 'show'])->name('view-employee');
    Route::get('/edit-employee/{employee}', [EmployeeController::class, 'edit'])->name('edit-employee');
    Route::put('/update-employee/{employee}', [EmployeeController::class, 'update'])->name('update-employee');
    Route::delete('/delete-employee/{employee}', [EmployeeController::class, 'destroy'])->name('delete-employee');
    Route::get('/export-employees/{client}/{type}', [EmployeeController::class, 'export'])->name('export-employees');
    Route::get('/employee/{employee}/set-inactive', [EmployeeController::class, 'setInactive'])->name('employee.setInactive');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/clients', [ClientController::class, 'index'])->name('clients');
    Route::get('/addclient', AddClient::class)->name('addclient');
    Route::get('/client/{client}', [ClientController::class, 'show'])->name('view-client');
    Route::get('/edit-client/{client}', [ClientController::class, 'edit'])->name('edit-client');
    Route::get('/update-client/{id}', UpdateClient::class)->name('update-client');
    Route::get('/export-clients/{type}', [ClientController::class, 'export'])->name('export-clients');
    Route::post('/fetch-client', [BusinessUtil::class, 'fetchClient'])->name('fetch-client');
    Route::get('/search-client', [BusinessUtil::class, 'searchClient'])->name('search-client');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/addproduct', [ProductController::class, 'create'])->name('addproduct');
    Route::get('/product/{product}', [ProductController::class, 'show'])->name('view-product');
    Route::get('/update-product/{id}', [ProductController::class, 'update'])->name('update-product');
    Route::get('/export-products/{type}', [ProductController::class, 'export'])->name('export-products');
    Route::get('/search-product', [BusinessUtil::class, 'searchProduct'])->name('search-product');
    Route::post('/show-product', [BusinessUtil::class, 'showProduct'])->name('show-product');

});


Route::get('/all-sales', [BillingController::class, 'index'])->middleware(['auth'])->name('billing');
Route::get('/add-sale', [BillingController::class, 'create'])->middleware(['auth'])->name('add-sale');
Route::get('/store-sale', [BillingController::class, 'store'])->middleware(['auth'])->name('store-sale');

Route::middleware(['auth'])->group(function () {
    Route::get('/payroll', [PayrollController::class, 'index'])->name('payrolls');
    Route::get('/add-payroll/{client}', [PayrollController::class, 'create'])->name('add-payroll');
    Route::post('/save-payroll', [PayrollController::class, 'store'])->name('save-payroll');
    Route::get('/view-payroll/{payroll}', [PayrollController::class, 'show'])->name('show-payroll');
    Route::get('/edit-payroll/{payroll}', [PayrollController::class, 'edit'])->name('edit-payroll');
    Route::put('/update-payroll/{payroll}', [PayrollController::class, 'update'])->name('update-payroll');
    Route::delete('/delete-payroll/{payroll}', [PayrollController::class, 'destroy'])->name('delete-payroll');
    Route::get('/export-payroll/{client}/{type}', [PayrollController::class, 'exportPayroll'])->name('export-payroll');
    Route::post('/change-payroll-status', [PayrollController::class, 'status'])->name('change-payroll-status');
    Route::get('/view-employee-payroll/{employee}/{payroll}/{payslip}', [PayrollController::class, 'viewEmployeePayroll'])->name('viewEmployeePayroll');
});

Route::get('/leaves', Leaves::class)->middleware(['auth']);

Route::get('/attendances', Attendances::class)->middleware(['auth']);

Route::get('/tax-rates', TaxRateList::class)->middleware(['auth']);
Route::get('/add-tax-rate', AddTaxRate::class)->middleware(['auth']);
Route::put('/update-paye-brackets', [BusinessUtil::class, 'updatePayeBrackets'])->name('update-paye-brackets')->middleware('auth');
Route::get('/paye-brackets', [BusinessUtil::class, 'getPayeBrackets'])->middleware(['auth']);

Route::get('/notifications', Notifications::class)->middleware(['auth']);

Route::get('/reports', Reports::class)->middleware(['auth']);

Route::get('/users', UserList::class)->middleware(['auth']);
Route::get('/add-user', AddUser::class)->middleware(['auth']);

Route::get('/settings', Settings::class)->middleware(['auth']);

Route::get('/migrate', function(){
    Artisan::call('migrate',['--force' => true]);
     dd('migrated!');
 })->middleware(['auth']);
