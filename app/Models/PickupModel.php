<?php

namespace App\Models;

use CodeIgniter\Model;

class PickupModel extends Model {

    protected $table = 'pickup_details';
    protected $primaryKey = 'pickup_id';
    protected $allowedFields = [
        'bid_id', 'pref_day', 'slot_start', 'slot_end',
        'alt_day1', 'alt_start1', 'alt_end1','item_id', 'is_pref_day_selected', 'is_alt_day1_selected'
    ];

}
