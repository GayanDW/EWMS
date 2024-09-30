<?php

namespace App\Models;

use CodeIgniter\Model;

class EwasteGeneratorModel extends Model
{
    protected $table = "ewaste_generator";
    protected $primaryKey = "id";
    protected $allowedFields = ['firstName', 'lastName', 'contactNumber', 'email', 'streetAddress', 'city', 'district', 'UserId','AccountNumber','AccountName','BankName','BranchName'];
}
