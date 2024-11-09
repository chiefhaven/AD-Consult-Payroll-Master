Route::post('/leaveView/{year}/{month}/mass-approve', [LeaveController::class,
'massApprove'])->name('api.massApprove');

Route::post('/leaveView/{year}/{month}/mass-disapprove', [LeaveController::class,
'massDisapprove'])->name('api.massDisapprove');
