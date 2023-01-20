<?php
class VersionException extends Exception{
    protected $code = 602;
    protected $message = "Version is required for the ical generation";

    #[ReturnTypeWillChange] public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}