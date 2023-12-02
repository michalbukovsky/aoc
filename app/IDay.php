<?php declare(strict_types = 1);

namespace App;

use App\Utils\Input;

interface IDay
{
    public function runPart1(Input $data): string | int;


    public function runPart2(Input $data): string | int;


    public function getExpectedTestResult1(): ?string;


    public function getExpectedTestResult2(): ?string;
}
