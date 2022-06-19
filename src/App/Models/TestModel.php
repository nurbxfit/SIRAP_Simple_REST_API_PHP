<?php

namespace App\Models;
use Core\Model;

class TestModel extends Model {

    public string $username = 'test';
    public string $email = '';

    public array $rules = [
        "username" => ["required"=>true, "max"=>30,"min"=>10,"match"=>'testing'],
        "email" => ["required"=>true, "max"=>30,"min"=>10,"match"=>'testing', "unique"=>true],
    ];
} 