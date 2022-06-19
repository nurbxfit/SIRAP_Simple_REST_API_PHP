<?php
namespace Core\exceptions;

class BadRequestException extends \Exception {
    protected $code = 400;
    protected $message = "Bad Request";

    public function __construct($message=null){
        if($message !== null){
            $this->message = $message;
        }
    }
}