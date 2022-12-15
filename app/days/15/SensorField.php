<?php declare(strict_types = 1);

namespace App;

use App\Utils\Vector2Int;

final class SensorField
{
    private int $manhattan;


    public function __construct(
        private readonly Vector2Int $sensor,
        private readonly Vector2Int $beacon,
    ) {
        $this->manhattan = $this->sensor->getDistanceManhattan($this->beacon);
    }


    public function getManhattan(): int
    {
        return $this->manhattan;
    }


    public function getSensor(): Vector2Int
    {
        return $this->sensor;
    }
}
