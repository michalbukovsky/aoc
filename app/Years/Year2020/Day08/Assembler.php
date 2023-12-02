<?php

declare(strict_types=1);

namespace App\Years\Year2020\Day08;

use App\IDay;
use App\InvalidStateException;
use App\Utils\Input;

class Assembler implements IDay
{
    protected const ACC = 'acc';
    protected const JMP = 'jmp';
    protected const NOP = 'nop';

    public function runPart1(Input $data): string | int
    {
        try {
            return $this->runProgram($this->getCommands($data));
        } catch (InvalidStateException $e) {
            return $e->getMessage();
        }
    }

    public function runPart2(Input $data): string | int
    {
        $commandsInitial = $this->getCommands($data);

        foreach ($commandsInitial as $pointer => $command) {
            $commands = $commandsInitial;
            if ($command[0] === self::JMP) {
                $commands[$pointer][0] = self::NOP;
            } elseif ($command[0] === self::NOP) {
                $commands[$pointer][0] = self::JMP;
            } else {
                continue;
            }

            try {
                return $this->runProgram($commands);
            } catch (InvalidStateException) {
                continue;
            }
        }

        return 'nothing found.';
    }

    /**
     * @param array $commands
     *
     * @return int
     * @throws InvalidStateException
     */
    protected function runProgram(array $commands): int
    {
        $commandsUsed = [];
        $pointer = 0;
        $accumulator = 0;
        do {
            if ($commandsUsed[$pointer] === true) {
                throw new InvalidStateException((string) $accumulator);
            }
            $commandsUsed[$pointer] = true;

            [$command, $argument] = $commands[$pointer];
            if ($command === self::JMP) {
                $pointer += $argument;
                continue;
            }

            if ($command === self::ACC) {
                $accumulator += $argument;
            }

            $pointer++;
        } while (isset($commands[$pointer]));

        return $accumulator;
    }

    public function getExpectedTestResult1(): ?string
    {
        return '5';
    }

    public function getExpectedTestResult2(): ?string
    {
        return '8';
    }

    protected function getCommands(Input $data): array
    {
        $commands = [];

        foreach ($data->getAsArray() as $line) {
            preg_match('~^(nop|acc|jmp) \+?(-?\d+)$~', $line, $m);
            $commands[] = [$m[1], (int) $m[2]];
        }

        return $commands;
    }
}
