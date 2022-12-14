<?php declare(strict_types = 1);

namespace App;

use App\Utils\Grid;
use App\Utils\Input;
use App\Utils\Outputter;
use App\Utils\Vector2Int;

class CathodeRayTube implements IDay
{
    public function runPart1(Input $data): string
    {
        $commands = $data->getAsArray();
        $cycle = $sleep = $add = $sum = 0;
        $x = 1;

        while (true) {
            $cycle++;
            if ($cycle % 40 === 20) {
                $sum += $cycle * $x;
            }

            if ($sleep > 0) {
                $sleep--;
                if ($sleep === 0) {
                    $x += $add;
                }
                continue;
            }

            $command = current($commands);
            if (next($commands) === false) {
                break;
            }

            if ($command === 'noop') {
                continue;
            }

            $add = (int) substr($command, 5);
            $sleep = 1;
        }

        return (string) $sum;
    }


    public function runPart2(Input $data): string
    {
        $commands = $data->getAsArray();
        $cycle = $sleep = $add = 0;
        $x = 1;
        $grid = new Grid();

        while (true) {
            $cycle++;
            $posX = ($cycle - 1) % 40;

            if ($x - 1 <= $posX && $x + 1 >= $posX) {
                $grid->setValue(new Vector2Int($posX, (int) (($cycle - 1) / 40)), true);
            }

            if ($sleep > 0) {
                $sleep--;
                if ($sleep === 0) {
                    $x += $add;
                }
                continue;
            }

            $command = current($commands);
            if (next($commands) === false) {
                break;
            }

            if ($command === 'noop') {
                continue;
            }

            $add = (int) substr($command, 5);
            $sleep = 1;
        }

        Outputter::dump2DArray($grid->toArray(), 0, 0, 40);

        return '0';
    }


    public function getExpectedTestResult1(): ?string
    {
        return '13140';
    }


    public function getExpectedTestResult2(): ?string
    {
        return '0';
    }
}
