<?php declare(strict_types = 1);

namespace App;

use App\Utils\Input;

class RockPaperScissors implements IDay
{
    private const THEM_ROCK = 'A';
    private const THEM_PAPER = 'B';
    private const THEM_SCISSORS = 'C';
    private const ME_ROCK = 'X';
    private const ME_PAPER = 'Y';
    private const ME_SCISSORS = 'Z';

    private const SCORE_BY_MY_TYPE = [
        self::ME_ROCK => 1,
        self::ME_PAPER => 2,
        self::ME_SCISSORS => 3,
    ];

    private const SCORE_BY_RESULT = [
        self::THEM_ROCK . self::ME_ROCK => 3,
        self::THEM_ROCK . self::ME_PAPER => 6,
        self::THEM_ROCK . self::ME_SCISSORS => 0,
        self::THEM_PAPER . self::ME_ROCK => 0,
        self::THEM_PAPER . self::ME_PAPER => 3,
        self::THEM_PAPER . self::ME_SCISSORS => 6,
        self::THEM_SCISSORS . self::ME_ROCK => 6,
        self::THEM_SCISSORS . self::ME_PAPER => 0,
        self::THEM_SCISSORS . self::ME_SCISSORS => 3,
    ];

    private const DESIRED_LOSE = 'X';
    private const DESIRED_DRAW = 'Y';
    private const DESIRED_WIN = 'Z';

    private const MINE_BY_RESULT = [
        self::THEM_ROCK . self::DESIRED_LOSE => self::ME_SCISSORS,
        self::THEM_ROCK . self::DESIRED_DRAW => self::ME_ROCK,
        self::THEM_ROCK . self::DESIRED_WIN => self::ME_PAPER,
        self::THEM_PAPER . self::DESIRED_LOSE => self::ME_ROCK,
        self::THEM_PAPER . self::DESIRED_DRAW => self::ME_PAPER,
        self::THEM_PAPER . self::DESIRED_WIN => self::ME_SCISSORS,
        self::THEM_SCISSORS . self::DESIRED_LOSE => self::ME_PAPER,
        self::THEM_SCISSORS . self::DESIRED_DRAW => self::ME_SCISSORS,
        self::THEM_SCISSORS . self::DESIRED_WIN => self::ME_ROCK,
    ];


    public function runPart1(Input $data): string
    {
        $score = 0;

        foreach ($data->getAsArrayOfArrays() as $line) {
            [$their, $mine] = $line;

            $score += self::SCORE_BY_MY_TYPE[$mine];
            $score += self::SCORE_BY_RESULT[$their . $mine];
        }

        return (string) $score;
    }


    public function runPart2(Input $data): string
    {
        $score = 0;

        foreach ($data->getAsArrayOfArrays() as $line) {
            [$their, $desiredResult] = $line;

            $mine = self::MINE_BY_RESULT[$their . $desiredResult];
            $score += self::SCORE_BY_MY_TYPE[$mine];
            $score += self::SCORE_BY_RESULT[$their . $mine];
        }

        return (string) $score;
    }


    public function getExpectedTestResult1(): ?string
    {
        return '15';
    }


    public function getExpectedTestResult2(): ?string
    {
        return '12';
    }
}
