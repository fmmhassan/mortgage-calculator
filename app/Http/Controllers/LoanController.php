<?php

namespace App\Http\Controllers;

use App\Services\LoanAmortizationService;
use App\Services\ExtraRepaymentService;
use App\Http\Requests\LoanRequest;

use App\Repositories\LoanRepositoryInterface;

// collections
use App\Http\Resources\ExtraRepaymentCollection;
use App\Http\Resources\LoanAmortizationCollection;



class LoanController extends Controller
{
    public function __construct(
        protected LoanAmortizationService $loanAmortizationService,
        protected ExtraRepaymentService $extraRepaymentService,
        protected LoanRepositoryInterface $loanRepository,
    ) { }

    function index(){
        return view('loan-calculator');
    }

    public function calculateLoan(LoanRequest $request) {
        $validatedData = $request->all();
        // Create a new loan with validated data
        $loan = $this->loanRepository->createLoan($validatedData);
        
        // Generate and save the amortization schedule
        $loanAmortizationSchedule = $this->loanAmortizationService->generateAndSaveSchedule($loan);
        $extraRepaymentSchedule = [];

        // Check if extra repayment amount is provided before calling the service
        if (isset($validatedData['extra_repayment']) && $validatedData['extra_repayment'] !== null) {
            // Generate and save the extra repayment schedule
            $extraRepaymentSchedule = $this->extraRepaymentService->generateAndSaveSchedule($loan);
        }

        return response()->json([
            'loan' => $loan,
            'amortization_schedule' => new LoanAmortizationCollection($loanAmortizationSchedule),
            'amortization_schedule_with_repayment' => new ExtraRepaymentCollection($extraRepaymentSchedule),
        ]);
    }
    
}
