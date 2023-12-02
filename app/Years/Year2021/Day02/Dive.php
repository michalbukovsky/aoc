<?php declare(strict_types=1);

namespace App\Years\Year2021\Day02;

use App\IDay;
use App\Utils\Input;

class Dive implements IDay {

    private const FORWARD = 'forward';
    private const UP = 'up';
    private const DOWN = 'down';

    public function runPart1(Input $data): string | int
    {
        $x = 0;
        $y = 0;

        foreach ($data->getAsArray() as $line) {
            $direction = substr($line, 0, -2);
            $distance = (int) substr($line, -1);

            if ($direction === self::FORWARD) {
                $x += $distance;
            } elseif ($direction === self::UP) {
                $y -= $distance;
            } elseif ($direction === self::DOWN) {
                $y += $distance;
            }
        }

        return $x * $y;
    }

    public function runPart2(Input $data): string | int
    {
        $aim = 0;
        $x = 0;
        $y = 0;

        foreach ($data->getAsArray() as $line) {
            $direction = substr($line, 0, -2);
            $distance = (int) substr($line, -1);

            if ($direction === self::FORWARD) {
                $x += $distance;
                $y += $aim * $distance;
            } elseif ($direction === self::UP) {
                $aim -= $distance;
            } elseif ($direction === self::DOWN) {
                $aim += $distance;
            }
        }

        return $x * $y;
    }

    public function getExpectedTestResult1(): ?string
    {
        return '150';
    }

    public function getExpectedTestResult2(): ?string
    {
        return '900';
    }
}
