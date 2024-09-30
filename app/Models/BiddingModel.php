<?php

namespace App\Models;

use CodeIgniter\Model;

class BiddingModel extends Model {

    protected $table = 'bids';
    protected $primaryKey = 'bid_id';
    protected $allowedFields = [
        'bid_price_per_item', 'quantity', 'your_note', 'user_type',
        'item_id', 'UserId', 'bid_status_c', 'bid_status_g', 'rejection_reason', 'payment_method', 'bid_date', 'bid_status_later'
    ];

    public function getDetailedListings($UserId, $item_id) {
        $query = $this->query("
        SELECT 
            e.item_id,
            e.contact_name,
            b.bid_price_per_item,
            b.your_note,
            p.pref_day,
            p.slot_start,
            p.slot_end,
            p.alt_day1,
            p.alt_start1,
            p.alt_end1,
            p.is_pref_day_selected,
            p.is_alt_day1_selected,
            b.bid_status_c
            
        FROM 
            ewaste_listings e
        LEFT JOIN 
            bids b ON e.item_id = b.item_id AND b.UserId = '$UserId' AND b.item_id = '$item_id'
        LEFT JOIN 
            pickup_details p ON e.item_id = p.item_id
        WHERE 
            e.item_id = '$item_id'  
        GROUP BY 
            b.bid_id;
    ");

        $result = $query->getResultArray();
        return $result;
    }

    public function getBidsEwg($item_id) {
        $query = $this->query("
        SELECT 
            b.*, 
            e.contact_name, 
            p.pref_day, 
            p.slot_start, 
            p.slot_end,
            p.alt_day1, 
            p.alt_start1, 
            p.alt_end1, 
            p.is_pref_day_selected, 
            p.is_alt_day1_selected, 
            c.businessName
        FROM 
            bids b
        LEFT JOIN 
            ewaste_listings e ON b.item_id = e.item_id
        LEFT JOIN 
            pickup_details p ON b.bid_id = p.bid_id
        LEFT JOIN 
            ewaste_collector c ON b.UserId = c.UserId
        WHERE 
            b.item_id = '$item_id' 
            AND b.bid_status_c != 'Withdrew'
        GROUP BY 
            b.bid_id;
    ");

        $result = $query->getResultArray();
        return $result;
    }

    public function getBidSummary($userId, $year, $month = null) {
        if (!empty($month) && is_numeric($month)) {
            $sql = "SELECT b.bid_status_g, COUNT(b.bid_id) as count
                FROM bids b
                LEFT JOIN ewaste_listings e ON b.item_id = e.item_id
                WHERE e.UserId = $userId
                AND YEAR(b.bid_date) = $year
                AND MONTH(b.bid_date) = $month
                GROUP BY b.bid_status_g";
        } else {
            $sql = "SELECT b.bid_status_g, COUNT(b.bid_id) as count
                FROM bids b
                LEFT JOIN ewaste_listings e ON b.item_id = e.item_id
                WHERE e.UserId = $userId
                AND YEAR(b.bid_date) = $year
                GROUP BY b.bid_status_g";
        }

        return $this->db->query($sql)->getResultArray();
    }

    public function getRejReasons($userId, $year, $month = null) {
        if (!empty($month) && is_numeric($month)) {
            $sql = "SELECT b.rejection_reason, COUNT(b.bid_id) as count
                FROM bids b
                LEFT JOIN ewaste_listings e ON b.item_id = e.item_id
                WHERE e.UserId = $userId
                AND YEAR(b.bid_date) = $year
                AND MONTH(b.bid_date) = $month
                AND b.bid_status_g = 'Rejected'
                GROUP BY b.rejection_reason";
        } else {
            $sql = "SELECT b.rejection_reason, COUNT(b.bid_id) as count
                FROM bids b
                LEFT JOIN ewaste_listings e ON b.item_id = e.item_id
                WHERE e.UserId = $userId
                AND YEAR(b.bid_date) = $year
                AND b.bid_status_g = 'Rejected'
                GROUP BY b.rejection_reason";
        }

        return $this->db->query($sql)->getResultArray();
    }

    public function getIncome($userId, $year, $month = null) {
        if (!empty($month) && is_numeric($month)) {
            $sql = "SELECT 
                    e.UserId,
                    YEAR(b.bid_date) AS year, 
                    MONTH(b.bid_date) AS month, 
                    COUNT(*) AS totalListings, 
                    SUM(b.bid_price_per_item) AS totalIncome
                FROM 
                    bids b
                INNER JOIN 
                    ewaste_listings e ON b.item_id = e.item_id
                WHERE 
                    e.UserId = $userId AND 
                    YEAR(b.bid_date) = $year AND 
                    MONTH(b.bid_date) = $month AND
                    b.bid_status_later = 'Collected'
                GROUP BY 
                    e.UserId, YEAR(b.bid_date), MONTH(b.bid_date)
                ORDER BY 
                    YEAR(b.bid_date), MONTH(b.bid_date)";
        } else {
            $sql = "SELECT 
                    e.UserId,
                    YEAR(b.bid_date) AS year, 
                    MONTH(b.bid_date) AS month, 
                    COUNT(b.item_id) AS totalListings, 
                    SUM(b.bid_price_per_item) AS totalIncome
                FROM 
                    bids b
                INNER JOIN 
                    ewaste_listings e ON b.item_id = e.item_id
                WHERE 
                    e.UserId = $userId AND 
                    YEAR(b.bid_date) = $year AND 
                    b.bid_status_later = 'Collected'
                GROUP BY 
                    e.UserId, YEAR(b.bid_date), MONTH(b.bid_date)
                ORDER BY 
         YEAR(b.bid_date), MONTH(b.bid_date)";
        }
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getBidSummaryEwc($userId, $year, $month) {
        $sql = "SELECT b.bid_status_g, COUNT(*) as count
                FROM bids b
                INNER JOIN ewaste_listings e ON b.item_id = e.item_id
                WHERE e.UserId = ?
                AND YEAR(b.bid_date) = ?
                AND MONTH(b.bid_date) = ?
                GROUP BY b.bid_status_g";
        $query = $this->query($sql, [$userId, $year, $month]);
        $result = $query->getResultArray();

        $summary = array_column($result, 'count', 'bid_status_g');
        // Sum of all bids for "Received Bids" as total bids on the user's listings
        $summary['Received Bids'] = array_sum($summary);

        return $summary;
    }

    public function getRejectionReasonsSummaryEwc($userId, $year, $month) {
        $sql = "SELECT b.rejection_reason, COUNT(*) as count
                FROM bids b
                INNER JOIN ewaste_listings e ON b.item_id = e.item_id
                WHERE e.UserId = ?
                AND YEAR(b.bid_date) = ?
                AND MONTH(b.bid_date) = ?
                AND b.bid_status_g = 'Rejected'
                GROUP BY b.rejection_reason";
        $query = $this->query($sql, [$userId, $year, $month]);
        $result = $query->getResultArray();

        return array_column($result, 'count', 'rejection_reason');
    }

    public function getBidSummary1($userId, $year = null, $month = null) {
        $baseQuery = $this->db->table($this->table)->where('UserId', $userId);

        $query = $this->query(" SELECT bid_status_c, COUNT(bid_id) AS 'total' FROM `bids` GROUP BY bid_status_c;");

        $result = $query->getResultArray();
        return $result;
    }

    public function getRejectionReasons1($userId, $year = null, $month = null) {
        $query = $this->db->table($this->table)
                ->select('rejection_reason, COUNT(*) as count')
                ->where('UserId', $userId)
                ->where('bid_status_c', 'Rejected');

        if ($year) {
            $query->where('YEAR(bid_date)', $year);
        }

        if ($month) {
            $query->where('MONTH(bid_date)', $month);
        }

        $query->groupBy('rejection_reason');
        $results = $query->get()->getResultArray();

        return array_column($results, 'count', 'rejection_reason');
    }

    public function getEwcCollections($UserId, $year, $month = null) {
        if (!empty($month) && is_numeric($month)) {
            // Query to count distinct generators served
            $generatorsServedSql = "SELECT COUNT(DISTINCT e.UserId) AS 'generatorsServed' 
                            FROM `ewaste_listings` e
                            INNER JOIN `bids` b ON e.`item_id` = b.`item_id`
                            WHERE b.`UserId` = $UserId
                            AND YEAR(b.`bid_date`) = $year
                            AND MONTH(b.`bid_date`) = $month   
                            AND b.`bid_status_later` = 'Collected'";

            $generatorsServedResult = $this->query($generatorsServedSql)->getResultArray();

            // Query to count total collections per item type
            $collectionsSql = "SELECT e.item_type,SUM(e.quantity) AS 'totalquantity' , COUNT(b.item_id) AS 'collections' 
                       FROM `ewaste_listings` e 
                       INNER JOIN `bids` b ON e.`item_id` = b.`item_id`
                       WHERE b.`UserId` = $UserId
                       AND YEAR(b.`bid_date`) = $year
                       AND MONTH(b.`bid_date`) = $month  
                       AND b.`bid_status_later` = 'Collected'
                       GROUP BY e.`item_type`";

            $collectionsResult = $this->query($collectionsSql)->getResultArray();
            $totalCategories = count($collectionsResult);
            $totalCollections = array_sum(array_column($collectionsResult, 'collections'));
            $totalItems = array_sum(array_column($collectionsResult, 'totalquantity')); 

            return [
                'generatorsServed' => $generatorsServedResult[0]['generatorsServed'] ?? 0,
                'collections' => $collectionsResult,
                'totals' => [
                    'totalCategories' => $totalCategories,
                    'totalCollections' => $totalCollections,
                    'totalItems' => $totalItems]
            ];
        } else {

            // Query to count distinct generators served
            $generatorsServedSql = "SELECT COUNT(DISTINCT e.UserId) AS 'generatorsServed' 
                            FROM `ewaste_listings` e
                            INNER JOIN `bids` b ON e.`item_id` = b.`item_id`
                            WHERE b.`UserId` = $UserId
                            AND YEAR(b.`bid_date`) = $year  
                            AND b.`bid_status_later` = 'Collected'";

            $generatorsServedResult = $this->query($generatorsServedSql)->getResultArray();

            // Query to count total collections per item type
            $collectionsSql = "SELECT e.item_type,SUM(e.quantity) AS 'totalquantity' , COUNT(b.item_id) AS 'collections'  
                       FROM `ewaste_listings` e 
                       INNER JOIN `bids` b ON e.`item_id` = b.`item_id`
                       WHERE b.`UserId` = $UserId
                       AND YEAR(b.`bid_date`) = $year
                       AND b.`bid_status_later` = 'Collected'
                       GROUP BY e.`item_type`";

            $collectionsResult = $this->query($collectionsSql)->getResultArray();
            $totalCategories = count($collectionsResult);
            $totalCollections = array_sum(array_column($collectionsResult, 'collections'));
            $totalItems = array_sum(array_column($collectionsResult, 'totalquantity'));

            return [
                'generatorsServed' => $generatorsServedResult[0]['generatorsServed'] ?? 0,
                'collections' => $collectionsResult,
                'totals' => [
                    'totalCategories' => $totalCategories,
                    'totalCollections' => $totalCollections,
                    'totalItems' => $totalItems]
            ];
        }
    }

}
