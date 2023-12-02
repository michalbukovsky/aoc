<?php

declare(strict_types=1);

namespace App\Years\Year2020\Day02;

use App\IDay;
use App\Utils\Input;

class PWChecker implements IDay
{
    public function runPart1(Input $data): string | int
    {
        // data example: 6-10 p: ctpppjmdpppppp
        $correct = 0;

        foreach ($data->getAsArray() as $dataLine) {
            preg_match('~^(\d+)-(\d+) (\w+): (.+)$~', $dataLine, $m);
            [1 => $min, 2 => $max, 3 => $character, 4 => $password] = $m;

            $count = substr_count($password, $character);
            if ($count >= $min && $count <= $max) {
                $correct++;
            }
        }

        return $correct;
    }

    public function runPart2(Input $data): string | int
    {
        // data example: 6-10 p: ctpppjmdpppppp
        $correct = 0;

        foreach ($data->getAsArray() as $dataLine) {
            preg_match('~^(\d+)-(\d+) (\w+): (.+)$~', $dataLine, $m);
            [1 => $firstPosition, 2 => $secondPosition, 3 => $character, 4 => $password] = $m;

            $firstCorrect = substr($password, (int) $firstPosition - 1, 1) === $character;
            $secondCorrect = substr($password, (int) $secondPosition - 1, 1) === $character;

            if ($firstCorrect xor $secondCorrect) {
                $correct++;
            }
        }

        return $correct;
    }

    public function getExpectedTestResult1(): ?string
    {
        return '2';
    }

    public function getExpectedTestResult2(): ?string
    {
        return '1';
    }
}
