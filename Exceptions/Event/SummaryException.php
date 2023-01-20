<?php
class SummaryException extends Exception{
    protected $code = 607;
    protected $message = "Summary of the event is required";

    #[ReturnTypeWillChange] public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}