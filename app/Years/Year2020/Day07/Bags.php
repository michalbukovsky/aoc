<?php

declare(strict_types=1);

namespace App\Years\Year2020\Day07;

use App\IDay;
use App\Utils\Input;

class Bags implements IDay
{
    protected const NO_BAGS = 'no other bags';
    protected const GOLD_BAG = 'shiny gold';

    public function runPart1(Input $data): string | int
    {
        /**
         * @var array<string, array> $bags
         * Bag contents in this form:
         * [
         *   color => null,
         *   color => [
         *     color => 1,
         *     color => 2,
         *   ],
         * ]
         */
        $bags = $this->getBags($data);
        $canContainGold = [];

        foreach ($bags as $name => $contents) {
            if ($this->canContainGoldBag($bags, $name)) {
                $canContainGold[$name] = true;
            }
        }

        return count($canContainGold);
    }

    public function runPart2(Input $data): string | int
    {
        return $this->containsHowMany($this->getBags($data), self::GOLD_BAG);
    }

    protected function getBags(Input $data): array
    {
        $bags = [];

        foreach ($data->getAsArray() as $item) {
            preg_match('~^(.+) bags contain (.+)\.$~', $item, $m);
            [1 => $name, 2 => $contents] = $m;

            if ($contents === self::NO_BAGS) {
                $bags[$name] = null;
                continue;
            }

            $bagContents = [];
            preg_match_all('~(\d) ([a-z ]+) bags?(?:, )?~', $contents, $m, PREG_SET_ORDER);
            foreach ($m as $bagMatch) {
                $bagContents[$bagMatch[2]] = (int) $bagMatch[1];
            }
            $bags[$name] = $bagContents;
        }

        return $bags;
    }

    /**
     * @param array<string, mixed> $bags
     */
    protected function canContainGoldBag(array $bags, string $name): bool
    {
        $contents = $bags[$name];
        if ($contents === null) {
            return false;
        }
        if (array_key_exists(self::GOLD_BAG, $contents)) {
            return true;
        }

        foreach ($contents as $bagInsideName => $count) {
            if ($this->canContainGoldBag($bags, $bagInsideName)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array<string, mixed> $bags
     */
    protected function containsHowMany(array $bags, string $name): int
    {
        $contents = $bags[$name];
        if ($contents === null) {
            return 0;
        }

        $containsCount = 0;
        foreach ($contents as $bagInsideName => $count) {
            $containsCount += $count + $count * $this->containsHowMany($bags, $bagInsideName);
        }

        return $containsCount;
    }

    public function getExpectedTestResult1(): ?string
    {
        return '4';
    }

    public function getExpectedTestResult2(): ?string
    {
        return '126';
    }
}
