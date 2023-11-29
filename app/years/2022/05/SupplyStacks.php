<?php declare(strict_types = 1);

namespace App;

use App\Utils\Input;

class SupplyStacks implements IDay
{
    /**
     * @var array<int, array<string>>
     */
    private array $columns;


    public function runPart1(Input $data): string
    {
        return $this->runPart($data, false);
    }


    public function runPart2(Input $data): string
    {
        return $this->runPart($data, true);
    }


    private function runPart(Input $data, bool $moveAsGroup): string
    {
        $this->columns = [];

        foreach ($data->getAsArray() as $line) {
            if (str_starts_with($line, 'move')) {
                preg_match('~move (\d+) from (\d+) to (\d+)~', $line, $m);
                [, $count, $from, $to] = $m;
                $this->move((int) $count, (int) $from, (int) $to, $moveAsGroup);

                continue;
            }

            if (str_starts_with($line, '[') || str_starts_with($line, '  ')) {
                $this->feedContainers($line);
            }
        }

        $output = '';
        ksort($this->columns);
        foreach ($this->columns as $column) {
            $output .= end($column);
        }

        return $output;
    }


    public function getExpectedTestResult1(): ?string
    {
        return 'CMZ';
    }


    public function getExpectedTestResult2(): ?string
    {
        return 'MCD';
    }


    private function feedContainers(string $line): void
    {
        $i = 0;
        while (true) {
            $charPosition = 1 + $i++ * 4;

            if ($charPosition > strlen($line)) {
                break;
            }

            $container = $line[$charPosition];
            if ($container === ' ') {
                continue;
            }

            if (isset($this->columns[$i])) {
                array_unshift($this->columns[$i], $container);
            } else {
                $this->columns[$i] = [$container];
            }
        }
    }


    private function move(int $count, int $from, int $to, bool $moveAsGroup): void
    {
        if ($moveAsGroup === true) {
            $containersSlice = array_splice($this->columns[$from], -$count, $count);
            $this->columns[$to] = [...$this->columns[$to], ...$containersSlice];

            return;
        }

        for ($step = 0; $step < $count; $step++) {
            $container = array_pop($this->columns[$from]);
            $this->columns[$to][] = $container;
        }
    }
}
