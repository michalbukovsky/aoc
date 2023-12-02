<?php declare(strict_types = 1);

namespace App\Years\Year2022\Day15;

use App\IDay;
use App\Utils\Grid;
use App\Utils\Input;
use App\Utils\Outputter;
use App\Utils\Tools;
use App\Utils\Vector2Int;
use LogicException;

class BeaconExclusionZone implements IDay
{
    private bool $isTest = true;


    public function __construct()
    {
        ini_set('memory_limit', '4G');
    }


    /** Sensor at x=2, y=18: closest beacon is at x=-2, y=15 */
    public function runPart1(Input $data): string | int
    {
        $grid = new Grid();

        foreach ($data->getAsArray() as $line) {
            preg_match('~^Sensor at x=(-?\d+), y=(-?\d+): closest beacon is at x=(-?\d+), y=(-?\d+)$~', $line, $m);
            $sensor = new Vector2Int((int) $m[1], (int) $m[2]);
            $beacon = new Vector2Int((int) $m[3], (int) $m[4]);

            $this->fillNonbeacons($grid, $sensor, $beacon);
        }

        $count = Tools::arrayCount($grid->getRow($this->isTest ? 10 : 2_000_000), true);
        $this->isTest = false;

        return $count;
    }


    public function runPart2(Input $data): string | int
    {
        $size = 4_000_000;
        if ($this->isTest) {
            $this->isTest = false;

            $size = 20;
        }

        $fields = [];
        foreach ($data->getAsArray() as $line) {
            preg_match('~^Sensor at x=(-?\d+), y=(-?\d+): closest beacon is at x=(-?\d+), y=(-?\d+)$~', $line, $m);
            $sensor = new Vector2Int((int) $m[1], (int) $m[2]);
            $beacon = new Vector2Int((int) $m[3], (int) $m[4]);
            $fields[] = new SensorField($sensor, $beacon);
        }

        $point = new Vector2Int(0, 0);
        for ($row = 0; $row < $size; $row++) {
            if ($row % 100 === 0) {
                Outputter::notice('#' . $row);
            }

            $point->setY($row);
            for ($col = 0; $col < $size; $col++) {
                $point->setX($col);

                foreach ($fields as $field) {
                    if ($point->getDistanceManhattan($field->getSensor()) <= $field->getManhattan()) {
                        $col = $field->getSensor()->getX() + $field->getManhattan() - abs($point->getY() - $field->getSensor()->getY());
                        continue 2;
                    }
                }

                return $col * 4_000_000 + $row;
            }
        }

        throw new LogicException('Not found');
    }


    public function getExpectedTestResult1(): ?string
    {
        return '26';
    }


    public function getExpectedTestResult2(): ?string
    {
        return '56000011';
    }


    private function fillNonbeacons(Grid $grid, Vector2Int $sensor, Vector2Int $beacon): void
    {
        $dist = $sensor->getDistanceManhattan($beacon);
        for ($row = -$dist; $row <= $dist; $row++) {
            $y = $sensor->getY() + $row;
            if ($y !== 10 && $y !== 2_000_000) {
                continue;
            }

            for ($col = -$dist + abs($row); $col <= $dist - abs($row); $col++) {
                $x = $sensor->getX() + $col;
                if ($grid->getValueXY($x, $y) === null) {
                    $grid->setValueXY($x, $y, true);
                }
            }
        }

        $grid->setValue($sensor, false);
        $grid->setValue($beacon, false);
    }
}
