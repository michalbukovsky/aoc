<?php declare(strict_types = 1);

namespace App\Utils;

class Vector2Int
{
    public function __construct(
        private readonly int $x,
        private readonly int $y,
    ) {
    }


    public function getX(): int
    {
        return $this->x;
    }


    public function getY(): int
    {
        return $this->y;
    }


    public function getMin(): int
    {
        return min($this->x, $this->y);
    }


    public function getMax(): int
    {
        return max($this->x, $this->y);
    }


    public function getLength(): int
    {
        return abs($this->y - $this->x);
    }


    public function contains(Vector2Int $vector2Int): bool
    {
        return $this->getMin() <= $vector2Int->getMin() && $this->getMax() >= $vector2Int->getMax();
    }


    public function intersects(Vector2Int $vector2Int): bool
    {
        return $this->getMin() <= $vector2Int->getMax() && $this->getMax() >= $vector2Int->getMin();
    }
}
