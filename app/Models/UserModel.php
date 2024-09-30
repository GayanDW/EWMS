<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {

    protected $table = "user";
    protected $primaryKey = "UserId";
    protected $allowedFields = ['UserId', 'UserName', 'Password', 'email', 'UserType', 'profile_image', 'is_verified', 'is_admin_verified', 'verification_code', 'account_status', 'password_reset_requested_at', 'gra_approval', 'gra_action'];
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeInsert(array $data) {
        $data = $this->passwordHash($data);
        return $data;
    }

    protected function beforeUpdate(array $data) {
        $data = $this->passwordHash($data);
        return $data;
    }

    protected function passwordHash(array $data) {
        if (isset($data['data']['Password']))
            $data['data']['Password'] = password_hash($data['data']['Password'], PASSWORD_DEFAULT);

        return $data;
    }

    public function getAllUsersWithLicense() {
        $db = db_connect(); // Get the database connection
        $sql = "SELECT u.*, l.licenseExpiry, l.license_certificate_path
            FROM user u
            LEFT JOIN ewaste_license l ON l.UserId = u.UserId";
        $query = $db->query($sql);
        return $query->getResultArray(); // Fetch all users along with their license data
    }


    
    }
