<?php declare(strict_types = 1);

namespace App;

use App\Utils\Grid;
use App\Utils\Input;
use App\Utils\Tools;
use App\Utils\Vector2Int;

class RopeBridge implements IDay
{
    private const DIRS = [
        'U' => [0, -1],
        'R' => [1, 0],
        'D' => [0, 1],
        'L' => [-1, 0],
    ];


    public function runPart1(Input $data): string
    {
        $visitedByTail = new Grid();

        $headPrevious = new Vector2Int(0, 0);
        $head = new Vector2Int(0, 0);
        $tail = new Vector2Int(0, 0);
        $visitedByTail->setValue($tail, true);

        foreach ($data->getAsArray() as $line) {
            $direction = $line[0];
            $distance = (int) substr($line, 2);

            $directionVector = self::DIRS[$direction];

            for ($i = 0; $i < $distance; $i++) {
                $headPrevious->replace($head);

                $head->addX($directionVector[0]);
                $head->addY($directionVector[1]);

                $headTailDistance = $head->getDistance($tail);
                if ($headTailDistance > 1.5) {
                    $tail->replace($headPrevious);
                    $visitedByTail->setValue($tail, true);
                }
            }
        }

        return (string) $visitedByTail->getSum();
    }


    public function runPart2(Input $data): string
    {
        return (string) 0;
    }


    public function getExpectedTestResult1(): ?string
    {
        return '13';
    }


    public function getExpectedTestResult2(): ?string
    {
        return '';
    }
}
