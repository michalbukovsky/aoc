<?php

declare(strict_types=1);

namespace App\Years\Year2020\Day13;

use App\IDay;
use App\Utils\Input;
use App\Utils\Tools;

class Shuttles implements IDay
{
    public function runPart1(Input $data): string | int
    {
        [$timestamp, $dataString] = $data->getAsArray();

        $shuttles = array_filter(explode(',', $dataString), static function ($item) {
            return $item !== 'x';
        });
        $shuttles = Tools::intifyArray($shuttles);

        $closestTime = INF;
        $closestShuttle = null;

        foreach ($shuttles as $shuttle) {
            $shuttleTime = 0;
            do {
                $shuttleTime += $shuttle;
            } while ($shuttleTime < $timestamp);

            if ($shuttleTime < $closestTime) {
                $closestTime = $shuttleTime;
                $closestShuttle = $shuttle;
            }
        }

        return ($closestTime - $timestamp) * $closestShuttle;
    }

    public function runPart2(Input $data): string | int
    {
        [1 => $dataString] = $data->getAsArray();

        $shuttles = explode(',', $dataString);
        $shuttlesOrdered = [];
        foreach ($shuttles as $index => $shuttle) {
            if ($shuttle === 'x') {
                continue;
            }
            $shuttlesOrdered[$index] = (int) $shuttle;
        }
        asort($shuttlesOrdered);
        end($shuttlesOrdered);
        $maxIndex = key($shuttlesOrdered);
        reset($shuttlesOrdered);

        $timestamp = 1;
        $step = 1;
        $nowSolvingIndex = 0;
        while (true) {
            echo "$nowSolvingIndex $timestamp\n";
            $lastSolved = $this->isSolvedIndex($timestamp, $shuttlesOrdered);
            if ($lastSolved === $maxIndex) {
                return $timestamp;
            }
            if ($lastSolved === $nowSolvingIndex) {
                next($shuttlesOrdered);
                $nowSolvingIndex = key($shuttlesOrdered);
                $step *= $shuttlesOrdered[$lastSolved];
            }

            $timestamp += $step;
        }
    }

    /**
     * Highest solved index, null if all
     *
     * @param int $timestamp
     * @param array $shuttles
     *
     * @return int|null
     */
    protected function isSolvedIndex(int $timestamp, array $shuttles): ?int
    {
        $lastSolved = null;
        foreach ($shuttles as $index => $shuttle) {
            if (($timestamp + $index) % $shuttle === 0) {
                $lastSolved = $index;
            } else {
                return $lastSolved;
            }
        }

        return $lastSolved;
    }

    public function getExpectedTestResult1(): ?string
    {
        return '295';
    }

    public function getExpectedTestResult2(): ?string
    {
        return '1068781';
    }
}
