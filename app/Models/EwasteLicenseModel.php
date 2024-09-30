<?php

namespace App\Models;

use CodeIgniter\Model;

class EwasteLicenseModel extends Model {

    protected $table = 'ewaste_license';
    protected $primaryKey = 'license_id';
    protected $allowedFields = [
        'license_id', 'UserId', 'UserType', 'licenseNumber', 'licenseExpiry', 'licenseStatus', 'license_certificate_path'
    ];

}
