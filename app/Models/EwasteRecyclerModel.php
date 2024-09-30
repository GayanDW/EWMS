<?php

namespace App\Models;

use CodeIgniter\Model;

class EwasteRecyclerModel extends Model {

    protected $table = "ewaste_recycler";
    protected $primaryKey = "id";
    protected $allowedFields = [
        'businessName', 'contactNumber', 'email',
        'streetAddress', 'city', 'district', 'user_id'
    ];

}
