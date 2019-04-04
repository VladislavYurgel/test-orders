<?php

namespace App\Helpers\Lists\Base\Contracts;

interface Listable
{
    /**
     * @return array
     */
    public static function getList(): array;
}
