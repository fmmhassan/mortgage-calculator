<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Resources\ExtraRepaymentCollection;

class LoanApiTest extends TestCase
{
    public function testLoanInputWithoutDataValidation()
    {
        
        $response = $this->postJson('/api/calculate-loan', []);

        $response->assertStatus(422); // 422 Unprocessable Entity for validation error
        $response->assertJsonValidationErrors([
            'loan_amount',
            'annual_interest_rate',
            'loan_term',
        ]);
    }
    public function testLoanInputValidation()
    {
        $response = $this->postJson('/api/calculate-loan', [
            'loan_amount' => -1000,
            'annual_interest_rate' => 5,
            'loan_term' => 10,
            'extra_repayment' => ''
        ]);

        $response->assertStatus(422); // 422 Unprocessable Entity for validation error
        $response->assertJsonValidationErrors(['loan_amount']);
    }
    /**
     * Test loan calculation without extra repayment.
     *
     * @return void
     */
    public function testLoanCalculationWithoutExtraRepayment()
    {
        $response = $this->postJson('/api/calculate-loan', [
            'loan_amount' => 10000,
            'annual_interest_rate' => 5,
            'loan_term' => 2,
        ]);


        $response->assertStatus(200);

    }

    /**
     * Test loan calculation with extra repayment.
     *
     * @return void
     */
    public function testLoanCalculationWithExtraRepayment()
    {
        $response = $this->postJson('/api/calculate-loan', [
            'loan_amount' => 10000,
            'annual_interest_rate' => 5,
            'loan_term' => 2,
            'extra_repayment' => 500,
        ]);

        $response->assertStatus(200);

    }

}