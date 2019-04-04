<?php

namespace App\Console\Commands\Mixins;

use App\Models\User;

trait UserValidationInTheCommand
{
    /**
     * @return User
     */
    protected function prepareUserFromConsole(): User
    {
        if (!$user = User::find($this->option('user'))) {
            exit($this->error(trans('command.order.user_not_found')));
        }

        return $user;
    }
}
