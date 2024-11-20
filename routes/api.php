<?php

use App\Http\Controllers\LeaveController;


// In routes/api.php
Route::get('/leaveView/{year?}/{month?}', [LeaveController::class, 'index']);

//In routes/api.php
Route::post('/leaveView/mass-approve', [LeaveController::class, 'massApprove']);
Route::post('/leaveView/mass-disapprove', [LeaveController::class, 'massDisapprove']);

// In routes/api.php
Route::post('/leave/approve/{id}', [LeaveController::class, 'approve']);

// In routes/api.php
Route::post('/leave/disapprove/{id}', [LeaveController::class, 'disapprove']);