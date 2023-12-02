<?php

declare(strict_types=1);

namespace App\Utils;

abstract class Outputter
{
    private const RED = "\033[91m";
    private const GREEN = "\033[92m";
    private const YELLOW = "\033[93m";
    private const END = "\033[0m";

    public static function errorFatal(string | int $message): void
    {
        self::error($message);
        die;
    }

    public static function error(string | int $message): void
    {
        self::echoMessage($message, self::RED);
    }

    public static function success(string | int $message): void
    {
        self::echoMessage($message, self::GREEN);
    }

    public static function notice(string | int $message, bool $newline = true): void
    {
        self::echoMessage($message, self::YELLOW, $newline);
    }

    public static function newline(): void
    {
        echo "\n";
    }

    public static function dump2DArray(array $array, int $startX, int $startY, int $size): void
    {
        for ($y = $startY; $y < $startY + $size; $y++) {
            for ($x = $startX; $x < $startX + $size; $x++) {
                $cell = $array[$y][$x] ?? '.';
                if (is_bool($cell)) {
                    echo $cell ? '█' : '.';
                    continue;
                }
                echo $cell;
            }
            self::newline();
        }
        self::newline();
    }

    /**
     * @param callable $callback fn($cellContent): string
     */
    public static function dump2DArrayCallback(array $array, int $start, int $size, callable $callback): void
    {
        for ($i = $start; $i < $size; $i++) {
            for ($j = $start; $j < $size; $j++) {
                echo $callback($array[$i][$j] ?? null);
            }
            self::newline();
        }
        self::newline();
    }

    private static function echoMessage(string | int $message, string $color, bool $newline = true): void
    {
        echo $color . $message . ($newline ? "\n" : '') . self::END;
    }
}
