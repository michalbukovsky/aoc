<?php declare(strict_types = 1);

namespace App;

use Exception;

final class NoRouteException extends Exception
{
    public function __construct()
    {
        parent::__construct('No route');
    }
}
