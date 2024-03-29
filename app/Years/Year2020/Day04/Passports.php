<?php

declare(strict_types=1);

namespace App\Years\Year2020\Day04;

use App\IDay;
use App\Utils\Input;

class Passports implements IDay
{
    protected const REQUIRED_FIELDS = [
        'byr' => '~^(19\d\d|200[0-2])$~',  // (Birth Year)s
        'iyr' => '~^20(1\d|20)$~',  // (Issue Year)s
        'eyr' => '~^20(2\d|30)$~',  // (Expiration Year)s
        'hgt' => '~^(1([5-8]\d|9[0-4])cm|(59|6\d|7[0-6])in)$~',  // (Height)s
        'hcl' => '~^#[0-9a-f]{6}$~',  // (Hair Color)s
        'ecl' => '~^(amb|blu|brn|gry|grn|hzl|oth)$~',  // (Eye Color)s
        'pid' => '~^\d{9}$~',  // (Passport ID)s
        // 'cid',  // (Country ID)s
    ];

    public function runPart1(Input $data): string | int
    {
        $valid = 0;

        foreach ($data->getAsArray(separator: "\n\n") as $dataEntry) {
            $items = array_filter(preg_split('~\s~', $dataEntry));
            $values = [];
            foreach ($items as $item) {
                preg_match('~(\w+):(.+)~', $item, $m);
                $values[$m[1]] = $m[2];
            }

            if (empty(array_diff(array_keys(self::REQUIRED_FIELDS), array_keys($values)))) {
                $valid++;
            }
        }

        return $valid;
    }

    public function runPart2(Input $data): string | int
    {
        $valid = 0;

        foreach ($data->getAsArray(separator: "\n\n") as $dataEntry) {
            $items = array_filter(preg_split('~\s~', $dataEntry));
            $values = [];
            foreach ($items as $item) {
                preg_match('~(\w+):(.+)~', $item, $m);
                $values[$m[1]] = $m[2];
            }

            foreach (self::REQUIRED_FIELDS as $key => $regex) {
                if (!isset($values[$key])) {
                    continue 2;
                }

                if (!preg_match($regex, $values[$key])) {
                    continue 2;
                }
            }

            $valid++;
        }

        return $valid;
    }

    public function getExpectedTestResult1(): ?string
    {
        return '2';
    }

    public function getExpectedTestResult2(): ?string
    {
        return '2';
    }
}
