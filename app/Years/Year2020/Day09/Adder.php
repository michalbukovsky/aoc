<?php

declare(strict_types=1);

namespace App\Years\Year2020\Day09;

use App\IDay;
use App\Utils\Input;

class Adder implements IDay
{
    public function runPart1(Input $data): string | int
    {
        $dataAsInts = $data->getAsArrayOfIntegers();
        $preamble = count($data->getAsArray()) > 25 ? 25 : 5;
        $pointer = $preamble;

        do {
            $theNumber = $dataAsInts[$pointer];
            for ($i = $pointer - $preamble; $i < $pointer - 1; $i++) {
                for ($j = $i + 1; $j < $pointer; $j++) {
                    if ($dataAsInts[$i] + $dataAsInts[$j] === $theNumber) {
                        $pointer++;
                        continue 3;
                    }
                }
            }

            return $theNumber;
        } while (isset($dataAsInts[$pointer]));

        return 'Nothing found.';
    }

    public function runPart2(Input $data): string | int
    {
        $dataAsInts = $data->getAsArrayOfIntegers();
        $theNumber = (int) $this->runPart1($data);
        $dataCount = count($dataAsInts);

        for ($i = 0; $i < $dataCount - 1; $i++) {
            $sum = $min = $max = $dataAsInts[$i];

            for ($j = $i + 1; $j < $dataCount; $j++) {
                $sum += $dataAsInts[$j];
                $min = min($min, $dataAsInts[$j]);
                $max = max($max, $dataAsInts[$j]);

                if ($sum > $theNumber) {
                    continue 2;
                }
                if ($sum === $theNumber) {
                    return $min + $max;
                }
            }
        }

        return 'Nothing found.';
    }

    public function getExpectedTestResult1(): ?string
    {
        return '127';
    }

    public function getExpectedTestResult2(): ?string
    {
        return '62';
    }
}
