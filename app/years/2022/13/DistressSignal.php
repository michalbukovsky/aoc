<?php declare(strict_types = 1);

namespace App;

use App\Utils\Input;
use JsonException;
use LogicException;

class DistressSignal implements IDay
{
    private const DIVIDER_1 = [[2]];
    private const DIVIDER_2 = [[6]];


    /**
     * @throws JsonException
     */
    public function runPart1(Input $data): string
    {
        $correctIndices = [];

        foreach ($data->getAsArrayOfArrays(false, "\n\n", "\n") as $index => $group) {
            $left = json_decode($group[0], flags: JSON_THROW_ON_ERROR);
            $right = json_decode($group[1], flags: JSON_THROW_ON_ERROR);

            try {
                $this->compare($left, $right);
            } catch (UnorderedException) {
                continue;
            } catch (OrderedException) {
                $correctIndices[] = $index + 1;
                continue;
            }

            throw new LogicException('Unexpected result');
        }

        return (string) array_sum($correctIndices);
    }


    /**
     * @throws JsonException
     */
    public function runPart2(Input $data): string
    {
        $divider1Index = 0;
        $divider2Index = 0;

        $packets = [self::DIVIDER_1, self::DIVIDER_2];

        foreach ($data->getAsArray() as $line) {
            $packets[] = json_decode($line, flags: JSON_THROW_ON_ERROR);
        }

        usort($packets, function ($left, $right) {
            try {
                $this->compare($left, $right);
            } catch (OrderedException) {
                return -1;
            } catch (UnorderedException) {
                return 1;
            }

            return 0;
        });

        foreach ($packets as $index => $packet) {
            if ($packet === self::DIVIDER_1) {
                $divider1Index = $index + 1;
            }
            if ($packet === self::DIVIDER_2) {
                $divider2Index = $index + 1;
            }
        }

        return (string) ($divider1Index * $divider2Index);
    }


    public function getExpectedTestResult1(): ?string
    {
        return '13';
    }


    public function getExpectedTestResult2(): ?string
    {
        return '140';
    }


    /**
     * @throws UnorderedException
     * @throws OrderedException
     */
    private function compare(array | int $left, array | int $right): void
    {
        if (is_array($left) && is_int($right)) {
            $right = [$right];
        }

        if (is_int($left) && is_array($right)) {
            $left = [$left];
        }

        if (is_int($left) && is_int($right)) {
            if ($left < $right) {
                throw new OrderedException();
            }
            if ($left > $right) {
                throw new UnorderedException();
            }

            return;
        }

        $i = 0;
        while (isset($left[$i]) || isset($right[$i])) {
            if (!isset($right[$i])) {
                throw new UnorderedException();
            }
            if (!isset($left[$i])) {
                throw new OrderedException();
            }

            $this->compare($left[$i], $right[$i]);
            ++$i;
        }
    }
}
