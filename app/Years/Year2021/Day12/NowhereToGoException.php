<?php declare(strict_types = 1);

namespace App\Years\Year2021\Day12;

use Exception;

final class NowhereToGoException extends Exception
{
    public function __construct()
    {
        parent::__construct();
    }
}
