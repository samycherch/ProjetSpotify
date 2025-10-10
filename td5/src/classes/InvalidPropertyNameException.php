<?php

namespace iutnc\deefy\exception;

class InvalidPropertyNameException extends \Exception {
    public function __construct($property, $code = 0, \Throwable $previous = null) {
        parent::__construct("Invalid property name: $property", $code, $previous);
    }
}
