<?php declare(strict_types=1);

namespace App\Years\Year2023\Day02;

use App\IDay;
use App\Utils\Input;

class CubeConundrum implements IDay
{
    /**
     * Input:
     * Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green
     */
    public function runPart1(Input $data): string
    {
        $validGames = [];
        $game = 0;
        foreach ($data->getAsArray() as $line) {
            ++$game;

            $line = substr($line, strpos($line, ':') + 1);
            foreach (explode(';', $line) as $pickSet) {
                $bag = [
                    'r' => 12,
                    'g' => 13,
                    'b' => 14,
                ];

                foreach (explode(',', $pickSet) as $pick) {
                    $pick = trim($pick);
                    preg_match('~^(\d+) (.)~', $pick, $m);
                    [1 => $count, 2 => $color] = $m;

                    $bag[$color] -= (int) $count;
                }

                if (!$this->isBagValid($bag)) {
                    continue 2;
                }
            }

            $validGames[] = $game;
        }

        return (string) array_sum($validGames);
    }

    public function runPart2(Input $data): string
    {
        $sum = 0;
        foreach ($data->getAsArray() as $line) {
            $requiredBagCounts = [
                'r' => 0,
                'g' => 0,
                'b' => 0,
            ];

            $line = substr($line, strpos($line, ':') + 1);
            foreach (explode(';', $line) as $pickSet) {
                $bag = [
                    'r' => 0,
                    'g' => 0,
                    'b' => 0,
                ];

                foreach (explode(',', $pickSet) as $pick) {
                    $pick = trim($pick);
                    preg_match('~^(\d+) (.)~', $pick, $m);
                    [1 => $count, 2 => $color] = $m;

                    $bag[$color] += (int) $count;
                }

                $requiredBagCounts['r'] = max($requiredBagCounts['r'], $bag['r']);
                $requiredBagCounts['g'] = max($requiredBagCounts['g'], $bag['g']);
                $requiredBagCounts['b'] = max($requiredBagCounts['b'], $bag['b']);
            }

            $sum += (int) array_product($requiredBagCounts);
        }

        return (string) $sum;
    }

    public function getExpectedTestResult1(): ?string
    {
        return '8';
    }

    public function getExpectedTestResult2(): ?string
    {
        return '2286';
    }

    private function isBagValid(array $bag): bool
    {
        foreach ($bag as $count) {
            if ($count < 0) {
                return false;
            }
        }

        return true;
    }
}
