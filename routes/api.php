Route::post('/leave/{year}/{month}/mass-approve', [LeaveController::class,
'massApprove'])->name('api.leaves.massApprove');

Route::post('/leave/{year}/{month}/mass-disapprove', [LeaveController::class,
'massDisapprove'])->name('api.leaves.massDisapprove');