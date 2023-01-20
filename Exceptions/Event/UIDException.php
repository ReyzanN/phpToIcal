<?php
class UIDException extends Exception{
    protected $code = 608;
    protected $message = "UID is required for the event";

    #[ReturnTypeWillChange] public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}