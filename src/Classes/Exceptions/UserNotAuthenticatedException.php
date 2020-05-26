<?php

namespace MarcioWinicius\LaravelDefaultClasses\Exceptions;

class UserNotAuthenticatedException extends AbstractException
{
    public function __construct()
    {
        parent::__construct(['error' => 'User not authenticated.']);
    }
}
