<?php

namespace App\Service\Import;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class CsvService
{
    private $handle;

    private array $keys;
    private int $rowNumber;

    public function init(string $filename): void
    {
        $this->handle = fopen($filename, 'r');

        if (false === $this->handle) {
            throw new FileNotFoundException();
        }

        $this->keys = fgetcsv($this->handle) ?: [];
        $this->rowNumber = 0;
    }

    public function getRow(): ?array
    {
        $data = fgetcsv($this->handle);

        if (false === $data) {
            fclose($this->handle);

            return null;
        }

        ++$this->rowNumber;

        $result = [];
        foreach ($this->keys as $i => $key) {
            $result[$key] = $data[$i] ?? null;
        }

        return $result;
    }

    public function getRowNumber(): int
    {
        return $this->rowNumber;
    }
}
