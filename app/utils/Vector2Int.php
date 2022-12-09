<?php declare(strict_types = 1);

namespace App\Utils;

class Vector2Int
{
    public function __construct(
        private int $x,
        private int $y,
    ) {
    }


    public function getX(): int
    {
        return $this->x;
    }


    public function setX(int $x): void
    {
        $this->x = $x;
    }


    public function addX(int $x): void
    {
        $this->x += $x;
    }


    public function getY(): int
    {
        return $this->y;
    }


    public function setY(int $y): void
    {
        $this->y = $y;
    }


    public function addY(int $y): void
    {
        $this->y += $y;
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


    public function getDistance(Vector2Int $vector2Int): float
    {
        return sqrt(
            abs($this->getX() - $vector2Int->getX()) ** 2
            + abs($this->getY() - $vector2Int->getY()) ** 2
        );
    }


    public function replace(Vector2Int $vector2Int): void
    {
        $this->setX($vector2Int->getX());
        $this->setY($vector2Int->getY());
    }
}
