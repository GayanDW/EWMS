<?php

namespace App\Models;

use CodeIgniter\Model;

class DistrictModel extends Model
{
    protected $table="district";
    protected $primaryKey="Id";
    protected $allowedFields=['Id','DistrictName'];
}