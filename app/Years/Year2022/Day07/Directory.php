<?php declare(strict_types = 1);

namespace App\Years\Year2022\Day07;

final class Directory
{
    /** @param array<File> $files */
    private array $files = [];

    /** @param array<Directory> $directories */
    private array $directories = [];


    public function __construct(
        private readonly string $name,
    ) {
    }


    public function getName(): string
    {
        return $this->name;
    }


    /** @return array<Directory> */
    public function getDirectories(): array
    {
        return $this->directories;
    }


    public function cd(string $arg)
    {
        return $this->directories[$arg];
    }


    public function addFile(File $file): void
    {
        $this->files[$file->getName()] = $file;
    }


    public function addDirectory(Directory $directory): void
    {
        $this->directories[$directory->getName()] = $directory;
    }


    public function getTotalSize(): int
    {
        $size = 0;

        /** @var File $file */
        foreach ($this->files as $file) {
            $size += $file->getSize();
        }

        foreach ($this->directories as $directory) {
            $size += $directory->getTotalSize();
        }

        return $size;
    }
}
