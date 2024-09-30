<?php

namespace App\Models;

use CodeIgniter\Model;

class GovAgencyModel extends Model {

    protected $table = 'gov_agency'; 
    protected $primaryKey = 'gov_id'; 
    
    protected $allowedFields = [
        'branch_name', 'branch_code', 'email_address',
        'contact_number', 'street_address', 'city', 'district'
    ];

}
