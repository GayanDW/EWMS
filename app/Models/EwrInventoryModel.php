<?php

namespace App\Models;

use CodeIgniter\Model;

class EwrInventoryModel extends Model {

    protected $table = 'ewr_inventory';
    protected $primaryKey = 'ewr_inv_id';
    protected $allowedFields = ['listing_set', 'item_id', 'item_name', 'item_type', 'quantity', 'weight', 'weight_unit', 'description', 'item_image', 'set_buying_price', 'status', 'collected_at ', 'recycled_at', 'UserId', 'batch_id', 'status1'];

    public function getMonthlyInventorySummary($userId, $year, $month) {
        $query = $this->db->query("SELECT batch_id, SUM(weight) as total_weight_kg FROM `ewr_inventory`
                                WHERE UserId = ?
                                AND YEAR(recycled_at) = ?
                                AND MONTH(recycled_at) = ?
                                AND weight_unit = 'g'
                                AND status = 'recycled'
                                GROUP BY batch_id", [$userId, $year, $month]);

        $result = $query->getResultArray();

        // Convert grams to kilograms
        foreach ($result as $key => $row) {
            $result[$key]['total_weight_kg'] = $row['total_weight_kg'] / 1000;
        }

        return $result;
    }

    public function getCollectionActivity($userId, $year, $month, $selectedDistrict = null) {
        $districtCondition = '';
        if (!empty($selectedDistrict)) {
            $districtCondition = " AND c.district LIKE '%" . $this->db->escapeLikeString($selectedDistrict) . "%'";
        }

        // Ensure both month and year are provided
        if (!empty($month) && is_numeric($month) && !empty($year) && is_numeric($year)) {
            $sql = "SELECT c.district, COUNT(DISTINCT r.listing_set) AS count
            FROM ewr_inventory r
            LEFT JOIN ewc_listings c ON c.listing_set = r.listing_set
            WHERE r.status1 = 'Collected' AND r.UserId = $userId
            AND YEAR(r.recycled_at) = $year AND MONTH(r.recycled_at) = $month"
                    . $districtCondition .
                    " GROUP BY c.district";
        } else {
            // Return an empty array or a specific message if year and month are not provided
            return [];
        }

        return $this->db->query($sql)->getResultArray();
    }

}
