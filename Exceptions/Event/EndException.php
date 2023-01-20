<?php
class EndException extends Exception {
    protected $code = 606;
    protected $message = "Ending date is required for the event";

    #[ReturnTypeWillChange] public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}