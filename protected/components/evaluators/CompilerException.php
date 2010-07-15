<?php

class CompilerException extends Exception {
    const ERR_LANGUAGE_UNRECOGNIZED = 1;
    const ERR_COMPILE_ERROR = 2;

    public $status;

    public function  __construct($status) {
        $this->status = $status;
        $message = "";
        switch ($status){
            case self::ERR_LANGUAGE_UNRECOGNIZED :
                $message = "Language unrecognized";
                break;
            case self::ERR_COMPILE_ERROR :
                $message = "Compile error";
                break;
        }
        parent::__construct($message, $status);
    }
}