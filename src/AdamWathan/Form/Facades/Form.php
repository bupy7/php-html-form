<?php

namespace AdamWathan\Form\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @deprecated
 */
class Form extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'adamwathan.form';
    }
}
