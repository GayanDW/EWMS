<?php

namespace App\Controllers;

class User extends BaseController
{
    public function index(): string
    {
        return "user";
    }
    
    public function search() {
        echo "Search User";
    }
    public function calAge() {
        $x=15;
        $y=10;
        
        echo $x+$y;
        
    }

}
