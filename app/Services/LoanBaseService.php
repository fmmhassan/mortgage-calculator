<?php

namespace App\Services;

use App\Models\Loan;


abstract class LoanBaseService {
    public function __construct(protected LoanCalculatorService $loanCalculatorService)
    { }

    abstract public function generateAndSaveSchedule(Loan $loan);
}
