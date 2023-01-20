<?php

class PathIcalException extends Exception
{
    protected $message = 'Path to ical storage folder is required';
    protected $code = 600;

    #[ReturnTypeWillChange] public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}