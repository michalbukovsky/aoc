<?php

declare(strict_types=1);

namespace App\Years\Year2020\Day05;

use App\IDay;
use App\Utils\Input;

class Airplane implements IDay
{
    public function runPart1(Input $data): string | int
    {
        $maxId = 0;
        foreach ($data->getAsArray() as $dataEntry) {
            $maxId = max($maxId, $this->getSeatNumber($dataEntry));
        }

        return $maxId;
    }

    public function runPart2(Input $data): string | int
    {
        $seats = [];
        foreach ($data->getAsArray() as $dataEntry) {
            $seats[$this->getSeatNumber($dataEntry)] = true;
        }

        ksort($seats);

        $lastSeat = 0;
        foreach ($seats as $id => $val) {
            if ($id - 1 !== $lastSeat) {
                echo ($id - 1) . "\n";
            }
            $lastSeat = $id;
        }

        return '';
    }

    protected function getSeatNumber(string $instructions): int
    {
        $row = $this->narrowDown(substr($instructions, 0, 7), 'F', 'B', 127);
        $seat = $this->narrowDown(substr($instructions, 7, 3), 'L', 'R', 7);

        return $row * 8 + $seat;
    }

    protected function narrowDown(string $instructions, string $lowerId, string $upperId, int $initRangeMax): int
    {
        $range = [0, $initRangeMax];
        $instructionsCount = strlen($instructions);

        for ($i = 0; $i < $instructionsCount; $i++) {
            $instruction = $instructions[$i];
            if ($instruction === $lowerId) {
                $range[1] = (int) floor($range[0] + (($range[1] - $range[0]) / 2));
            } elseif ($instruction === $upperId) {
                $range[0] = (int) ceil($range[0] + (($range[1] - $range[0]) / 2));
            } else {
                die("Invalid instruction: $instruction\n");
            }
        }

        if ($range[0] !== $range[1]) {
            die("Messed up range: {$range[0]} {$range[1]}\n");
        }

        return $range[0];
    }

    public function getExpectedTestResult1(): ?string
    {
        return '820';
    }

    public function getExpectedTestResult2(): ?string
    {
        return null;
    }
}
