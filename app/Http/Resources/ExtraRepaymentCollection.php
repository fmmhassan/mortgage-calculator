<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ExtraRepaymentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($resource) {
                return [
                    'id' => $resource->id,
                    'loan_id' => $resource->loan_id,
                    'month_number' => number_format($resource->month_number),
                    'starting_balance' => number_format($resource->starting_balance, 2,'.', ','),
                    'monthly_payment' => number_format($resource->monthly_payment, 2,'.', ','),
                    'principal_component' => number_format($resource->principal_component, 2,'.', ','),
                    'interest_component' => number_format($resource->interest_component, 2,'.', ','),
                    'extra_repayment_made' => number_format($resource->extra_repayment_made, 2,'.', ','),
                    'ending_balance' => number_format($resource->ending_balance, 2,'.', ','),
                    'remaining_loan_term' => $resource->remaining_loan_term,
                ];
            }),
        ];
    }
}
