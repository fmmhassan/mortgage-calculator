<?php

// app/Services/LoanCalculatorService.php

namespace App\Services;

use App\Models\Loan;


class LoanCalculatorService
{

    public function calculateMonthlyPayment(Loan $loan): float {
        $loanAmount = $loan->loan_amount;
        $loanTermInMonths = $this->calculateLoanTermMonths($loan);

        $monthlyInterestRate = $this->calculateMonthlyInterestRate($loan);
        $monthlyPayment = ($loanAmount * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$loanTermInMonths));
        
        return $monthlyPayment;
    }
    
    function calculateMonthlyInterestRate(Loan $loan) : float {
        $annualInterestRate = $loan->annual_interest_rate;
        $monthlyInterestRate = ($annualInterestRate / 12) / 100;
        return $monthlyInterestRate;
    }
    
    function calculateLoanTermMonths(Loan $loan) : int {
        $loanTermInMonths = $loan->loan_term * 12;
        return $loanTermInMonths;
    }

}
