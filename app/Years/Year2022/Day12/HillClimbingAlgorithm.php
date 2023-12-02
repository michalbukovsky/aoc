<?php declare(strict_types = 1);

namespace App\Years\Year2022\Day12;

use App\IDay;
use App\Utils\Input;
use App\Utils\Outputter;
use App\Utils\Vector2Int;

class HillClimbingAlgorithm implements IDay
{
    /**
     * @throws NoRouteException
     */
    public function runPart1(Input $data): string | int
    {
        $start = null;
        $end = null;
        $tiles = [];

        foreach ($data->getAsArrayOfArraysOfChars() as $row => $line) {
            foreach ($line as $col => $char) {
                if ($char === 'S') {
                    $start = new Vector2Int($col, $row);
                    $char = 'a';
                } elseif ($char === 'E') {
                    $end = new Vector2Int($col, $row);
                    $char = 'z';
                }
                $tiles[$row][$col] = ord($char) - 96;
            }
        }

        return $this->getShortestDistance($start, $end, $tiles);
    }


    public function runPart2(Input $data): string | int
    {
        $starts = [];
        $end = null;
        $tiles = [];

        foreach ($data->getAsArrayOfArraysOfChars() as $row => $line) {
            foreach ($line as $col => $char) {
                if ($char === 'S') {
                    $char = 'a';
                } elseif ($char === 'E') {
                    $end = new Vector2Int($col, $row);
                    $char = 'z';
                }

                if ($char === 'a') {
                    $starts[] = new Vector2Int($col, $row);
                }

                $tiles[$row][$col] = ord($char) - 96;
            }
        }

        $minDistance = 99999;
        foreach ($starts as $i => $start) {
            try {
                $distance = $this->getShortestDistance($start, $end, $tiles);
            } catch (NoRouteException) {
                Outputter::error("#$i No route, skip");
                continue;
            }
            Outputter::notice("#$i Distance: $distance");
            $minDistance = min($minDistance, $distance);
        }

        return $minDistance;
    }


    public function getExpectedTestResult1(): ?string
    {
        return '31';
    }


    public function getExpectedTestResult2(): ?string
    {
        return '29';
    }


    /**
     * @throws NoRouteException
     */
    private function getShortestDistance(Vector2Int $start, Vector2Int $end, array $tiles): int
    {
        /** @var Node[][] $nodes */
        $nodes = [];

        $nodes[$start->getY()][$start->getX()] = new Node(1, $start, 0, $end);

        while (true) {
            $activeNode = $this->getNextBestNode($nodes);
            if ($activeNode === null) {
                throw new NoRouteException();
            }

            $nodePos = $activeNode->getPos();

            if ($nodePos->equals($end)) {
                break;
            }

            foreach ($activeNode->getPos()->getNeighboursCoords() as $col => $row) {
                $goToHeight = $tiles[$row][$col] ?? null;
                if ($goToHeight === null || $goToHeight > $activeNode->getHeight() + 1) {
                    continue;
                }

                $currentGoToNode = $nodes[$row][$col] ?? null;
                $newGoToNode = new Node(
                    $goToHeight,
                    new Vector2Int($col, $row),
                    $activeNode->getDistanceFromStart() + 1,
                    $end
                );

                if ($currentGoToNode === null || $currentGoToNode->getCost() > $newGoToNode->getCost()) {
                    $nodes[$row][$col] = $newGoToNode;
                }
            }

            $activeNode->disable();
        }

        return $activeNode->getDistanceFromStart();
    }


    /**
     * @param Node[][] $nodes
     */
    private function getNextBestNode(array $nodes): ?Node
    {
        $bestNode = null;
        foreach ($nodes as $row) {
            foreach ($row as $node) {
                if ($node->isDisabled()) {
                    continue;
                }

                if ($bestNode === null || ($node->getCost() < $bestNode->getCost())) {
                    $bestNode = $node;
                }
            }
        }

        return $bestNode;
    }
}

