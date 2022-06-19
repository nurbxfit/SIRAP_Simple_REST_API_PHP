<?php

namespace Core;
use Core\Response;

class ErrorHandler{
    public static function handleException(\Throwable $exception):void {
        Response::json([
            "code"=> $exception->getCode(),
            "message" => $exception->getMessage(),
            "errors" => is_callable([$exception,'getErrors']) ? $exception->getErrors() : [],
            // "file" => $exception->getFile(), //remove this on prod
            // "line" => $exception->getLine(), //remove this on prod
        ]);
    }
}