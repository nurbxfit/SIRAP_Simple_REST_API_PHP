<?php
namespace Core\exceptions;

class ForbiddenException extends \Exception{
    protected $code = 403;
    protected $message = "You don't have permission to view this page";
    
    public function __construct($message=null){
        if($message !== null){
            $this->message = $message;
        }
    }
}
?>
