<?php

namespace App\Controllers;

class Customer extends BaseController
{
    public function index(): string
    {
        
    }
    
    public function find($id=null,$name=null) {
        $data['heading']= "Employee List";
        $data['year']="2023";
        
        return view('customer/list',$data);
    }
}
