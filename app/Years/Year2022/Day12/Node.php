<?php declare(strict_types = 1);

namespace App\Years\Year2022\Day12;

use App\Utils\Vector2Int;

class Node
{
    private int $distanceToEnd;

    private int $cost;

    private bool $disabled = false;


    public function __construct(
        private readonly int $height,
        private readonly Vector2Int $pos,
        private readonly int $distanceFromStart,
        Vector2Int $end,
    ) {
        $this->distanceToEnd = $pos->getDistanceManhattan($end);
        $this->calculateCost();
    }


    public function getHeight(): int
    {
        return $this->height;
    }


    public function getDistanceFromStart(): int
    {
        return $this->distanceFromStart;
    }


    public function getCost(): int
    {
        return $this->cost;
    }


    public function getPos(): Vector2Int
    {
        return $this->pos;
    }


    public function disable(): void
    {
        $this->disabled = true;
    }


    public function isDisabled(): bool
    {
        return $this->disabled;
    }


    private function calculateCost(): void
    {
        $this->cost = $this->distanceFromStart + $this->distanceToEnd;
    }
}

