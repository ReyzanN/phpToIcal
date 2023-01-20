<?php

class BeginException extends \Exception
{
    protected $code = 605;
    protected $message = "Beginning date is required for the event";

     #[ReturnTypeWillChange] public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}