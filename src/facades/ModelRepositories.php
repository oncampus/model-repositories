<?php

namespace Oncampus\ModelRepositories\Facades;
use Illuminate\Support\Facades\Facade;

class ModelRepositories extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'ModelRepositories'; }
}
