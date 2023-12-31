<?php

use App\Http\Controllers\LoanController;

Route::post('/calculate-loan', [LoanController::class, 'calculateLoan']);
