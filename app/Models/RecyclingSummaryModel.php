<?php

namespace App\Models;

use CodeIgniter\Model;

class RecyclingSummaryModel extends Model {

    protected $table = 'recycling_summary';
    protected $primaryKey = 'summary_id';
    protected $allowedFields = [
        'UserId',
        'month_year',
        'recovered_material_name',
        'recovered_mass',
        'recovered_unit',
        'disposed_material_name',
        'disposed_mass',
        'disposed_unit'
    ];

}
