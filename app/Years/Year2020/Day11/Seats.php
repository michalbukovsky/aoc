<?php

declare(strict_types=1);

namespace App\Years\Year2020\Day11;

use App\IDay;
use App\Utils\Input;

class Seats implements IDay
{
    public function runPart1(Input $data): string | int
    {
        $that = $this;

        return $this->getOccupiedSeats(
            $data,
            static function (array $seatsBefore, int $row, int $col) use ($that) {
                return $that->isSeatOccupiedNeighboring($seatsBefore, $row, $col);
            },
        );
    }

    public function runPart2(Input $data): string | int
    {
        $that = $this;

        return $this->getOccupiedSeats(
            $data,
            static function (array $seatsBefore, int $row, int $col) use ($that, $data) {
                return $that->isSeatOccupiedAcross($data, $seatsBefore, $row, $col);
            },
        );
    }

    protected function getOccupiedSeats(Input $data, callable $isOccupiedFn): int
    {
        $seatsAfter = $this->getSeats($data);

        do {
            $occupied = 0;
            $seatsBefore = $seatsAfter;
            $seatsAfter = [];

            foreach ($seatsBefore as $row => $seatsRow) {
                foreach ($seatsRow as $col => $seat) {
                    $isOccupied = $isOccupiedFn($seatsBefore, $row, $col);
                    if ($isOccupied) {
                        $occupied++;
                    }
                    $seatsAfter[$row][$col] = $isOccupied;
                }
            }

            $this->dumpSeats($seatsAfter);
        } while ($seatsBefore !== $seatsAfter);

        return $occupied;
    }

    protected function isSeatOccupiedNeighboring(array $seatsBefore, int $row, int $col): bool
    {
        $wasOccupiedBefore = $seatsBefore[$row][$col];
        $neighboring = 0;

        for ($myRow = $row - 1; $myRow <= $row + 1; $myRow++) {
            for ($myCol = $col - 1; $myCol <= $col + 1; $myCol++) {
                if ($myRow === $row && $myCol === $col) {
                    continue;
                }

                if (($seatsBefore[$myRow][$myCol] ?? null) === true) {
                    $neighboring++;
                }
            }
        }

        if ($neighboring >= 4) {
            return false;
        }
        if ($neighboring === 0) {
            return true;
        }

        return $wasOccupiedBefore;
    }

    protected function isSeatOccupiedAcross(Input $data, array $seats, int $rowOrigin, int $colOrigin): bool
    {
        $wasOccupiedBefore = $seats[$rowOrigin][$colOrigin];
        $neighboring = 0;
        $rowsTotal = $data->getLinesCount();
        $colsTotal = strlen($data->getAsArray()[0]);

        for ($rowDir = -1; $rowDir <= 1; $rowDir++) {
            for ($colDir = -1; $colDir <= 1; $colDir++) {
                if ($rowDir === 0 && $colDir === 0) {
                    continue;
                }

                $rowLook = $rowOrigin;
                $colLook = $colOrigin;
                while (min($rowLook + $rowDir, $colLook + $colDir) >= 0 && $rowLook + $rowDir < $rowsTotal && $colLook + $colDir < $colsTotal) {
                    $rowLook += $rowDir;
                    $colLook += $colDir;
                    if (!isset($seats[$rowLook][$colLook])) {
                        continue;
                    }
                    if ($seats[$rowLook][$colLook] === true) {
                        $neighboring++;
                        break;
                    }

                    break;  // empty seat found
                }
            }
        }

        if ($neighboring >= 5) {
            return false;
        }
        if ($neighboring === 0) {
            return true;
        }

        return $wasOccupiedBefore;
    }

    protected function dumpSeats(array $seats): void
    {
        foreach ($seats as $row) {
            $columns = count($seats[0]);
            for ($myCol = 0; $myCol <= $columns; $myCol++) {
                if (!isset($row[$myCol])) {
                    echo '.';
                } else {
                    echo($row[$myCol] ? '#' : 'L');
                }
            }
            echo "\n";
        }
        echo "\n";
    }

    public function getExpectedTestResult1(): ?string
    {
        return '37';
    }

    public function getExpectedTestResult2(): ?string
    {
        return '26';
    }

    private function getSeats(Input $data): array
    {
        $seats = [];
        foreach ($data->getAsArray() as $line) {
            $row = [];
            $col = 0;
            while (isset($line[$col])) {
                if ($line[$col] === 'L') {
                    $row[$col] = false;
                }
                $col++;
            }

            $seats[] = $row;
        }

        return $seats;
    }
}
