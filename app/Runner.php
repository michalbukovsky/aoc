<?php

declare(strict_types=1);

namespace App;

use App\Utils\Input;
use App\Utils\Outputter;
use ReflectionClass;

class Runner
{
    private const TEST_DATA_FILE_1 = 'test1.txt';
    private const TEST_DATA_FILE_2 = 'test2.txt';
    private const TEST_DATA_FILE_DEFAULT = 'test.txt';
    private const DATA_FILE = 'data.txt';

    public function run(IDay $day, ?int $part): void
    {
        $this->validateDayFolder($day, $part);

        if (!in_array($part, [1, 2], true)) {
            Outputter::errorFatal("Invalid part '$part'.");
        }

        $this->validateTestResult($day, $part);

        if ($part === 1) {
            $result = $day->runPart1($this->getInput($day, self::DATA_FILE));
        } else {
            $result = $day->runPart2($this->getInput($day, self::DATA_FILE));
        }

        Outputter::success("Result:");
        Outputter::success($result);
        Outputter::newline();
        Outputter::newline();
    }

    private function validateDayFolder(IDay $day, int $part): void
    {
        $folder = $this->getFolderOfDay($day);

        if ($part === 1 && !file_exists("$folder/" . self::TEST_DATA_FILE_1)
            && !file_exists("$folder/" . self::TEST_DATA_FILE_DEFAULT)
        ) {
            Outputter::errorFatal('Test data file 1 is missing!');
        }

        if ($part === 2 && !file_exists("$folder/" . self::TEST_DATA_FILE_2)
            && !file_exists("$folder/" . self::TEST_DATA_FILE_DEFAULT)
        ) {
            Outputter::errorFatal('Test data file 2 is missing!');
        }

        if (!file_exists("$folder/" . self::DATA_FILE)) {
            Outputter::errorFatal('Data file is missing!');
        }
    }

    private function validateTestResult(IDay $day, int $part): void
    {
        if ($part === 1) {
            $expected = $day->getExpectedTestResult1();
            $real = $day->runPart1($this->getInput($day, self::TEST_DATA_FILE_1));
        } else {
            $expected = $day->getExpectedTestResult2();
            $real = $day->runPart2($this->getInput($day, self::TEST_DATA_FILE_2));
        }

        if ($expected === null) {
            Outputter::notice("Expected value for part $part not set. Skipping test.");

            return;
        }

        if ($expected !== (string) $real) {
            Outputter::error("Test did not pass for part $part:");
            Outputter::error("Expected: '$expected'");
            Outputter::errorFatal("Returned: '$real'");
        }

        Outputter::success("The test for part $part succeeded with result '$real'.");
    }

    private function getFolderOfDay(IDay $day): string
    {
        $reflection = new ReflectionClass($day);

        return dirname($reflection->getFileName());
    }

    private function getInput(IDay $day, string $fileName): Input
    {
        $folder = $this->getFolderOfDay($day);

        if (!file_exists("$folder/$fileName")) {
            $fileName = self::TEST_DATA_FILE_DEFAULT;
        }

        return new Input(file_get_contents("$folder/$fileName"));
    }
}
