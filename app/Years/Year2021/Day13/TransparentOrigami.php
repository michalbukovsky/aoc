<?php declare(strict_types=1);

namespace App\Years\Year2021\Day13;

use App\IDay;
use App\Utils\Input;
use App\Utils\Outputter;
use App\Utils\Tools;

class TransparentOrigami implements IDay
{
    private const X = 'x';
    private const Y = 'y';

    private array $paper;

    private array $folds;

    public function runPart1(Input $data): string | int
    {
        $this->init($data);

        foreach ($this->folds as $fold) {
            $this->fold($fold[0], (int) $fold[1]);
            break;
        }

        return Tools::arraySum2D($this->paper);
    }

    public function runPart2(Input $data): string | int
    {
        $this->init($data);

        foreach ($this->folds as $fold) {
            $this->fold($fold[0], (int) $fold[1]);
        }

        for ($y = 0; $y < 6; $y++) {
            for ($x = 0; $x < 60; $x++) {
                Outputter::notice(isset($this->paper[$y][$x]) ? '█' : ' ', false);
            }
            Outputter::newline();
        }

        return Tools::arraySum2D($this->paper);
    }

    private function init(Input $data): void
    {
        $this->paper = [];
        $this->folds = [];

        foreach ($data->getAsArray() as $line) {
            if (strlen($line) > 9) {
                preg_match('~(.)=(\d+)$~', $line, $m);
                $this->folds[] = [$m[1], $m[2]];
                continue;
            }

            $coords = explode(',', $line);
            $this->paper[$coords[1]][$coords[0]] = true;
        }
    }

    private function fold(string $axis, int $foldLine): void
    {
        ksort($this->paper);
        end($this->paper);
        if ($axis === self::Y) {
            foreach ($this->paper as $y => $line) {
                if ($y <= $foldLine) {
                    continue;
                }

                foreach ($this->paper[$y] as $x => $dot) {
                    $destinationY = 2 * $foldLine - $y;
                    $this->paper[$destinationY][$x] = true;
                }

                unset($this->paper[$y]);
            }

            return;
        }

        foreach ($this->paper as $y => $line) {
            foreach ($line as $x => $dot) {
                if ($x > $foldLine) {
                    $destinationX = 2 * $foldLine - $x;
                    $this->paper[$y][$destinationX] = true;
                    unset($this->paper[$y][$x]);
                }
            }
        }
    }

    public function getExpectedTestResult1(): ?string
    {
        return '17';
    }

    public function getExpectedTestResult2(): ?string
    {
        return '16';
    }
}
