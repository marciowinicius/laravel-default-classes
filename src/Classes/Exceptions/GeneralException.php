<?php

namespace MarcioWinicius\LaravelDefaultClasses\Exceptions;

class GeneralException extends AbstractException
{
    public function __construct($msg)
    {
        parent::__construct(['error' => $msg]);
    }
}
