<?php

namespace App\Models;

use CodeIgniter\Model;

class EwasteCollectorModel extends Model
{
    protected $table = "ewaste_collector";
    protected $primaryKey = "collector_id";
    protected $allowedFields = [
        'businessName', 'contactNumber', 'email', 'licenseNumber', 'licenseExpiry','licenseStatus',
        'streetAddress', 'city', 'district', 'AccountNumber', 'AccountName', 
        'BankName', 'BranchName', 'UserId'
    ];
}
