<?php
declare(strict_types=1);

namespace App\Years\Year2020\Day01;

use App\IDay;
use App\Utils\Input;

class Multiplier implements IDay
{
    public function runPart1(Input $data): string | int
    {
        $numbers = $data->getAsArrayOfIntegers();
        $dataCount = count($numbers);
        for ($i = 0; $i < $dataCount - 1; $i++) {
            for ($j = $i + 1; $j < $dataCount; $j++) {
                $value1 = $numbers[$i];
                $value2 = $numbers[$j];
                if ($value1 + $value2 === 2020) {
                    return $value1 * $value2;
                }
            }
        }

        return "Nothing found :(";
    }

    public function runPart2(Input $data): string | int
    {
        $numbers = $data->getAsArrayOfIntegers();
        $dataCount = count($numbers);
        for ($i = 0; $i < $dataCount - 2; $i++) {
            for ($j = $i + 1; $j < $dataCount - 1; $j++) {
                for ($k = $j + 1; $k < $dataCount; $k++) {
                    $value1 = $numbers[$i];
                    $value2 = $numbers[$j];
                    $value3 = $numbers[$k];
                    if ($value1 + $value2 + $value3 === 2020) {
                        return $value1 * $value2 * $value3;
                    }
                }
            }
        }

        return "Nothing found :(";
    }

    public function getExpectedTestResult1(): ?string
    {
        return '514579';
    }

    public function getExpectedTestResult2(): ?string
    {
        return '241861950';
    }
}
