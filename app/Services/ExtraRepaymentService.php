<?php
namespace App\Services;

use App\Models\Loan;

class ExtraRepaymentService extends LoanBaseService {
    public function generateAndSaveSchedule(Loan $loan) {
        // Generate the loan amortization schedule
        $scheduleData = $this->generateExtraRepaymentScheduleData($loan);
        // Store the schedule data in the database
        return $this->saveExtraRepaymentScheduleToDatabase($loan, $scheduleData);
    }

    public function generateExtraRepaymentScheduleData(Loan $loan): array {
        
        $scheduleData = [];
        
        $loanTermInMonths = $this->loanCalculatorService->calculateLoanTermMonths($loan);
        $monthlyInterestRate = $this->loanCalculatorService->calculateMonthlyInterestRate($loan);
        $monthlyPayment = $this->loanCalculatorService->calculateMonthlyPayment($loan);
        
        $extraRepaymentAmount = $loan->extra_repayment;
        $remainingBalance = $loan->loan_amount;

        //new term since additional payments made
        $totRepaymentMade = $loanTermInMonths * $loan->extra_repayment;

        for ($month = 1; $month <= $loanTermInMonths && $remainingBalance > 0; $month++) {
            $interestComponent = $remainingBalance * $monthlyInterestRate;
            $principalComponent = $monthlyPayment - $interestComponent;

            $extraRepayment = min($extraRepaymentAmount, $remainingBalance - $principalComponent);
            
            $remainingBalance -= $principalComponent + $extraRepayment;
            
            $endingBalance = $remainingBalance - $principalComponent;

            $scheduleData[] = [
                'month_number' => $month,
                'starting_balance' => $remainingBalance + $principalComponent + $extraRepayment,
                'monthly_payment' => $monthlyPayment,
                'principal_component' => $principalComponent,
                'interest_component' => $interestComponent,
                'extra_repayment_made' => $extraRepayment,
                'ending_balance' => $remainingBalance,
                'remaining_loan_term' => 0,
            ];

            
        }
        
        /** set remaining loan term for each month */
        $remainLoanTerm = sizeof($scheduleData);
        foreach($scheduleData as &$scheduleDataRow){
            $scheduleDataRow['remaining_loan_term'] = --$remainLoanTerm;
        }
        return $scheduleData;

    }

    protected function saveExtraRepaymentScheduleToDatabase(Loan $loan, array $scheduleData)
    {
        $results = [];
        if(!empty($scheduleData)){
            // Store the schedule data in the database
            $results = $loan->extraRepaymentSchedule()->createMany($scheduleData);
            
        }
        return $results;
    }
    
}
