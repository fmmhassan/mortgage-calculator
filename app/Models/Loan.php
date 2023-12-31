<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $fillable = [
        'loan_amount',
        'annual_interest_rate',
        'loan_term',
        'extra_repayment', // Add the extra_repayment column
    ];

    public function loanAmortizationSchedule()
    {
        return $this->hasMany(LoanAmortizationSchedule::class);
    }
    
    public function extraRepaymentSchedule()
    {
        return $this->hasMany(ExtraRepaymentSchedule::class);
    }
}
