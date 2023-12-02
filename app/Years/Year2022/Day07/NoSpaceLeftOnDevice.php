<?php declare(strict_types = 1);

namespace App\Years\Year2022\Day07;

use App\IDay;
use App\Utils\Input;

class NoSpaceLeftOnDevice implements IDay
{
    private const SMALLER_DIR_SIZE = 100_000;
    private const MAX_ALLOCATED_SPACE = 40_000_000;

    /** @var array<string> */
    private array $currentDir;

    private Directory $root;

    /** @var array<Directory> */
    private array $smallerDirs;

    private ?Directory $smallestDirToDelete;

    private int $minimumSpaceToFree;


    public function runPart1(Input $data): string | int
    {
        $this->init($data);

        $this->filterAndSaveSmallerDirs($this->root);

        $sizeOfSmallerDirs = 0;
        foreach ($this->smallerDirs as $smallerDir) {
            $sizeOfSmallerDirs += $smallerDir->getTotalSize();
        }

        return $sizeOfSmallerDirs;
    }


    public function runPart2(Input $data): string | int
    {
        $this->init($data);

        $this->minimumSpaceToFree = $this->root->getTotalSize() - self::MAX_ALLOCATED_SPACE;
        $this->saveSmallestDirToBeDeleted($this->root);

        return $this->smallestDirToDelete->getTotalSize();
    }


    public function getExpectedTestResult1(): ?string
    {
        return '95437';
    }


    public function getExpectedTestResult2(): ?string
    {
        return '24933642';
    }


    private function init(Input $data): void
    {
        $this->root = new Directory('/');
        $this->smallerDirs = [];
        $this->smallestDirToDelete = null;

        foreach ($data->getAsArray() as $line) {
            if (str_starts_with($line, '$ cd')) {
                $this->cd(substr($line, 5));
                continue;
            }

            if (str_starts_with($line, 'dir')) {
                $this->dir(substr($line, 4));
            }

            if (is_numeric($line[0])) {
                [$size, $name] = explode(' ', $line);
                $this->file((int) $size, $name);
            }
        }
    }


    private function cd(string $arg): void
    {
        if ($arg === '/') {
            $this->currentDir = [];

            return;
        }

        if ($arg === '..') {
            array_pop($this->currentDir);

            return;
        }

        $this->currentDir[] = $arg;
    }


    private function dir(string $directoryName): void
    {
        $this->getCurrentDirectory()->addDirectory(new Directory($directoryName));
    }


    private function file(int $size, string $name): void
    {
        $this->getCurrentDirectory()->addFile(new File($size, $name));
    }


    private function getCurrentDirectory(): Directory
    {
        $directory = $this->root;
        foreach ($this->currentDir as $subDir) {
            $directory = $directory->cd($subDir);
        }

        return $directory;
    }


    private function filterAndSaveSmallerDirs(Directory $directory): void
    {
        $dirSize = $directory->getTotalSize();

        foreach ($directory->getDirectories() as $subDir) {
            $this->filterAndSaveSmallerDirs($subDir);
        }

        if ($dirSize < self::SMALLER_DIR_SIZE) {
            $this->smallerDirs[] = $directory;
        }
    }


    private function saveSmallestDirToBeDeleted(Directory $directory): void
    {
        $dirSize = $directory->getTotalSize();

        if ($dirSize >= $this->minimumSpaceToFree
            && (
                $this->smallestDirToDelete === null
                || $dirSize < $this->smallestDirToDelete->getTotalSize()
            )
        ) {
            $this->smallestDirToDelete = $directory;
        }

        foreach ($directory->getDirectories() as $subDir) {
            $this->saveSmallestDirToBeDeleted($subDir);
        }
    }
}
