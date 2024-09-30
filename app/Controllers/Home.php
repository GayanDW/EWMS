<?php

namespace App\Controllers;
use Config\Services;

class Home extends BaseController
{
public function login() {
        helper('form');
        echo view('sys/login');
    }

    
    
    
    /*public function index(): string
    {
        return "--E-Waste Management System--";
    }
    
    public function search() {
        echo "Yes";
    }*/
    
}
