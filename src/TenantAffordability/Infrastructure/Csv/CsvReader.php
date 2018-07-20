<?php declare(strict_types=1);

namespace GoodLord\TenantAffordability\Infrastructure\Csv;

class CsvReader
{
    protected const CSV_EXTENSION = 'csv';
    protected const ACCEPTED_MIME_TYPE = 'text/plain';

    protected $file;

    public function __construct(string $file)
    {
        $file = new \SplFileObject($file);

        if (!$this->acceptable($file)) {
            throw new \InvalidArgumentException("We only accept CSV text files files at the moment.");
        }

        if (!$file->isReadable()) {
            throw new \InvalidArgumentException("Selected file {$file->getBasename()} is not readable.");
        }

        $this->file = $file;
    }

    public function __destruct()
    {
        $this->file = null;
    }

    public function read()
    {
        $headers = array_map('trim', $this->file->fgetcsv());

        while (!$this->file->eof()) {
            $row = array_map('trim', $this->file->fgetcsv());

            if (count($headers) !== count($row)) {
                continue;
            }

            $row = array_combine($headers, $row);

            yield $row;
        }

        return;
    }

    /**
     * Validates the file's extension and mime type.
     */
    private function acceptable(\SplFileObject $file): bool
    {
        $fileInfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $fileInfo->file($file->getRealPath());

        return $file->getExtension() == self::CSV_EXTENSION && $mimeType == self::ACCEPTED_MIME_TYPE;
    }
}
