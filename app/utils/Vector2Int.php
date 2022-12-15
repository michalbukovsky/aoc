<?php declare(strict_types = 1);

namespace App\Utils;

use Generator;

class Vector2Int
{
    public function __construct(
        private int $x,
        private int $y,
    ) {
    }


    public function add(Vector2Int $vector2Int): self
    {
        $this->x += $vector2Int->getX();
        $this->y += $vector2Int->getY();

        return $this;
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


    public function getDistanceTo(Vector2Int $vector2Int): float
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


    public function equals(Vector2Int $vector2Int): bool
    {
        return $this->x === $vector2Int->getX() && $this->y === $vector2Int->getY();
    }


    public function getDistanceManhattan(Vector2Int $end): int
    {
        return (int) (abs($this->x - $end->getX()) + abs($this->y - $end->getY()));
    }


    /**
     * @return Generator<int, int> Like this: [$x => $y]
     */
    public function getNeighboursCoords(): Generator
    {
        for ($rad = 0; $rad < 2 * M_PI; $rad += M_PI / 2) {
            yield $this->x + (int) sin($rad) => $this->y + (int) cos($rad);
        }
    }


    public function getVectorTo(Vector2Int $end): Vector2Int
    {
        return new Vector2Int($end->getX() - $this->x, $end->getY() - $this->y);
    }


    public function getNormals(): Vector2Int
    {
        return new Vector2Int($this->x <=> 0, $this->y <=> 0);
    }
}
