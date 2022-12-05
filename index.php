<?php declare(strict_types = 1);

error_reporting(E_ALL);

use App\IDay;
use App\Runner;
use App\Utils\Outputter;
use Nette\Loaders\RobotLoader;
use Tracy\Debugger;

require_once __DIR__ . '/vendor/autoload.php';

$loader = new RobotLoader;

$loader->addDirectory(__DIR__ . '/app');
Debugger::enable(null, __DIR__ . '/log');
Debugger::$strictMode = true;

$loader->setTempDirectory(__DIR__ . '/temp');
$loader->register();

$dayNumber = ($argv[1] ?? null);
$part = isset($argv[2]) ? (int) $argv[2] : null;

if ($dayNumber === null) {
    Outputter::errorFatal('No day specified');
}
if (!preg_match('~^\d{1,2}$~', $dayNumber)) {
    Outputter::errorFatal("Value '$dayNumber' is invalid for a day number.");
}

$folderName = __DIR__ . '/app/days/' . str_pad($dayNumber, 2, '0', STR_PAD_LEFT);
if (!file_exists($folderName)) {
    Outputter::errorFatal("Day '$dayNumber' not yet implemented");
}

$filesInFolder = scandir($folderName);

foreach ($filesInFolder as $filename) {
    if (!str_ends_with($filename, '.php')) {
        continue;
    }

    $dayClassName = '\\App\\' . substr($filename, 0, -4);

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
