<?php

namespace App\Repositories;

use App\Models\Loan;

class LoanRepository implements LoanRepositoryInterface
{
    public function createLoan($attributes): Loan
    {
        return Loan::create($attributes);
    }
}
