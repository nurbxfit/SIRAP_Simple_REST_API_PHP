<?php

namespace Core;

class Request{
    /**
     * Return request method eg: POST,GET, OPTIONS etc...
     */
    public function method() : string {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Return request path eg: /something/eomthing
     */
    public function path() : string{
        return parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
    }

    /**
     * Return request path in array parts
     */
    public function path_parts() : string{
        return explode("/",parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH));
    }


    /**
     * Return request querystring as string eg "/api/hello?say=world" will yield "say=world"
     */
    public function queryString() : string{
        return explode("/",parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY ))[0];
    }

    /**
     * Return query string as key pair object eg: array(1) { ["say"]=> string(5) "world" }
     */
    public function query() : array{
        $query = [];
        parse_str($this->queryString(),$query);
        return $query;
    }

    /**
     * Return request body,
     */
    public function body() : array {
        $data = [];
        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                $data[$key] = trim(filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS));
            }
        }
        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                $data[$key] = trim(filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS));
            }
        }
        return $data;
    }

    /**
     * Checking for request method
     */
    public function isGet() : bool {
        return $this->method() === 'get';
    }

    public function isPost() : bool {
        return $this->method() === 'post';
    }

    public function isPut() : bool {
        return $this->method() === 'put';
    }

    public function isPatch() : bool {
        return $this->method() === 'patch';
    }

    public function isDelete() : bool {
        return $this->method() === 'delete';
    }

    public function isOptions() : bool {
        return $this->method() === 'options';
    }
}