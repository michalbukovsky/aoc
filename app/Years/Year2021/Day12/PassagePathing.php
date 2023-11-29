<?php declare(strict_types = 1);

namespace App\Years\Year2021\Day12;

use App\IDay;
use App\Utils\Input;

class PassagePathing implements IDay
{
    private const TRIES = 1500000;

    public function runPart1(Input $data): string
    {
        return $this->runSimulation($data, 1);
    }


    public function runPart2(Input $data): string
    {
        return $this->runSimulation($data, 2);
    }


    private function runSimulation(Input $data, int $maxVisitsPerSmallCave): string
    {
        /** @var Node[] $nodes */
        $nodes = [];
        $duplicateRoutes = 0;

        foreach ($data->getAsArrayOfArrays(true, "\n", '-') as $line) {
            $nodeName = $line[0];
            $node1 = $nodes[$nodeName] ?? new Node($nodeName);
            $nodes[$nodeName] = $node1;

            $nodeName = $line[1];
            $node2 = $nodes[$nodeName] ?? new Node($nodeName);
            $nodes[$nodeName] = $node2;

            $node1->addNode($node2);
            $node2->addNode($node1);
        }

        $paths = [];
        while (true) {
            $this->resetNodes($nodes);
            $currentMaxVisitsPerSmallCave = $maxVisitsPerSmallCave;
            $node = $nodes[Node::START];
            $path = $node->getName();

            while (true) {
                try {
                    $node = $node->getNextNodeRandom($currentMaxVisitsPerSmallCave);
                } catch (NowhereToGoException) {
                    break;
                }

                $path .= '-' . $node->getName();
                if ($node->isEnd()) {
                    if (isset($paths[$path])) {
                        $duplicateRoutes++;

                        if ($duplicateRoutes > self::TRIES) {
                            break 2;
                        }
                        break;
                    }

                    $paths[$path] = true;
                    break;
                }

                try {
                    $node->markVisited();
                } catch (VisitedTwiceException) {
                    $currentMaxVisitsPerSmallCave = 1;
                }
            }
        }

        return (string)count($paths);
    }


    /**
     * @param Node[] $nodes
     */
    private function resetNodes(array $nodes): void
    {
        foreach ($nodes as $node) {
            $node->reset();
        }
    }


    public function getExpectedTestResult1(): ?string
    {
        return '10';
    }


    public function getExpectedTestResult2(): ?string
    {
        return '36';
    }
}
