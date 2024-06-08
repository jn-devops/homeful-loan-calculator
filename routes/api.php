<?php

use Illuminate\Support\Facades\Route;
use Homeful\Loan\Data\LoanData;
use Homeful\Borrower\Borrower;
use Homeful\Property\Property;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Whitecube\Price\Price;
use Brick\Money\Money;
use Homeful\Loan\Loan;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/loan', function (Request $request) {
   $loan = new Loan;
   $borrower = (new Borrower)
       ->setRegional($request->get('regional', true))
       ->setBirthdate(Carbon::now()->addYears(-1 * $request->get('age', 25)))
       ->addWages($request->get('gross_monthly_income', 12000));
    $property = (new Property)
        ->setTotalContractPrice(new Price(Money::of($request->get('total_contract_price', 850000), 'PHP')))
        ->setAppraisedValue(new Price(Money::of($request->get('appraised_value', 825000), 'PHP')));
    $loan->setBorrower($borrower)->setProperty($property)->setLoanAmount(new Price(Money::of($request->get('loan_amount', 800000), 'PHP')));

    return LoanData::fromObject($loan)->toArray();
});
