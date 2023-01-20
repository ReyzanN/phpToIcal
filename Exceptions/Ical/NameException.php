<?php

class NameException extends Exception
{
    protected $code = 604;
    protected $message = 'Name is required for the ical generation';

    #[ReturnTypeWillChange] public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}