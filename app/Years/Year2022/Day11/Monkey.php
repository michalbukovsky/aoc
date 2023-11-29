<?php declare(strict_types = 1);

namespace App\Years\Year2022\Day11;

final class Monkey
{
    public function __construct(
        private array $items,
        private readonly string $operation,
        private readonly int $divisibleBy,
        private readonly int $passToMonkeyIfTrue,
        private readonly int $passToMonkeyIfFalse,
        private int $inspections = 0,
    ) {
    }


    /**
     * @return int[]
     */
    public function getItems(): array
    {
        return $this->items;
    }


    public function addItem(int $item): void
    {
        $this->items[] = $item;
    }


    public function removeItem(int $index): void
    {
        unset($this->items[$index]);
    }


    public function getOperation(): string
    {
        return $this->operation;
    }


    public function getDivisibleBy(): int
    {
        return $this->divisibleBy;
    }


    public function getPassToMonkeyIfTrue(): int
    {
        return $this->passToMonkeyIfTrue;
    }


    public function getPassToMonkeyIfFalse(): int
    {
        return $this->passToMonkeyIfFalse;
    }


    public function inspect(): void
    {
        $this->inspections++;
    }


    public function getInspections(): int
    {
        return $this->inspections;
    }
}
