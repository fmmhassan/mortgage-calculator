<?php


namespace App\Services;

use App\Models\Loan;

class LoanAmortizationService extends LoanBaseService {
    public function generateAndSaveSchedule(Loan $loan) {

        // Generate the loan amortization schedule
        $scheduleData = $this->generateAmortizationSchedule($loan);
        // Store the schedule data in the database
        return $this->saveAmortizationScheduleToDatabase($loan, $scheduleData);
    }

    public function generateAmortizationSchedule(Loan $loan): array {
        
        $scheduleData = [];
        
        $loanTermInMonths = $this->loanCalculatorService->calculateLoanTermMonths($loan);
        $monthlyInterestRate = $this->loanCalculatorService->calculateMonthlyInterestRate($loan);
        $monthlyPayment = $this->loanCalculatorService->calculateMonthlyPayment($loan);


        $remainingBalance = $loan->loan_amount;

        for ($month = 1; $month <= $loanTermInMonths; $month++) {
            $interestComponent = $remainingBalance * $monthlyInterestRate;
            $principalComponent = $monthlyPayment - $interestComponent;
            $endingBalance = $remainingBalance - $principalComponent;

            $scheduleData[] = [
                'month_number' => $month,
                'starting_balance' => $remainingBalance,
                'monthly_payment' => $monthlyPayment,
                'principal_component' => $principalComponent,
                'interest_component' => $interestComponent,
                'ending_balance' => $endingBalance,
            ];

            $remainingBalance = $endingBalance;
        }

        return $scheduleData;
    }

    protected function saveAmortizationScheduleToDatabase(Loan $loan, array $scheduleData)
    {
        $results = [];
        if(!empty($scheduleData)){
            $results = $loan->loanAmortizationSchedule()->createMany($scheduleData);
        }
        return $results;
    }
}
