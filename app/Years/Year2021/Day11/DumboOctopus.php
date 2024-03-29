<?php declare(strict_types = 1);

namespace App\Years\Year2021\Day11;

use App\IDay;
use App\Utils\Input;

class DumboOctopus implements IDay
{
    private const OCTOPUSES = 100;

    private int $time;

    /** @var Octopus[][] */
    private array $field;

    private int $flashes;


    public function runPart1(Input $data): string | int
    {
        $this->field = $this->initField($data);
        $this->time = 0;
        $this->flashes = 0;

        while (++$this->time <= 100) {
            foreach ($this->field as $y => $line) {
                foreach ($line as $x => $octopus) {
                    $isOutburst = $octopus->addEnergy($this->time);

                    if ($isOutburst) {
                        $this->doFlash($x, $y);
                    }
                }
            }
        }

        return (string)$this->flashes;
    }


    public function runPart2(Input $data): string | int
    {
        $this->field = $this->initField($data);
        $this->time = 0;
        $this->flashes = 0;

        while (++$this->time) {
            $lastFlashes = $this->flashes;

            foreach ($this->field as $y => $line) {
                foreach ($line as $x => $octopus) {
                    $isOutburst = $octopus->addEnergy($this->time);

                    if ($isOutburst) {
                        $this->doFlash($x, $y);
                    }
                }
            }

            if (($this->flashes - $lastFlashes) === self::OCTOPUSES) {
                return (string)$this->time;
            }
        }

        return '';
    }


    /**
     * @return Octopus[][]
     */
    private function initField(Input $data): array
    {
        $field = [];
        foreach ($data->getAsArrayOfArraysOfIntegers() as $y => $line) {
            foreach ($line as $x => $energy) {
                $field[$y][$x] = new Octopus($energy);
            }
        }

        return $field;
    }


    private function doFlash(int $xCenter, int $yCenter): void
    {
        $this->flashes++;

        for ($y = $yCenter - 1; $y <= $yCenter + 1; $y++) {
            for ($x = $xCenter - 1; $x <= $xCenter + 1; $x++) {
                if (!isset($this->field[$y][$x])) {
                    continue;
                }

                $octopus = $this->field[$y][$x];
                $isOutburst = $octopus->addEnergy($this->time);
                if ($isOutburst) {
                    $this->doFlash($x, $y);
                }
            }
        }
    }


    public function getExpectedTestResult1(): ?string
    {
        return '1656';
    }


    public function getExpectedTestResult2(): ?string
    {
        return '195';
    }
}
