<?php
namespace Core\exceptions;

class NotFoundException extends \Exception{
    protected $code = 404;
    protected $message = "Page not found!";
    
    public function __construct($message=null){
        if($message !== null){
            $this->message = $message;
        }
    }
}
?>
