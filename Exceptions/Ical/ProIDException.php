<?php

class ProIDException extends Exception
{
    protected $code = 601;
    protected $message = 'ProID is required for the ical generation';

    #[ReturnTypeWillChange] public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}