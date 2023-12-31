<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'loan_amount' => 'required|numeric|min:1',
            'annual_interest_rate' => 'required|numeric|min:0',
            'loan_term' => 'required|integer|min:1',
            'extra_repayment' => 'nullable|numeric|min:0', // Optional field for extra repayment
        ];
    }

    public function messages()
    {
        return [
            'loan_amount.required' => 'Please provide the loan amount.',
            'loan_amount.numeric' => 'The loan amount must be a numeric value.',
            'loan_amount.min' => 'The loan amount must be a positive value.',
            'annual_interest_rate.required' => 'Please provide the annual interest rate.',
            'annual_interest_rate.numeric' => 'The annual interest rate must be a numeric value.',
            'annual_interest_rate.min' => 'The annual interest rate must be at least :min.',
            'loan_term.required' => 'Please provide the loan term.',
            'loan_term.integer' => 'The loan term must be an integer.',
            'loan_term.min' => 'The loan term must be at least :min years.',
            'extra_repayment.numeric' => 'The extra repayment must be a numeric value.',
            'extra_repayment.min' => 'The extra repayment must be at least :min.',
        ];
    }
}
