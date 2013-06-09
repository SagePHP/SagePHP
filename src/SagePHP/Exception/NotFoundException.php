<?php

namespace SagePHP\Exception;

class NotFoundException extends Exception
{
    public function __construct($message = null, $code = 404, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
