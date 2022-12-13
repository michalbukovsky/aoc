<?php declare(strict_types = 1);

namespace App\Utils;

abstract class Tools
{
    /**
     * @return int[]
     */
    public static function strposAll(string $haystack, string $needle): array
    {
        $positions = [];
        $offset = 0;
        while (true) {
            $position = strpos($haystack, $needle, $offset);
            if ($position === false) {
                return $positions;
            }

            $positions[] = $position;
            $offset = $position + 1;
        }
    }


    /**
     * @param int[] $array
     */
    public static function intifyArray(array $array): array
    {
        return array_map(
            static fn(string $line): int => (int) $line,
            $array
        );
    }


    /**
     * @param float[] $array
     */
    public static function floatifyArray(array $array): array
    {
        return array_map(
            static fn(string $line): float => (float) $line,
            $array
        );
    }


    public static function arraySum2D(array $array): int
    {
        $sum = 0;
        foreach ($array as $subArray) {
            $sum += array_sum($subArray);
        }

        return $sum;
    }


    public static function arrayMax2D(array $array, bool $fromKeys): int
    {
        $max = 0;
        foreach ($array as $line) {
            $max = max($max, ...($fromKeys ? array_keys($line) : $line));
        }

        return $max;
    }
}