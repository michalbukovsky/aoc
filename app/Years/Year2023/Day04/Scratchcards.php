<?php declare(strict_types=1);

namespace App\Years\Year2023\Day04;

use App\IDay;
use App\Utils\Input;

class Scratchcards implements IDay
{
    public function runPart1(Input $data): string | int
    {
        $scoreTotal = 0;
        // Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53
        foreach ($data->getAsArray() as $card) {
            $wins = $this->getWinsFromCard($card);
            $score = $wins ? 1 : 0;
            for ($i = 1; $i < $wins; $i++) {
                $score *= 2;
            }

            $scoreTotal += $score;
        }

        return $scoreTotal;
    }

    public function runPart2(Input $data): string | int
    {
        $cardCounts = array_fill(0, $data->getLinesCount(), 1);
        $cardIndex = 0;

        // Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53
        foreach ($data->getAsArray() as $card) {
            $wins = $this->getWinsFromCard($card);

            for ($i = $cardIndex + 1; $i <= $cardIndex + $wins; $i++) {
                if (!isset($cardCounts[$i])) {
                    break;
                }
                $cardCounts[$i] += $cardCounts[$cardIndex];
            }

            ++$cardIndex;
        }

        return array_sum($cardCounts);
    }

    public function getExpectedTestResult1(): ?string
    {
        return '13';
    }

    public function getExpectedTestResult2(): ?string
    {
        return '30';
    }

    private function getWinsFromCard(string $card): int
    {
        preg_match('~.+: (.+) \| (.+)$~', $card, $m);
        [1 => $winningNumbers, 2 => $myNumbers] = $m;
        $winningNumbersArray = array_filter(explode(' ', $winningNumbers));
        $myNumbersArray = array_filter(explode(' ', $myNumbers));

        return count(array_intersect($winningNumbersArray, $myNumbersArray));
    }
}
