<?php declare(strict_types = 1);

namespace App\Years\Year2022\Day04;

use App\IDay;
use App\Utils\Input;
use App\Utils\Vector2Int;
use Generator;

class CampCleanup implements IDay
{

    public function runPart1(Input $data): string | int
    {
        $overlappingGroups = 0;

        /** @var Vector2Int[] $vectors */
        foreach ($this->getVectors($data) as $vectors) {
            [$vector1, $vector2] = $vectors;
            if ($vector1->contains($vector2) || $vector2->contains($vector1)) {
                $overlappingGroups++;
            }
        }

        return $overlappingGroups;
    }


    public function runPart2(Input $data): string | int
    {
        $intersectingGroups = 0;

        /** @var Vector2Int[] $vectors */
        foreach ($this->getVectors($data) as $vectors) {
            [$vector1, $vector2] = $vectors;
            if ($vector1->intersects($vector2)) {
                $intersectingGroups++;
            }
        }

        return $intersectingGroups;
    }


    public function getExpectedTestResult1(): ?string
    {
        return '2';
    }


    public function getExpectedTestResult2(): ?string
    {
        return '4';
    }


    /**
     * @return Generator<array<Vector2Int>>
     */
    private function getVectors(Input $data): Generator
    {
        foreach ($data->getAsArrayOfArrays(spaceSeparator: ',') as $groups) {
            /** @var Vector2Int[] $vectors */
            $vectors = [];
            foreach ($groups as $group) {
                [$min, $max] = explode('-', $group);
                $vectors[] = new Vector2Int((int) $min, (int) $max);
            }

            yield $vectors;
        }
    }
}
