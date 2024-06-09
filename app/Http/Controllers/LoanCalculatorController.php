<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Homeful\Loan\Data\LoanData;
use Homeful\Borrower\Borrower;
use Homeful\Property\Property;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Whitecube\Price\Price;
use Brick\Money\Money;
use Homeful\Loan\Loan;

class LoanCalculatorController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Brick\Math\Exception\NumberFormatException
     * @throws \Brick\Math\Exception\RoundingNecessaryException
     * @throws \Brick\Money\Exception\UnknownCurrencyException
     * @throws \Homeful\Borrower\Exceptions\MaximumBorrowingAgeBreached
     * @throws \Homeful\Borrower\Exceptions\MinimumBorrowingAgeNotMet
     */
    public function __invoke(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'age' => ['required', 'integer', 'min:18', 'max:60'],
            'regional' => ['required', 'bool'],
            'gross_monthly_income' => ['required', 'integer', 'min:10000', 'max:300000'],
            'total_contract_price' => ['required', 'integer', 'min:500000', 'max:7000000'],
            'appraised_value' => ['required', 'integer', 'min:400000', 'max:7000000'],
            'loan_amount' => ['nullable', 'integer', 'min:400000', 'max:7000000'],
            'equity' => ['nullable', 'integer', 'min:20000', 'max:3000000'],
        ])->validate();

        $data = LoanData::fromObject(tap(new Loan, function ($loan) use ($validated) {
            $regional = Arr::get($validated, 'regional', true);
            $age = Arr::get($validated, 'age', 25);
            $birthdate = Carbon::now()->addYears(-1 * $age);
            $wages = Arr::get($validated, 'gross_monthly_income', 12000);

            $borrower = (new Borrower)
                ->setRegional($regional)
                ->setBirthdate($birthdate)
                ->addWages($wages);

            $total_contract_price = new Price(Money::of((int) Arr::get($validated, 'total_contract_price') ?? 850000, 'PHP'));
            $appraised_value = (int) Arr::get($validated, 'appraised_value')
                ? new Price(Money::of((int) Arr::get($validated, 'appraised_value'), 'PHP'))
                : $total_contract_price;

            $property = (new Property)
                ->setTotalContractPrice($total_contract_price)
                ->setAppraisedValue($appraised_value);

            $loan_amount = (int) Arr::get($validated, 'loan_amount') > 0
                ? new Price(Money::of(Arr::get($validated, 'loan_amount'), 'PHP'))
                : $property->getLoanableValue();

            $equity = (int) Arr::get($validated, 'equity') > 0
                ? new Price(Money::of(Arr::get($validated, 'equity'), 'PHP'))
                : $loan->getEquity();

            $loan->setBorrower($borrower)->setProperty($property)
                ->setLoanAmount($loan_amount)
                ->setEquity($equity);
        }));

        return back()->with('event', [
            'name' => 'loan.calculated',
            'data' => $data,
        ]);
    }
}
