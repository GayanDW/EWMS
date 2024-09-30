<?php

namespace App\Models;

use CodeIgniter\Model;

class FaqModel extends Model {

    protected $table = 'FAQ';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'subject', 'description',
    ];
}