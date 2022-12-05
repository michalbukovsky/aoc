<?php declare(strict_types = 1);

namespace App;

use App\Utils\Input;

class RucksackReorganization implements IDay
{

    public function runPart1(Input $data): string
    {
        $score = 0;
        $scores = $this->getScores();

        foreach ($data->getAsArrayOfArrayOfChars() as $group) {
            $halfCount = (int) (count($group) / 2);
            $firstHalf = array_slice($group, 0, $halfCount);
            $secondHalf = array_slice($group, $halfCount, $halfCount);

            $intersectChars = array_intersect($firstHalf, $secondHalf);

            $score += $scores[reset($intersectChars)];
        }

        return (string) $score;
    }


    public function runPart2(Input $data): string
    {
        $score = 0;
        $scores = $this->getScores();
        foreach (array_chunk($data->getAsArrayOfArrayOfChars(), 3) as $chunk) {
            $intersectArray = array_intersect(...$chunk);

            $score += $scores[reset($intersectArray)];
        }

        return (string) $score;
    }


    public function getExpectedTestResult1(): ?string
    {
        return '157';
    }


    public function getExpectedTestResult2(): ?string
    {
        return '70';
    }


    private function getScores(): array
    {
        return array_combine([...range('a', 'z'), ...range('A', 'Z')], range(1, 52));
    }
}
