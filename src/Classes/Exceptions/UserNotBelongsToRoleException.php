<?php

namespace MarcioWinicius\LaravelDefaultClasses\Exceptions;

class UserNotBelongsToRoleException extends AbstractException
{
    public function __construct($message)
    {
        parent::__construct(['error' => $message]);
    }
}
