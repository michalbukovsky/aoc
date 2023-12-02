<?php declare(strict_types = 1);

namespace App\Years\Year2022\Day11;

use App\IDay;
use App\Utils\Input;
use App\Utils\Tools;

class MonkeyInTheMiddle implements IDay
{
    public function runPart1(Input $data): string | int
    {
        return $this->runPart($data, 20, true);
    }


    public function runPart2(Input $data): string | int
    {
        return $this->runPart($data, 10_000, false);
    }


    public function getExpectedTestResult1(): ?string
    {
        return '10605';
    }


    public function getExpectedTestResult2(): ?string
    {
        return '2713310158';
    }


    private function runPart(Input $data, int $rounds, bool $reduceWorry): string
    {
        /** @var Monkey[] $monkeys */
        $monkeys = [];
        $divisor = 1;

        foreach ($data->getAsArrayOfArrays(false, "\n\n", "\n") as $monkeyData) {
            $divisibleBy = (int) substr($monkeyData[3], 21);
            $monkeys[] = new Monkey(
                Tools::intifyArray(explode(', ', substr($monkeyData[1], 18))),
                substr($monkeyData[2], 19),
                $divisibleBy,
                (int) substr($monkeyData[4], 29),
                (int) substr($monkeyData[5], 30),
            );
            $divisor *= $divisibleBy;
        }

        for ($round = 1; $round <= $rounds; $round++) {
            foreach ($monkeys as $monkey) {
                foreach ($monkey->getItems() as $index => $item) {
                    $item = $this->performOperation($item, $monkey, $divisor);
                    $monkey->inspect();
                    if ($reduceWorry) {
                        $item = (int) ($item / 3);
                    }

                    $monkey->removeItem($index);
                    $passTo = $item % $monkey->getDivisibleBy() === 0
                        ? $monkey->getPassToMonkeyIfTrue()
                        : $monkey->getPassToMonkeyIfFalse();
                    $monkeys[$passTo]->addItem($item);
                }
            }
        }

        usort($monkeys, static fn(Monkey $a, Monkey $b) => $b->getInspections() <=> $a->getInspections());

        return ($monkeys[0]->getInspections() * $monkeys[1]->getInspections());
    }


    private function performOperation(int $item, Monkey $monkey, int $divisor): int
    {
        $equation = str_replace('old', (string) $item, $monkey->getOperation());
        if (str_contains($equation, '*')) {
            $equation = "($equation) % $divisor";
        }

        // :)
        return eval("return $equation;");
    }
}
