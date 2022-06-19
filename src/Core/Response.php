<?php

namespace Core;

class Response {
    public static function statusCode(int $code):void{
        http_response_code($code);
    }

    public static function redirect(string $url):void{
        header("Location: $url");
    }

    public static function refresh(int $delay=0):void{
        header("Refresh:$delay");
    }

    public static function json($data) {
        header("Content-type: application/json; charset=UTF-8");
        echo json_encode($data);
    }
}