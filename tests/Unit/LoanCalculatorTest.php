<?php

use Homeful\Loan\Data\LoanData;
use Illuminate\Support\Carbon;
use Homeful\Borrower\Borrower;
use Homeful\Property\Property;
use Illuminate\Support\Arr;
use Whitecube\Price\Price;
use Homeful\Loan\Loan;
use Brick\Money\Money;
use Tests\TestCase;

uses(TestCase::class);

test('loan simulation', function (
    bool  $regional,
    float|array $gross_monthly_income,
    int   $age,
    float $total_contract_price,
    float $appraised_value,
    float $loan_amount,
    int   $guess_months_to_pay,
    string $guess_market_segment,
    float $guess_loanable_value_multiplier,
    float $guess_loanable_value,
    float $guess_annual_interest,
    float $guess_monthly_amortization,
    float $guess_disposable_income_requirement_multiplier,
    float $guess_disposable_monthly_income,
    float $guess_joint_disposable_monthly_income,
    Borrower $co_borrower = null
) {
    expect($appraised_value)->toBeGreaterThanOrEqual($loan_amount);
    $borrower = (new Borrower)
        ->setRegional($regional)
        ->setBirthdate(Carbon::now()->addYears(-$age));
    if (!is_array($gross_monthly_income)) {
        $borrower->addWages($gross_monthly_income);
    }
    else {
        $wages = Arr::pull($gross_monthly_income, 'wages');
        $borrower->addWages($wages);
        foreach ($gross_monthly_income as $index => $value) {
            $borrower->addOtherSourcesOfIncome($index, Money::of($value, 'PHP'));
        }
    }
    if ($co_borrower)
        $borrower->addCoBorrower($co_borrower);

    $property = (new Property)
        ->setTotalContractPrice(new Price(Money::of($total_contract_price, 'PHP')))
        ->setAppraisedValue(new Price(Money::of($appraised_value, 'PHP')));

    expect($property->getMarketSegment()->value)->toBe($guess_market_segment);
    expect($property->getDisposableIncomeRequirementMultiplier())->toBe($guess_disposable_income_requirement_multiplier);
    $loan = new Loan;
    $loan->setBorrower($borrower)->setProperty($property)
        ->setLoanAmount(new Price(Money::of($loan_amount, 'PHP')));
    expect($loan->getMaximumMonthsToPay())->toBe($guess_months_to_pay);
    expect($property->getLoanableValueMultiplier())->toBe($guess_loanable_value_multiplier);
    expect($property->getLoanableValue()->inclusive()->getAmount()->toFloat())->toBe($guess_loanable_value);
    expect($loan->getAnnualInterestRate())->toBe($guess_annual_interest);
    expect($loan->getMonthlyAmortizationAmount()->inclusive()->getAmount()->toFloat())->toBe($guess_monthly_amortization);
    expect($borrower->getDisposableMonthlyIncome($property)->inclusive()->getAmount()->toFloat())->toBe($guess_disposable_monthly_income);
    expect($borrower->getJointDisposableMonthlyIncome($property)->inclusive()->getAmount()->toFloat())->toBe($guess_joint_disposable_monthly_income);
    expect($borrower->getJointDisposableMonthlyIncome($property)->inclusive()->getAmount()->toFloat())->toBeGreaterThanOrEqual($loan->getMonthlyAmortizationAmount()->inclusive()->getAmount()->toFloat());
    $data = LoanData::fromObject($loan);
    expect($data->toArray())->toBe([
        "loan_amount" => $loan->getLoanAmount()->inclusive()->getAmount()->toFloat(),
        "months_to_pay" => $loan->getMaximumMonthsToPay(),
        "annual_interest" => $loan->getAnnualInterestRate(),
        "monthly_amortization" => $loan->getMonthlyAmortizationAmount()->inclusive()->getAmount()->toFloat(),
        "borrower" => [
            "gross_monthly_income" => $loan->getBorrower()->getGrossMonthlyIncome()->inclusive()->getAmount()->toFloat(),
            "regional" => $loan->getBorrower()->getRegional(),
            "birthdate" => $loan->getBorrower()->getBirthdate()->format('Y-m-d'),
        ],
        "property" => [
            "market_segment" => $loan->getProperty()->getMarketSegment()->value,
            "total_contract_price" => $loan->getProperty()->getTotalContractPrice()->inclusive()->getAmount()->toFloat(),
            "appraised_value" => $loan->getProperty()->getAppraisedValue()->inclusive()->getAmount()->toFloat(),
            "default_loanable_value_multiplier" => $loan->getProperty()->getDefaultLoanableValueMultiplier(),
            "loanable_value_multiplier" => $loan->getProperty()->getLoanableValueMultiplier(),
            "loanable_value" => $loan->getProperty()->getLoanableValue()->inclusive()->getAmount()->toFloat(),
            "disposable_income_requirement_multiplier" => $loan->getProperty()->getDisposableIncomeRequirementMultiplier(),
            "default_disposable_income_requirement_multiplier" => $loan->getProperty()->getDefaultDisposableIncomeRequirementMultiplier(),
        ]
    ]);
})->with([
    [
        'regional' => false,
        'gross_monthly_income' => 12000.0,
        'age' => 25,
        'total_contract_price' => 850000.0,
        'appraised_value' => 800000.0,
        'loan_amount' => 800000.0,
        'guess_months_to_pay' => 360,
        'guess_market_segment' => 'socialized',
        'guess_loanable_value_multiplier' => 1.0,
        'guess_loanable_value' => 800000.0,
        'guess_annual_interest' => 0.03,
        'guess_monthly_amortization' => 3373.0,
        'guess_disposable_income_requirement_multiplier' => 0.35,
        'guess_disposable_monthly_income' => 4200.0,
        'guess_joint_disposable_monthly_income' => 4200.0
    ],
    [
        'regional' => true,
        'gross_monthly_income' => 12000.0,
        'age' => 25,
        'total_contract_price' => 850000.0,
        'appraised_value' => 800000.0,
        'loan_amount' => 800000.0,
        'guess_months_to_pay' => 360,
        'guess_market_segment' => 'socialized',
        'guess_loanable_value_multiplier' => 1.0,
        'guess_loanable_value' => 800000.0,
        'guess_annual_interest' => 0.03,
        'guess_monthly_amortization' => 3373.0,
        'guess_disposable_income_requirement_multiplier' => 0.35,
        'guess_disposable_monthly_income' => 4200.0,
        'guess_joint_disposable_monthly_income' => 4200.0
    ],
    [
        'regional' => true,
        'gross_monthly_income' => [
            'wages' => 12000.0,
            'commissions' => 4000.0
        ],
        'age' => 25,
        'total_contract_price' => 850000.0,
        'appraised_value' => 800000.0,
        'loan_amount' => 800000.0,
        'guess_months_to_pay' => 360,
        'guess_market_segment' => 'socialized',
        'guess_loanable_value_multiplier' => 1.0,
        'guess_loanable_value' => 800000.0,
        'guess_annual_interest' => 0.0625,
        'guess_monthly_amortization' => 4926.0,
        'guess_disposable_income_requirement_multiplier' => 0.35,
        'guess_disposable_monthly_income' => 5600.0,
        'guess_joint_disposable_monthly_income' => 5600.0
    ],
    [
        'regional' => false,
        'gross_monthly_income' => 15000.0,
        'age' => 25,
        'total_contract_price' => 850000.0,
        'appraised_value' => 800000.0,
        'loan_amount' => 800000.0,
        'guess_months_to_pay' => 360,
        'guess_market_segment' => 'socialized',
        'guess_loanable_value_multiplier' => 1.0,
        'guess_loanable_value' => 800000.0,
        'guess_annual_interest' => 0.03,
        'guess_monthly_amortization' => 3373.0,
        'guess_disposable_income_requirement_multiplier' => 0.35,
        'guess_disposable_monthly_income' => 5250.0,
        'guess_joint_disposable_monthly_income' => 5250.0
    ],
    [
        'regional' => true,
        'gross_monthly_income' => 15000.0,
        'age' => 25,
        'total_contract_price' => 850000.0,
        'appraised_value' => 800000.0,
        'loan_amount' => 800000.0,
        'guess_months_to_pay' => 360,
        'guess_market_segment' => 'socialized',
        'guess_loanable_value_multiplier' => 1.0,
        'guess_loanable_value' => 800000.0,
        'guess_annual_interest' => 0.03,
        'guess_monthly_amortization' => 3373.0,
        'guess_disposable_income_requirement_multiplier' => 0.35,
        'guess_disposable_monthly_income' => 5250.0,
        'guess_joint_disposable_monthly_income' => 5250.0
    ],
    [
        'regional' => false,
        'gross_monthly_income' => 17000.0,
        'age' => 25,
        'total_contract_price' => 850000.0,
        'appraised_value' => 800000.0,
        'loan_amount' => 800000.0,
        'guess_months_to_pay' => 360,
        'guess_market_segment' => 'socialized',
        'guess_loanable_value_multiplier' => 1.0,
        'guess_loanable_value' => 800000.0,
        'guess_annual_interest' => 0.0625 ,
        'guess_monthly_amortization' => 4926.0,
        'guess_disposable_income_requirement_multiplier' => 0.35,
        'guess_disposable_monthly_income' => 5950.0,
        'guess_joint_disposable_monthly_income' => 5950.0
    ],
    [
        'regional' => true,
        'gross_monthly_income' => 17000.0,
        'age' => 25,
        'total_contract_price' => 850000.0,
        'appraised_value' => 800000.0,
        'loan_amount' => 800000.0,
        'guess_months_to_pay' => 360,
        'guess_market_segment' => 'socialized',
        'guess_loanable_value_multiplier' => 1.0,
        'guess_loanable_value' => 800000.0,
        'guess_annual_interest' => 0.0625 ,
        'guess_monthly_amortization' => 4926.0,
        'guess_disposable_income_requirement_multiplier' => 0.35,
        'guess_disposable_monthly_income' => 5950.0,
        'guess_joint_disposable_monthly_income' => 5950.0
    ],
    [
        'regional' => false,
        'gross_monthly_income' => 17000.0,
        'age' => 48,
        'total_contract_price' => 850000.0,
        'appraised_value' => 800000.0,
        'loan_amount' => 800000.0,
        'guess_months_to_pay' => 264,
        'guess_market_segment' => 'socialized',
        'guess_loanable_value_multiplier' => 1.0,
        'guess_loanable_value' => 800000.0,
        'guess_annual_interest' => 0.0625 ,
        'guess_monthly_amortization' => 5583.0,
        'guess_disposable_income_requirement_multiplier' => 0.35,
        'guess_disposable_monthly_income' => 5950.0,
        'guess_joint_disposable_monthly_income' => 5950.0
    ],
    [
        'regional' => false,
        'gross_monthly_income' => 15000.0,
        'age' => 49,
        'total_contract_price' => 850000.0,
        'appraised_value' => 800000.0,
        'loan_amount' => 800000.0,
        'guess_months_to_pay' => 252,
        'guess_market_segment' => 'socialized',
        'guess_loanable_value_multiplier' => 1.0,
        'guess_loanable_value' => 800000.0,
        'guess_annual_interest' => 0.03 ,
        'guess_monthly_amortization' => 4283.0,
        'guess_disposable_income_requirement_multiplier' => 0.35,
        'guess_disposable_monthly_income' => 5250.0,
        'guess_joint_disposable_monthly_income' => 5250.0,
    ],
    [
        'regional' => false,
        'gross_monthly_income' => [
            'wages' => 30000.0,
            'commissions' => 24000.0
        ],
        'age' => 35,
        'total_contract_price' => 3000000.0,
        'appraised_value' => 2900000.0,
        'loan_amount' => 2610000.0,
        'guess_months_to_pay' => 360,
        'guess_market_segment' => 'open',
        'guess_loanable_value_multiplier' => 0.9,
        'guess_loanable_value' => 2610000.0,
        'guess_annual_interest' => 0.0625  ,
        'guess_monthly_amortization' => 16070.0,
        'guess_disposable_income_requirement_multiplier' => 0.30,
        'guess_disposable_monthly_income' => 16200.0,
        'guess_joint_disposable_monthly_income' => 16200.0,
    ],
    [
        'regional' => true,
        'gross_monthly_income' => 9000.0,
        'age' => 45,
        'total_contract_price' => 850000.0,
        'appraised_value' => 800000.0,
        'loan_amount' => 750000.0,
        'guess_months_to_pay' => 288,
        'guess_market_segment' => 'socialized',
        'guess_loanable_value_multiplier' => 1.0,
        'guess_loanable_value' => 800000.0,
        'guess_annual_interest' => 0.03,
        'guess_monthly_amortization' => 3656.0,
        'guess_disposable_income_requirement_multiplier' => 0.35,
        'guess_disposable_monthly_income' => 3150.0,
        'guess_joint_disposable_monthly_income' => 5600.0 ,
        'co_borrower' => (new Borrower)->addWages(7000)->setBirthdate(Carbon::now()->addYears(-46))->setRegional(true)
    ],
]);
