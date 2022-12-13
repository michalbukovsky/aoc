<?php declare(strict_types = 1);

namespace App;

use App\Utils\Grid;
use App\Utils\Input;
use App\Utils\Outputter;
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
        return $this->runPart($data, 1);
    }


    public function runPart2(Input $data): string
    {
        return $this->runPart($data, 9);
    }


    public function getExpectedTestResult1(): ?string
    {
        return '13';
    }


    public function getExpectedTestResult2(): ?string
    {
        return '36';
    }


    private function runPart(Input $data, int $tailsCount): string
    {
        $visitedByTails = new Grid();

        $head = new Knot(new Vector2Int(0, 0), null);
        $tails = $this->generateTails($tailsCount, $head);
        $visitedByTails->setValue($head->getPos(), true);

        foreach ($data->getAsArray() as $line) {
            $direction = $line[0];
            $distance = (int) substr($line, 2);
            $directionVector = self::DIRS[$direction];

            for ($i = 0; $i < $distance; $i++) {
                $head->moveBy($directionVector[0], $directionVector[1]);

                foreach ($tails as $tailIndex => $tail) {
                    $previousTail = $tail->getKnotPrevious();
                    assert($previousTail !== null);

                    $knotDistance = $tail->getPos()->getVectorTo($previousTail->getPos());
                    if ($knotDistance > 1.5) {
                        $tail->moveTowards($previousTail);

                        if ($tailIndex === $tailsCount - 1) {
                            $visitedByTails->setValue($tail->getPos(), true);
                        }
                    }
                }
            }
        }

        Outputter::dump2DArray($visitedByTails->toArray(), -40, 30);

        return (string) $visitedByTails->getSum();
    }


    /**
     * @return array<int, Knot>
     */
    private function generateTails(int $count, Knot $previous): array
    {
        $knots = [];
        for ($i = 0; $i < $count; $i++) {
            $knot = new Knot(new Vector2Int(0, 0), $previous);
            $previous = $knot;
            $knots[] = $knot;
        }

        return $knots;
    }
}
