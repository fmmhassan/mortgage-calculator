<?php
namespace App\Repositories;

use App\Models\Loan;

interface LoanRepositoryInterface
{
    public function createLoan($attributes): Loan;

}
