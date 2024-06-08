<?php

namespace App\Http\Controllers;

use Homeful\Loan\Data\LoanData;
use Homeful\Borrower\Borrower;
use Homeful\Property\Property;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
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
        $data = LoanData::fromObject(tap(new Loan, function ($loan) use ($request) {
            $regional = $request->get('regional', true);
            $age = $request->get('age', 25);
            $birthdate = Carbon::now()->addYears(-1 * $age);
            $wages = $request->get('gross_monthly_income', 12000);

            $borrower = (new Borrower)
                ->setRegional($regional)
                ->setBirthdate($birthdate)
                ->addWages($wages);

            $total_contract_price = new Price(Money::of((int) $request->get('total_contract_price') ?? 850000, 'PHP'));
            $appraised_value = (int) $request->get('appraised_value')
                ? new Price(Money::of((int) $request->get('appraised_value'), 'PHP'))
                : $total_contract_price;

            $property = (new Property)
                ->setTotalContractPrice($total_contract_price)
                ->setAppraisedValue($appraised_value);

            $loan_amount = (int) $request->get('loan_amount') > 0
                ? new Price(Money::of($request->get('loan_amount'), 'PHP'))
                : $property->getLoanableValue();

            $equity = (int) $request->get('equity') > 0
                ? new Price(Money::of($request->get('equity'), 'PHP'))
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
