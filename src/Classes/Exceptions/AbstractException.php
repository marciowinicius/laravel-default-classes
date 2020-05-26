<?php
namespace MarcioWinicius\LaravelDefaultClasses\Exceptions;

use Illuminate\Support\MessageBag;
use Prettus\Validator\Exceptions\ValidatorException;

class AbstractException extends ValidatorException
{
    public function __construct(array $message)
    {
        parent::__construct(new MessageBag($message));
    }
}

