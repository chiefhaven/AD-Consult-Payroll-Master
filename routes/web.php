<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\AttendanceController;
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
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\HRMController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\LeaveType;
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
    Route::get('/add-product', [ProductController::class, 'create'])->name('add-product');
    Route::post('/store-product', [ProductController::class, 'store'])->name('store-product');
    Route::get('/edit-product/{product}', [ProductController::class, 'edit'])->name('edit-product');
    Route::delete('/delete-product/{product}', [ProductController::class, 'destroy'])->name('delete-product');
    Route::put('/update-product/{product}', [ProductController::class, 'update'])->name('update-product');
    Route::get('/export-products/{type}', [ProductController::class, 'export'])->name('export-products');
    Route::get('/view-product/{product}', [ProductController::class, 'show'])->name('view-product');
    Route::get('/search-product', [BusinessUtil::class, 'searchProduct'])->name('search-product');
    Route::post('/show-product', [BusinessUtil::class, 'showProduct'])->name('show-product');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/hrm', [HRMController::class, 'index'])->name('hrm');
    Route::get('/hrm/designations', [HRMController::class, 'designationIndex'])->name('hrmDesignation');
    Route::post('/storeDesignation', [HRMController::class, 'storeDesignation'])->name('storeDesignation');
    Route::post('/storeLeaveType', [LeaveTypeController::class, 'store'])->name('storeLeaveType');
    Route::delete('/deleteDesignation/{designation}', [HRMController::class, 'deleteDesignation'])->name('deleteDesignation');
    Route::delete('/deleteLeaveType/{leavetype}', [LeaveTypeController::class, 'destroy'])->name('deleteLeaveType');
    Route::post('/updateDesignation/{id}', [HRMController::class, 'updateDesignation'])->name('updateDesignation');
    Route::get('/hrm/leave-types', [LeaveTypeController::class, 'index'])->name('leave-types');
    Route::patch('/updateLeaveType/{id}', [LeaveTypeController::class, 'update'])->name('updateLeaveType');
    Route::get('/hrm/leaves', [LeaveController::class, 'index'])->name('leaves');
    Route::delete('/deleteLeave/{leave}', [LeaveController::class, 'destroy'])->name('deleteLeave');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves');
    Route::patch('/leaves/{leave}/approval', [LeaveController::class, 'leaveApproval'])->name('leaves.approval');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/holidays', [HolidayController::class, 'index'])->name('holidays');
    Route::post('/storeHoliday', [HolidayController::class, 'store'])->name('storeHoliday');
    Route::delete('/deleteHoliday/{holiday}', [HolidayController::class, 'destroy'])->name('deleteHoliday');
    Route::patch('/updateHoliday/{holiday}', [HolidayController::class, 'update'])->name('updateHoliday');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/all-sales', [BillingController::class, 'index'])->name('billing');
    Route::get('/view-bill/{bill}', [BillingController::class, 'show'])->name('showBill');
    Route::get('/add-sale', [BillingController::class, 'create'])->name('add-sale');
    Route::post('/edit-bill/{billing}', [BillingController::class, 'edit'])->name('edit-sale');
    Route::put('/store-sale', [BillingController::class, 'store'])->name('store-sale');
    Route::put('/update-sale', [BillingController::class, 'update'])->name('update-sale');
    Route::get('/print-bill/{bill}/{action}', [BillingController::class, 'billPdf'])->name('print-pdf');
    Route::delete('/delete-bill/{bill}', [BillingController::class, 'destroy'])->name('deleteBill');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/all-payments', [PaymentController::class, 'index'])->name('payments');
    Route::get('/view-payments/{payment}', [PaymentController::class, 'show'])->name('paymentShow');
    Route::get('/add-payment', [PaymentController::class, 'create'])->name('paymentsCreate'); // Changed from add-sale
    Route::post('/store-payment', [PaymentController::class, 'store'])->name('paymentsStore'); // Changed to POST
    Route::get('/edit-payment/{payment}', [PaymentController::class, 'edit'])->name('paymentsEdit'); // Changed to GET
    Route::put('/update-payment/{payment}', [PaymentController::class, 'update'])->name('paymentsUpdate'); // Added {payment} parameter
    Route::get('/print-payment/{payment}', [PaymentController::class, 'paymentPdf'])->name('paymentPrint'); // Updated name
    Route::delete('/delete-payment/{payment}', [PaymentController::class, 'destroy'])->name('paymentDestroy');
});

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


Route::get('/tax-rates', TaxRateList::class)->middleware(['auth']);
Route::get('/add-tax-rate', AddTaxRate::class)->middleware(['auth']);
Route::put('/update-paye-brackets', [BusinessUtil::class, 'updatePayeBrackets'])->name('update-paye-brackets')->middleware('auth');
Route::get('/paye-brackets', [BusinessUtil::class, 'getPayeBrackets'])->middleware(['auth']);

Route::get('/notifications', Notifications::class)->middleware(['auth']);

Route::get('/reports', Reports::class)->middleware(['auth']);

Route::middleware(['auth'])->group(function () {
    Route::get('/admins', [AdministratorController::class, 'index'])->name('admins');
    Route::get('/adminData', [AdministratorController::class, 'adminData'])->name('adminsData');
    Route::get('/add-admin', [AdministratorController::class, 'create'])->name('add-admin');
    Route::post('/admin-store', [AdministratorController::class, 'store'])->name('admin-store');
    Route::delete('/delete-admin/{admin}', [AdministratorController::class, 'destroy'])->name('delete-admin');
    Route::put('/update-admin', [AdministratorController::class, 'update'])->name('update-admin');
});

Route::middleware(['auth'])->group(function () {
    Route::view('/roles', 'roles.roles');
    Route::get('/get-roles', [RoleController::class, 'index'])->name('roles');
    Route::get('/add-role', [RoleController::class, 'create'])->name('add-role');
    Route::get('/edit-role/{role}', [RoleController::class, 'edit'])->name('edit-role');
    Route::get('/store-role', [RoleController::class, 'store'])->name('store-role');
    Route::put('/roles/{role}/permissions', [RoleController::class, 'update'])->name('roles.update-permissions');
    Route::get('/delete-role', [RoleController::class, 'destroy'])->name('delete-role');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::get('/settings/business-info', [SettingsController::class, 'businessInfo'])->name('business-info');
    Route::post('/update-email-settings', [BusinessUtil::class, 'updateEmailSettings'])->name('update-email-settings');
    Route::get('/email-settings', [BusinessUtil::class, 'getEmailSettings'])->name('email-settings');
    Route::post('/update-invoice-settings ', [SettingsController::class, 'updateInvoiceSettings'])->name('update-invoice-settings ');
    Route::get('/invoice-settings', [SettingsController::class, 'getinvoiceSettings'])->name('invoice-settings');
});


Route::get('/migrate', function(){
    Artisan::call('migrate',['--force' => true]);
     dd('migrated!');
 })->middleware(['auth']);
