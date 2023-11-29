<?php declare(strict_types = 1);

namespace App\Years\Year2022\Day13;

use Exception;

final class UnorderedException extends Exception
{
    public function __construct()
    {
        parent::__construct();
    }
}
