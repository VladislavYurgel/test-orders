<?php

namespace App\Exceptions;

use Exception;

class OrderIsNotExistsException extends Exception
{
    /**
     * OrderIsNotExists constructor.
     * @param string $message
     */
    public function __construct(string $message = "")
    {
        $message = empty($message) ? static::getDefaultMessage() : $message;

        parent::__construct($message);
    }

    /**
     * @return string
     */
    public static function getDefaultMessage(): string
    {
        return trans('order.error.is_not_exists');
    }
}
