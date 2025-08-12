<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class MCP extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mcp'; // matches the key we will bind in the service container
    }
}
