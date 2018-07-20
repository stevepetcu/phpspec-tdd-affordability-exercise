<?php declare(strict_types=1);

namespace GoodLord\TenantAffordability\Domain\Builder;

use GoodLord\TenantAffordability\Domain\Csv\BankCsvReader;
use GoodLord\TenantAffordability\Domain\Entity\BankStatement;
use Litipk\BigNumbers\Decimal;

class BankStatementBuilder
{
    private $bankStatementReader;

    public function __construct(BankCsvReader $bankStatementReader)
    {
        $this->bankStatementReader = $bankStatementReader;
    }

    /**
     * We assume that the bank statements always have the same structure:
     * 4th row == name of the bank
     * 5th non-empty row == name of the tenant
     * 6th and 7th non-empty rows == address of the tenant etc.
     *
     * We'll also assume the columns distribution of information and headers.
     */
    public function bankStatement(): BankStatement
    {
        $counter = 0;
        $bankName = '';
        $tenantName = '';
        $tenantAddress = '';
        $accountSummary = [];

        foreach ($this->bankStatementReader->read() as $row) {
            if (2 == $counter) {
                $bankName = $row['SAMPLE BANK STATEMENT'];
            }
            if (3 == $counter) {
                $tenantName = $row['SAMPLE BANK STATEMENT'];
            }
            if (4 == $counter || 5 == $counter) {
                $tenantAddress .= $row['SAMPLE BANK STATEMENT'] . ' ';
            }

            if ($counter > 9) {
                $date = (new \DateTime($row['Date']))->format('Y-m');

                if (!isset(
                    $accountSummary[$date]['expenses'],
                    $accountSummary[$date]['income']
                )) {
                    $accountSummary[$date]['expenses'] = Decimal::create(0, 3);
                    $accountSummary[$date]['income'] = Decimal::create(0, 3);
                }

                $formatter = new \NumberFormatter('en-US', \NumberFormatter::CURRENCY);

                $currency = 'GBP';

                if ('Direct Debit' == $row['Payment Type']) {
                    /** @var Decimal $expenses */
                    $expenses = $accountSummary[$date]['expenses'];
                    $amount = $formatter->parseCurrency($row['Money Out'], $currency);

                    $accountSummary[$date]['expenses'] =
                        $expenses->add(Decimal::create($amount));
                }

                if ('Bank Credit' == $row['Payment Type']) {
                    /** @var Decimal $income */
                    $income = $accountSummary[$date]['income'];
                    $accountSummary[$date]['income'] =
                        $income->add(Decimal::create($formatter->parseCurrency($row['Money In'], $currency)));
                }
            }

            ++$counter;
        }

        return new BankStatement($tenantName, $tenantAddress, $bankName, $accountSummary);
    }
}
