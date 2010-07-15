<?php

class SandboxException extends Exception {
    const ERR_FORBIDDEN_SYSCALL = 1;
    const ERR_RUNTIME_ERROR = 2;
    const ERR_TIMELIMIT_EXCEEDED = 3;
    const ERR_MEMORYLIMIT_EXCEEDED = 4;
    const ERR_FORBIDDEN_ACCESS = 5;

    public $status;

    public function  __construct($status , $pMessage = "") {
        $this->status = $status;
        $message = "";
        switch ($status)
        {
            case self::ERR_FORBIDDEN_SYSCALL:
                $message = "Forbidden Syscall";
                break;
            case self::ERR_RUNTIME_ERROR :
                $message = "Run time error";
                break;
            case self::ERR_TIMELIMIT_EXCEEDED :
                $message = "Time limit exceeded";
                break;
            case self::ERR_MEMORYLIMIT_EXCEEDED :
                $message = "Memory limit exceeded";
                break;
            case self::ERR_FORBIDDEN_ACCESS :
                $message = "Access forbidden";
                break;
			default:
				$message = $pMessage;
				break;
        }
        
        if ($pMessage != "")
            $message = $pMessage;
        parent::__construct($message, $status);
    }
}