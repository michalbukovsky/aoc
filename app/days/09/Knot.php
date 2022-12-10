<?php declare(strict_types = 1);

namespace App;

use App\Utils\Vector2Int;

class Knot
{
    private Vector2Int $posPrevious;


    public function __construct(
        private Vector2Int $pos,
        private ?Knot $previous
    ) {
        $this->posPrevious = new Vector2Int($pos->getX(), $pos->getY());
    }


    public function getPos(): Vector2Int
    {
        return $this->pos;
    }


    public function moveBy(int $x, int $y): void
    {
        $this->posPrevious->replace($this->pos);
        $this->pos->addX($x);
        $this->pos->addY($y);
    }


    public function moveTowards(Knot $knot): void
    {
        $this->posPrevious->replace($this->pos);
        $xDiff = $knot->pos->getX() - $this->pos->getX();
        $yDiff = $knot->pos->getY() - $this->pos->getY();

        if ($xDiff * $yDiff === 0) {
            $this->pos->replace($knot->getPosPrevious());

            return;
        }

        if (abs($xDiff) > abs($yDiff)) {
            $this->pos->addX($xDiff <=> 0);
        } elseif (abs($yDiff) > abs($xDiff)) {
            $this->pos->addY($yDiff <=> 0);
        }
    }


    public function getKnotPrevious(): ?Knot
    {
        return $this->previous;
    }


    public function getPosPrevious(): Vector2Int
    {
        return $this->posPrevious;
    }
}
