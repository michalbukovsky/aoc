<?php declare(strict_types = 1);

namespace App\Utils;

final class Grid
{
    /**
     * @var array[]
     */
    private array $grid;


    public function initByValue(int $xSize, int $ySize, mixed $value): void
    {
        for ($row = 0; $row < $ySize; $row++) {
            for ($col = 0; $col < $xSize; $col++) {
                $this->grid[$row][$col] = $value;
            }
        }
    }


    public function getValue(int $row, int $col): ?string
    {
        return $this->grid[$row][$col] ?? null;
    }


    public function setValue(Vector2Int $position, mixed $value): void
    {
        $this->grid[$position->getY()][$position->getX()] = $value;
    }


    public function getSum(): int
    {
        $sum = 0;
        foreach ($this->grid as $row) {
            foreach ($row as $value) {
                $sum += $value;
            }
        }

        return $sum;
    }


    public function toArray(): array
    {
        return $this->grid;
    }
}
