<?php

namespace App\Models;

use CodeIgniter\Model;

class EwrRequestModel extends Model {

    protected $table = 'ewr_req';
    protected $primaryKey = 'ewr_req_id';
    protected $allowedFields = [
        'listing_set', 'UserId', 'recycler_id', 'your_note',
        'req_made_at', 'slot_start', 'slot_end', 'alt_day1',
        'alt_start1', 'alt_end1', 'pref_selection', 'alt_selection',
        'req_status_c', 'req_status_r', 'rejection_reason', 'payment_method', 'selling_price',
        'bank_slip', 'req_status_later', 'req_made_at'
    ];

    public function getRequestSummary($userId, $year, $month = null) {
        if (!empty($month) && is_numeric($month)) {
            $sql = "SELECT req_status_c, COUNT(*) as count
                    FROM ewr_req
                    WHERE UserId = $userId AND YEAR(req_made_at) = $year AND MONTH(req_made_at) = $month
                    GROUP BY req_status_c";
        } else {
            $sql = "SELECT req_status_c, COUNT(*) as count
                    FROM ewr_req
                    WHERE UserId = $userId AND YEAR(req_made_at) = $year
                    GROUP BY req_status_c";
        }
        return $this->db->query($sql)->getResultArray();
    }

    public function getRejectionReasons($userId, $year, $month = null) {
        if (!empty($month) && is_numeric($month)) {
            $sql = "SELECT rejection_reason, COUNT(*) as count
                    FROM ewr_req
                    WHERE UserId = $userId AND YEAR(req_made_at) = $year AND MONTH(req_made_at) = $month
                    AND rejection_reason IS NOT NULL
                    GROUP BY rejection_reason";
        } else {
            $sql = "SELECT rejection_reason, COUNT(*) as count
                    FROM ewr_req
                    WHERE UserId = $userId AND YEAR(req_made_at) = $year
                    AND rejection_reason IS NOT NULL
                    GROUP BY rejection_reason";
        }
        return $this->db->query($sql)->getResultArray();
    }

}
