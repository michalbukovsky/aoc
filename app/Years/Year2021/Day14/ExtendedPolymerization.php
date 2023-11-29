<?php declare(strict_types = 1);

namespace App\Years\Year2021\Day14;

use App\IDay;
use App\Utils\Input;

class ExtendedPolymerization implements IDay
{
    public function runPart1(Input $data): string
    {
        return $this->runSimulation($data, 10);
    }


    public function runPart2(Input $data): string
    {
        return $this->runSimulation($data, 40);
    }


    private function runSimulation(Input $data, int $cycles): string
    {
        $string = $data->getFirstLine(true);
        $replaces = [];

        foreach ($data->getAsArray() as $line) {
            preg_match('~^(..) -> (.)$~', $line, $m);
            $replaces[$m[1]] = $m[1][0] . $m[2] . $m[1][1]; // $replaces['AB'] => 'ACB'
        }

        for ($step = 0; $step < $cycles; $step++) {
            $charIndex = 0;
            do {
                $chars = substr($string, $charIndex, 2);
                if (isset($replaces[$chars])) {
                    $string = substr($string, 0, $charIndex) . $replaces[$chars] . substr($string, $charIndex + 2);
                    $charIndex += 2;
                } else {
                    $charIndex++;
                }
            } while (strlen($chars) === 2);
        }

        $letters = [];
        foreach (str_split($string) as $letter) {
            $letters[$letter]++;
        }

        rsort($letters);

        return (string)(reset($letters) - end($letters));
    }


    public function getExpectedTestResult1(): ?string
    {
        return '1588';
    }


    public function getExpectedTestResult2(): ?string
    {
        return '2188189693529';
    }
}
