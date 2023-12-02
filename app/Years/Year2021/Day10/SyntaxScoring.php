<?php declare(strict_types = 1);

namespace App\Years\Year2021\Day10;

use App\IDay;
use App\Utils\Input;

class SyntaxScoring implements IDay
{
    private const OPENING = ['(' => 3, '[' => 57, '{' => 1197, '<' => 25137];
    private const CLOSING = [')' => 3, ']' => 57, '}' => 1197, '>' => 25137];
    private const OPENING_PART_2 = ['(' => 1, '[' => 2, '{' => 3, '<' => 4];


    public function runPart1(Input $data): string | int
    {
        $score = 0;

        foreach ($data->getAsArray() as $line) {
            $buffer = [];
            $i = 0;

            do {
                $char = $line[$i];
                if ($this->isOpening($char)) {
                    $buffer[] = $char;
                    continue;
                }

                $previousChar = array_pop($buffer);
                if (!$this->areMatching($previousChar, $char)) {
                    $score += self::CLOSING[$char];
                    break;
                }
            } while (++$i < strlen($line));
        }

        return (string)$score;
    }


    public function runPart2(Input $data): string | int
    {
        $scores = [];

        foreach ($data->getAsArray() as $line) {
            $buffer = [];
            $i = 0;

            do {
                $char = $line[$i];
                if ($this->isOpening($char)) {
                    $buffer[] = $char;
                    continue;
                }

                $previousChar = array_pop($buffer);
                if (!$this->areMatching($previousChar, $char)) {
                    continue 2;
                }
            } while (++$i < strlen($line));

            if ($buffer !== []) {
                $scores[] = $this->getScoreForMissingClosingChars($buffer);
            }
        }

        sort($scores);

        return (string)$scores[(count($scores) - 1) / 2];
    }


    protected function isOpening(string $char): bool
    {
        return isset(self::OPENING[$char]);
    }


    private function areMatching(string $opening, string $closing): bool
    {
        return self::OPENING[$opening] === self::CLOSING[$closing];
    }


    private function getScoreForMissingClosingChars(array $buffer): int
    {
        $score = 0;
        $buffer = array_reverse($buffer);
        foreach ($buffer as $char) {
            $score = $score * 5 + self::OPENING_PART_2[$char];
        }

        return $score;
    }


    public function getExpectedTestResult1(): ?string
    {
        return '26397';
    }


    public function getExpectedTestResult2(): ?string
    {
        return '288957';
    }
}
