<?php

namespace App\Models;

use CodeIgniter\Model;

class EwcInventoryModel extends Model {

    protected $table = 'ewc_inventory';
    protected $primaryKey = 'inventory_number';
    protected $allowedFields = [
        'UserId', 'item_id', 'item_name', 'item_type',
        'item_image', 'quantity', 'weight', 'weight_unit',
        'description', 'list_status_c', 'selling_price',
        'total_payment', 'payment_method', 'bank_slip', 'date_collected'
    ];

// In EwcInventoryModel
    public function filterInventory($userId, $itemType = '', $minCost = '', $maxCost = '') {
        $this->where('UserId', $userId);
        $this->where('list_status_c', 'not published');

        if (!empty($itemType)) {
            $this->where('item_type', $itemType);
        }
        if ($minCost !== '') {
            $this->where('total_payment >=', $minCost);
        }
        if ($maxCost !== '') {
            $this->where('total_payment <=', $maxCost);
        }

        return $this->findAll();
    }

    public function getEwcTransactions($userId, $year, $month = null) {
        if (!empty($month) && is_numeric($month)) {
            $sql = "SELECT 
                    item_type AS Category, 
                    COUNT(inventory_number) AS tcCount,
                    SUM(total_payment * (payment_method = 'Cash')) AS Cash_Payment, 
                    SUM(total_payment * (payment_method = 'bank_deposit')) AS Bank_Payment, 
                    SUM(total_payment) AS Total_Payment
                FROM ewc_inventory
                WHERE UserId = $userId
                AND YEAR(date_collected) = $year 
                AND MONTH(date_collected) = $month
                GROUP BY item_type";
        } else {
            $sql = "SELECT 
                    item_type AS Category, 
                    COUNT(inventory_number) AS tcCount,
                    SUM(total_payment * (payment_method = 'Cash')) AS Cash_Payment, 
                    SUM(total_payment * (payment_method = 'bank_deposit')) AS Bank_Payment, 
                    SUM(total_payment) AS Total_Payment
                FROM ewc_inventory
                WHERE UserId = $userId 
                AND YEAR(date_collected) = $year 
                GROUP BY item_type";
        }

        return $this->db->query($sql)->getResultArray();
    }

    public function getEwcTCount($userId, $year, $month = null) {
        if (!empty($month) && is_numeric($month)) {
            $sql = "SELECT 
                    COUNT(total_payment) AS tcount
                FROM ewc_inventory
                WHERE UserId = $userId
                AND YEAR(date_collected) = $year 
                AND MONTH(date_collected) = $month";
        } else {
            $sql = "SELECT 
                    COUNT(total_payment) AS tcount
                FROM ewc_inventory
                WHERE UserId = $userId 
                AND YEAR(date_collected) = $year";
        }

        return $this->db->query($sql)->getResultArray();
    }

}
