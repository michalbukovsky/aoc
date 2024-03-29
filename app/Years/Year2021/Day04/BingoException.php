<?php declare(strict_types = 1);

namespace App\Years\Year2021\Day04;

use Exception;

final class BingoException extends Exception
{
    private int $sumUndrawn;


    public function __construct(int $sumUndrawn)
    {
        parent::__construct();
        $this->sumUndrawn = $sumUndrawn;
    }


    public function getSumUndrawn(): int
    {
        return $this->sumUndrawn;
    }
}
