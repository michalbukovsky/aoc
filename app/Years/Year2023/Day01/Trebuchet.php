<?php declare(strict_types=1);

namespace App\Years\Year2023\Day01;

use App\IDay;
use App\Utils\Input;
use App\Utils\SmartString;

class Trebuchet implements IDay
{
    private const REPLACEMENTS = [
        '~<one>~' => 1,
        '~<two>~' => 2,
        '~<three>~' => 3,
        '~<four>~' => 4,
        '~<five>~' => 5,
        '~<six>~' => 6,
        '~<seven>~' => 7,
        '~<eight>~' => 8,
        '~<nine>~' => 9,
    ];

    public function runPart1(Input $data): string
    {
        $sum = 0;

        foreach ($data->getAsArray() as $line) {
            $firstNumber = null;
            $lastNumber = null;

            foreach (new SmartString($line) as $char) {
                if (!is_numeric($char)) {
                    continue;
                }

                if ($firstNumber === null) {
                    $firstNumber = $char;
                }

                $lastNumber = $char;
            }

            $sum += (int) "$firstNumber$lastNumber";
        }

        return (string) $sum;
    }

    public function runPart2(Input $data): string
    {
        $dataString = $data->getAsString();
        // $2 is there twice so do don't accidentally lose the part of next number
        $dataString = preg_replace('~^(.*?)(one|two|three|four|five|six|seven|eight|nine)~m', '$1<$2>$2', $dataString);
        $dataString = preg_replace('~(.+)(one|two|three|four|five|six|seven|eight|nine)(.*?)$~m', '$1<$2>$3', $dataString);
        $dataString = str_replace(['<<', '>>'], ['<', '>'], $dataString);
        $dataString = preg_replace(array_keys(self::REPLACEMENTS), array_values(self::REPLACEMENTS), $dataString);

        $data->setData($dataString);

        return $this->runPart1($data);
    }

    public function getExpectedTestResult1(): ?string
    {
        return '142';
    }

    public function getExpectedTestResult2(): ?string
    {
        return '281';
    }
}
