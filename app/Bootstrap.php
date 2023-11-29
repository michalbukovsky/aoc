<?php

declare(strict_types=1);

namespace App;

use App\Utils\Outputter;
use Throwable;

class Bootstrap
{
    /**
     * @param string[] $args
     */
    public function run(array $args): void
    {
        $dayNumber = ($args[1] ?? null);
        $part = isset($args[2]) ? (int) $args[2] : null;
        $year = $args[3] ?? date('Y');

        if ($dayNumber === null) {
            Outputter::errorFatal('No day specified');
        }
        if (!preg_match('~^\d{1,2}$~', $dayNumber)) {
            Outputter::errorFatal("Value '$dayNumber' is invalid for a day number.");
        }
        if (!preg_match('~^\d{4}$~', $year)) {
            Outputter::errorFatal("Value '$year' is invalid for a year.");
        }

        if (!file_exists(__DIR__ . "/Years/Year$year")) {
            Outputter::errorFatal("Year '$year' not yet implemented");
        }

        $dayNumberPadded = str_pad($dayNumber, 2, '0', STR_PAD_LEFT);
        $folderName = __DIR__ . "/Years/Year$year/Day" . $dayNumberPadded;
        if (!file_exists($folderName)) {
            Outputter::errorFatal("Day '$dayNumber' not yet implemented");
        }

        $filesInFolder = scandir($folderName);

        foreach ($filesInFolder as $filename) {
            if (!str_ends_with($filename, '.php')) {
                continue;
            }

            $dayClassName = "\\App\\Years\\Year$year\\Day$dayNumberPadded\\" . substr($filename, 0, -4);

            if (!is_a($dayClassName, IDay::class, true)) {
                continue;
            }

            $day = new $dayClassName();

            Outputter::notice('Result:');
            Outputter::newline();

            $runner = new Runner();
            try {
                if ($part === null) {
                    $runner->run($day, 1);
                    $runner->run($day, 2);
                } else {
                    $runner->run($day, $part);
                }
            } catch (Throwable $e) {
                Outputter::error('Fatal error (' . get_class($e) . '):');
                Outputter::errorFatal($e->getMessage());
            }
            die;
        }

        Outputter::errorFatal("No Runner class found for day '$dayNumber'");
    }
}
