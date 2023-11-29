<?php declare(strict_types = 1);

namespace App;

final class File
{
    public function __construct(
        private readonly int $size,
        private readonly string $name,
    ) {
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function getSize(): int
    {
        return $this->size;
    }
}
