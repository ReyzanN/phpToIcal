<?php
class MethodException extends Exception {
    protected $code = 603;
    protected $message = 'Method is required for the ical generation';

    #[ReturnTypeWillChange] public function __toString() {
    return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}