<?php
namespace Core\Exceptions;

class ModelValidationException extends \Exception {
    protected $code = 400;
    protected $message = "Validation Error!";

    public function __construct(protected array $errors = []){}

    public function getErrors(){
        return $this->errors;
    }
}