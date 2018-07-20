<?php declare(strict_types=1);

namespace GoodLord\TenantAffordability\Domain\Csv;

use GoodLord\TenantAffordability\Infrastructure\Csv\CsvReader;

class BankCsvReader extends CsvReader
{
    public function read()
    {
        $headers = array_map('trim', $this->file->fgetcsv());

        while (!$this->file->eof()) {
            $row = array_map('trim', $this->file->fgetcsv());

            if (count($headers) !== count($row)) {
                continue;
            } elseif ("Date" == $row[0]) {
                $headers = array_map('trim', $row);
            }

            $row = array_combine($headers, $row);

            yield $row;
        }

        return;
    }
}
