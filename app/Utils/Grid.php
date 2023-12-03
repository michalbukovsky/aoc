<?php

declare(strict_types=1);

namespace App\Utils;

use Generator;

final class Grid
{
    /**
     * @var array[]
     */
    private array $grid = [];

    public static function initByInput(Input $data): self
    {
        $grid = new self();

        $y = 0;
        foreach ($data->getAsArrayOfArraysOfChars() as $line) {
            $x = 0;
            foreach ($line as $item) {
                $grid->setValueXY($x, $y, $item);
                ++$x;
            }
            ++$y;
        }

        return $grid;
    }

    public static function initByValue(int $xSize, int $ySize, string | int | bool $value): self
    {
        $grid = new self();

        for ($y = 0; $y < $ySize; $y++) {
            for ($x = 0; $x < $xSize; $x++) {
                $grid->setValueXY($x, $y, $value);
            }
        }

        return $grid;
    }

    public function setValue(Vector2Int $position, mixed $value): void
    {
        $this->grid[$position->getY()][$position->getX()] = $value;
    }

    public function getValueXY(int $x, int $y): null | string | int | bool
    {
        return $this->grid[$y][$x] ?? null;
    }

    public function setValueXY(int $x, int $y, mixed $value): void
    {
        $this->grid[$y][$x] = $value;
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

    public function getMaxY(): int
    {
        return (int) max(array_keys($this->grid));
    }

    public function getRows(): array
    {
        return $this->grid;
    }

    public function getRow(int $int): array
    {
        return $this->grid[$int] ?? [];
    }

    public function isSet($x, $y): bool
    {
        return isset($this->grid[$y][$x]);
    }

    /**
     * @return Generator<string|int|bool> "$x:$y" => $value
     */
    public function getNeighborsDiagonal(int $xCenter, int $yCenter): Generator
    {
        for ($y = $yCenter - 1; $y <= $yCenter + 1; $y++) {
            for ($x = $xCenter - 1; $x <= $xCenter + 1; $x++) {
                if (($x === $xCenter && $y === $yCenter) || !$this->isSet($x, $y)) {
                    continue;
                }

                yield "$x:$y" => $this->grid[$y][$x];
            }
        }
    }
}