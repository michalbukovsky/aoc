<?php declare(strict_types = 1);

namespace App;

use App\Utils\Grid;
use App\Utils\Input;
use App\Utils\Outputter;
use App\Utils\Vector2Int;

class RegolithReservoir implements IDay
{
    private const SOURCE = ['x' => 500, 'y' => 0];


    // 498,4 -> 498,6 -> 496,6
    public function runPart1(Input $data): string
    {
        $grid = $this->initGrid($data);
        $endlessVoid = $grid->getMaxY();
        $settled = 0;

        $settled = $this->dropSand($endlessVoid, $grid, $settled);

        Outputter::dump2DArray($grid->toArray(), 400, 0, 300);

        return (string) $settled;
    }


    public function runPart2(Input $data): string
    {
        $grid = $this->initGrid($data);
        $floor = $grid->getMaxY() + 2;
        $this->drawLine($grid, new Vector2Int(0, $floor), new Vector2Int(1000, $floor));
        $settled = 0;

        $settled = $this->dropSand($floor, $grid, $settled);

        Outputter::dump2DArray($grid->toArray(), 400, 0, 300);

        return (string) $settled;
    }


    public function getExpectedTestResult1(): ?string
    {
        return '24';
    }


    public function getExpectedTestResult2(): ?string
    {
        return '93';
    }


    protected function initGrid(Input $data): Grid
    {
        $grid = new Grid();

        foreach ($data->getAsArrayOfArrays(spaceSeparator: ' -> ') as $line) {
            $prev = null;
            foreach ($line as $coords) {
                [$x, $y] = explode(',', $coords);
                $current = new Vector2Int((int) $x, (int) $y);

                if ($prev === null) {
                    $prev = $current;
                }
                $this->drawLine($grid, $prev, $current);

                $prev = $current;
            }
        }

        return $grid;
    }


    private function drawLine(Grid $grid, Vector2Int $start, Vector2Int $end)
    {
        $vector = $start->getVectorTo($end);
        $normals = $vector->getNormals();
        do {
            $grid->setValue($start->add($normals), '#');
        } while (!$start->equals($end));
    }


    protected function dropSand(int $endlessVoid, Grid $grid, int $settled): int
    {
        do {
            $sand = new Vector2Int(self::SOURCE['x'], self::SOURCE['y']);

            do {
                if ($sand->getY() > $endlessVoid) {
                    break 2;
                }

                if ($grid->getValue($sand->getY() + 1, $sand->getX()) === null) {
                    $sand->addY(1);
                    continue;
                }

                if ($grid->getValue($sand->getY() + 1, $sand->getX() - 1) === null) {
                    $sand->addX(-1);
                    $sand->addY(1);
                    continue;
                }

                if ($grid->getValue($sand->getY() + 1, $sand->getX() + 1) === null) {
                    $sand->addX(1);
                    $sand->addY(1);
                    continue;
                }

                $grid->setValue($sand, 'o');
                $settled++;

                if ($sand->getY() === self::SOURCE['y']) {
                    break 2;
                }

                break;
            } while (true);
        } while (true);

        return $settled;
    }
}
