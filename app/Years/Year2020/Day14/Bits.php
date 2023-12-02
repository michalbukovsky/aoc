<?php

declare(strict_types=1);

namespace App\Years\Year2020\Day14;

use App\IDay;
use App\Utils\Input;

class Bits implements IDay
{
    protected const BITS = 36;

    public function runPart1(Input $data): string | int
    {
        $memory = [];
        $posMask = 0;
        $negMask = 0;

        foreach ($data->getAsArray() as $line) {
            if (str_starts_with($line, 'mask')) {
                $mask = strrev(substr($line, 7));
                $posMask = 0;
                $negMask = 0;
                for ($i = 0; $i < self::BITS; $i++) {
                    if ($mask[$i] === '1') {
                        $posMask += 2 ** $i;
                    } elseif ($mask[$i] === '0') {
                        $negMask += 2 ** $i;
                    }
                }
            } else {
                preg_match('~^mem\[(\d+)] = (\d+)$~', $line, $m);
                [1 => $address, 2 => $value] = $m;
                $memory[$address] = ($value | $posMask) & ~$negMask;
            }
        }

        return array_sum($memory);
    }

    public function runPart2(Input $data): string | int
    {
        // TODO: Implement runPart2(Input $data) method.

        return '';
    }

    public function getExpectedTestResult1(): ?string
    {
        return '165';
    }

    public function getExpectedTestResult2(): ?string
    {
        return '208';
    }
}
