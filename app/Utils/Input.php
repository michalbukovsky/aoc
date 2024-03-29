<?php

declare(strict_types=1);

namespace App\Utils;

use InvalidArgumentException;

class Input
{
    private string $data;

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    public function setData(string $data): void
    {
        $this->data = $data;
    }

    public function getAsString(): string
    {
        return $this->data;
    }

    /**
     * @return string[]
     */
    public function getAsArray(bool $filterLines = true, string $separator = "\n"): array
    {
        $dataExploded = explode($separator, $this->data);

        return ($filterLines === true ? array_filter($dataExploded) : $dataExploded);
    }

    /**
     * @return int[]
     */
    public function getAsArrayOfIntegers(bool $filterLines = true): array
    {
        return Tools::intifyArray($this->getAsArray($filterLines));
    }

    public function getAsArrayOfArraysOfIntegers(bool $filterLines = true, int $sliceLength = 1): array
    {
        $returnArray = [];
        foreach ($this->getAsArray($filterLines) as $line) {
            $returnArray[] = Tools::intifyArray(str_split($line, $sliceLength));
        }

        return $returnArray;
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function getAsArrayOfArrays(
        bool $filterLines = true,
        string $lineSeparator = "\n",
        string $spaceSeparator = ' '
    ): array {
        if ($spaceSeparator === '') {
            throw new InvalidArgumentException('Space separator cannot be empty string!');
        }

        return array_map(
            static fn(string $line): array => explode($spaceSeparator, $line),
            $this->getAsArray($filterLines, $lineSeparator)
        );
    }

    /**
     * @return string[][]
     */
    public function getAsArrayOfArraysOfChars(bool $filterLines = true): array
    {
        return array_map(
            static fn(string $line): array => str_split($line),
            $this->getAsArray($filterLines)
        );
    }

    public function getFirstLine(bool $remove = false): string
    {
        if (!str_contains($this->data, "\n")) {
            return $this->data;
        }

        $firstLine = substr($this->data, 0, strpos($this->data, "\n"));
        if ($remove === true) {
            $this->data = substr($this->data, strpos($this->data, "\n"));
        }

        return $firstLine;
    }

    /**
     * @return int[]
     */
    public function getFirstLineAsIntegers(string $separator = ','): array
    {
        return Tools::intifyArray(explode($separator, $this->getFirstLine()));
    }

    public function getLinesCount(): int
    {
        return count($this->getAsArray());
    }
}
