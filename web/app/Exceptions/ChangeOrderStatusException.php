<?php

namespace App\Exceptions;

use Exception;

class ChangeOrderStatusException extends Exception
{
    public function __construct(string $message = "")
    {
        $message = empty($message) ? self::getDefaultMessage() : $message;

        parent::__construct($message);
    }

    /**
     * @return string
     */
    public static function getDefaultMessage(): string
    {
        return trans('order.error.specified_status_is_not_available');
    }
}
