<?php

namespace App\Exceptions;

class SapiException extends \Exception
{
    public string $type;

    public function __construct($message, $type = 'generic')
    {
        parent::__construct($message);
        $this->type = $type;
    }
}
