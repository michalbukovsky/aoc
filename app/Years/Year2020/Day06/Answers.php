<?php

declare(strict_types=1);

namespace App\Years\Year2020\Day06;

use App\IDay;
use App\Utils\Input;

class Answers implements IDay
{
    public function runPart1(Input $data): string | int
    {
        $yesAnswers = 0;    // sum of all yes answers (for every group)

        foreach ($data->getAsArray(separator: "\n\n") as $group) {
            $yesAnswersGroup = [];
            $people = explode("\n", $group);
            foreach ($people as $person) {
                $i = 0;
                while (isset($person[$i])) {
                    $yesAnswersGroup[$person[$i++]] = true;
                }
            }

            $yesAnswers += count($yesAnswersGroup);
        }

        return $yesAnswers;
    }

    public function runPart2(Input $data): string | int
    {
        $yesAnswers = 0;    // sum of all yes answers (for every group)

        foreach ($data->getAsArray(separator: "\n\n") as $group) {
            $yesAnswersGroup = [];
            $people = explode("\n", $group);
            foreach ($people as $person) {
                $i = 0;
                while (isset($person[$i])) {
                    $yesAnswersGroup[$person[$i++]]++;
                }
            }

            $yesAnswers += $this->getAllYesFromGroupCount($yesAnswersGroup, count($people));
        }

        return $yesAnswers;
    }

    protected function getAllYesFromGroupCount(array $yesAnswersGroup, int $countPeople): int
    {
        $yes = 0;
        foreach ($yesAnswersGroup as $answer => $count) {
            if ($count === $countPeople) {
                $yes++;
            }
        }

        return $yes;
    }

    public function getExpectedTestResult1(): ?string
    {
        return '11';
    }

    public function getExpectedTestResult2(): ?string
    {
        return '6';
    }
}