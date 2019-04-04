<?php

namespace App\Exceptions;

use Exception;

class AddGoodToTheOrderException extends Exception
{
    /**
     * AddGoodToTheOrderException constructor.
     * @param string $message
     */
    public function __construct(string $message = "")
    {
        $message = empty($message) ? $this->getDefaultMessage() : $message;

        parent::__construct($message);
    }

    /**
     * @return string
     */
    protected function getDefaultMessage(): string
    {
        return trans('order.error.add_good');
    }
}
