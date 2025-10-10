<?php

namespace iutnc\deefy\exceptions;

class InvalidPropertyValueException extends \Exception {
    public function __construct($property, $value, $code = 0, Throwable $previous = null) {
        parent::__construct("Invalid value for property '$property' : $value", $code, $previous);
    }
}
