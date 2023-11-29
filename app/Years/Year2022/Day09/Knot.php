<?php declare(strict_types = 1);

namespace App\Years\Year2022\Day09;

use App\Utils\Vector2Int;

class Knot
{
    public function __construct(
        private Vector2Int $pos,
        private ?Knot $previous
    ) {
    }


    public function getPos(): Vector2Int
    {
        return $this->pos;
    }


    public function moveBy(int $x, int $y): void
    {
        $this->pos->addX($x);
        $this->pos->addY($y);
    }


    public function moveTowards(Knot $knot): void
    {
        $xDiff = $knot->pos->getX() - $this->pos->getX();
        $yDiff = $knot->pos->getY() - $this->pos->getY();

        $this->moveBy($xDiff <=> 0, $yDiff <=> 0);
    }


    public function getKnotPrevious(): ?Knot
    {
        return $this->previous;
    }
}
