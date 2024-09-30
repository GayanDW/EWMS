<?php

namespace App\Models;

use CodeIgniter\Model;

class EwasteListModel extends Model {

    protected $table = 'ewaste_listings';
    protected $primaryKey = 'item_id';
    protected $allowedFields = [
        'item_title', 'item_name', 'item_type', 'item_description',
        'item_image', 'quantity', 'weight', 'weight_unit', 'weight_in_kg', 'price_option',
        'amount', 'pickup_location', 'google_location', 'contact_name',
        'contact_number', 'item_status_g', 'cancelled_by_ewg', 'item_status_c', 'cancelled_by_ewc', 'is_edited', 'date_added', 'time_added', 'UserId', 'bid_id', 'collector_id', 'collection_status'
    ];

    public function getListings($UserId = null) {

        //$query = $this->query("SELECT ewaste_listings.*,COUNT(bids.UserId) AS 'nobids' FROM `ewaste_listings` LEFT JOIN bids ON bids.item_id=ewaste_listings.item_id WHERE ewaste_listings.`UserId` = '$UserId' AND ewaste_listings.`item_status_c` != 'Deleted' GROUP BY ewaste_listings.item_id;");

        $query = $this->query("SELECT 
    ewaste_listings.*,
    COUNT(bids.UserId) AS nobids,
    SUM(CASE WHEN ab.bid_status_g = 'Bids Pending' THEN 1 ELSE 0 END) AS pending_bids
FROM 
    ewaste_listings 
LEFT JOIN 
    bids ON bids.item_id = ewaste_listings.item_id 
LEFT JOIN 
    bids ab ON ab.item_id = ewaste_listings.item_id
WHERE 
    ewaste_listings.UserId = '$UserId' 
    AND ewaste_listings.item_status_c != 'Deleted'
    
GROUP BY 
    ewaste_listings.item_id;");

        $result = $query->getResultArray();
        return $result;
    }

    public function getCollectedInfo($userId = null) {

        //$query = $this->query("SELECT ewaste_listings.*,COUNT(bids.UserId) AS 'nobids' FROM `ewaste_listings` LEFT JOIN bids ON bids.item_id=ewaste_listings.item_id WHERE ewaste_listings.`UserId` = '$UserId' AND ewaste_listings.`item_status_c` != 'Deleted' GROUP BY ewaste_listings.item_id;");

        $query = $this->query("SELECT 
    ewaste_listings.*,
  SUM(ewaste_listings.amount) AS total_income
FROM 
    ewaste_listings 

WHERE 
    ewaste_listings.UserId = '$userId' 
   AND ewaste_listings.collection_status= 'Collected'
GROUP BY 
    ewaste_listings.item_id;");

        $result = $query->getResultArray();
        return $result;
    }

    public function getCollectedAmount($userId) {



        $query = $this->query("SELECT 
  SUM(amount) AS total_income
FROM 
    ewaste_listings 
WHERE 
    UserId = '$userId' 
   AND collection_status= 'Collected'
;");

        $result = $query->getRowArray();
        return $result;
    }

    /* public function getColDah($userId) {
      $query = $this->query("
      SELECT
      e.*,
      IF(b.UserId = '$userId', b.bid_status_c, NULL) AS bid_status_c,
      b.bid_id
      FROM
      ewaste_listings e
      LEFT JOIN
      bids b ON e.item_id = b.item_id
      WHERE
      (e.item_status_g != 'Accepted' OR e.item_status_g != 'Cancelled')
      AND (
      (b.bid_status_c = 'Bids Pending' AND b.UserId != '$userId')
      OR (b.bid_status_c IS NULL AND b.UserId = '$userId')
      )
      GROUP BY
      e.item_id
      ");

      return $query->getResultArray();
      } */

    public function getColDash0($userId) {
        $sql = "SELECT
      ewaste_listings.*,
      IF(bids.UserId = ?, bids.bid_status_c, NULL) AS bid_status_c
      FROM
      ewaste_listings
      LEFT JOIN
      bids ON ewaste_listings.item_id = bids.item_id AND bids.UserId = ?
      WHERE
      ewaste_listings.item_status_c != 'Deleted'
      AND ewaste_listings.collection_status != 'Collected'
      AND (
      ewaste_listings.collection_status != 'Collected' OR
      ewaste_listings.collector_id = ? OR
      ewaste_listings.collector_id IS NULL
      )
      AND NOT EXISTS (
      SELECT 1
      FROM bids b2
      WHERE b2.item_id = ewaste_listings.item_id
      AND b2.bid_status_c = ''
      AND b2.UserId != ?
      )
      AND (bids.bid_status_c != 'Bids Pending' OR bids.bid_status_c IS NULL)
      AND (bids.bid_status_c != 'Accepted' OR bids.bid_status_c IS NULL)
      GROUP BY
      ewaste_listings.item_id";

        return $this->query($sql, [$userId, $userId, $userId, $userId])->getResultArray();
    }

    public function getColDash1($userId) {
        $sql = "SELECT
      ewaste_listings.*,
      IF(bids.UserId = ?, bids.bid_status_c, NULL) AS bid_status_c
      FROM
      ewaste_listings
      LEFT JOIN
      bids ON ewaste_listings.item_id = bids.item_id AND bids.UserId = ?
      WHERE
      ewaste_listings.item_status_c != 'Deleted'
      
      AND NOT EXISTS (
      SELECT 1
      FROM bids b2
      WHERE b2.item_id = ewaste_listings.item_id
      AND b2.bid_status_c = ''
      AND b2.UserId != ?
      )
      
      GROUP BY
      ewaste_listings.item_id";

        return $this->query($sql, [$userId, $userId, $userId, $userId])->getResultArray();
    }

    public function getColDash2($userId) {
        $sql = "SELECT
      ewaste_listings.*,
      IF(bids.UserId = '$userId', bids.bid_status_c, NULL) AS bid_status_c
      FROM
      ewaste_listings
      LEFT JOIN
      bids ON ewaste_listings.item_id = bids.item_id AND bids.UserId = '$userId'
      WHERE
      ewaste_listings.item_status_c != 'Deleted'
      AND NOT EXISTS (
        SELECT 1
        FROM bids b2
        WHERE b2.item_id = ewaste_listings.item_id
        AND b2.bid_status_c = ''
        AND b2.UserId != '$userId'
      )
      GROUP BY
      ewaste_listings.item_id";

        return $this->query($sql)->getResultArray();
    }

    public function getColDash($userId) {
        $sql = "SELECT
      ewaste_listings.*,
      IF(bids.UserId = '$userId', bids.bid_status_c, NULL) AS bid_status_c
      FROM
      ewaste_listings
      LEFT JOIN
      bids ON ewaste_listings.item_id = bids.item_id AND bids.UserId = '$userId'
      WHERE
      ewaste_listings.item_status_c != 'Deleted'
      AND (
        NOT EXISTS (
          SELECT 1
          FROM bids b2
          WHERE b2.item_id = ewaste_listings.item_id
          AND b2.bid_status_c = 'Accepted'
        )
        OR EXISTS (
          SELECT 1
          FROM bids b3
          WHERE b3.item_id = ewaste_listings.item_id
          AND b3.UserId = '$userId'
        )
      )
      AND NOT EXISTS (
        SELECT 1
        FROM bids b2
        WHERE b2.item_id = ewaste_listings.item_id
        AND b2.bid_status_c = ''
        AND b2.UserId != '$userId'
      )
      GROUP BY
      ewaste_listings.item_id";

        return $this->query($sql)->getResultArray();
    }

    public function getListingsForPendingBids($userId) {
        $sql = "   SELECT 
    ewaste_listings.*, 
    bids.bid_status_c,
    bids.bid_id
FROM 
    ewaste_listings
LEFT JOIN 
    bids ON ewaste_listings.item_id = bids.item_id AND bids.UserId = '$userId'
WHERE 
    bids.bid_status_c = 'Bids Pending'
GROUP BY 
    ewaste_listings.item_id;";

        return $this->query($sql)->getResultArray();
    }

    public function getAllBidList($userId, $status = null) {

        if ($status == null) {


            $sql = "   SELECT 
    ewaste_listings.*, 
    bids.bid_status_c,
    bids.bid_id
FROM 
    ewaste_listings
LEFT JOIN 
    bids ON ewaste_listings.item_id = bids.item_id AND bids.UserId = '$userId'
WHERE 
    bids.bid_status_c = 'Accepted' OR bids.bid_status_c ='Bids Pending' OR bids.bid_status_c ='Rejected'
GROUP BY 
    ewaste_listings.item_id;";
        }

        if ($status == 'all') {


            $sql = "   SELECT 
    ewaste_listings.*, 
    bids.bid_status_c,
    bids.bid_id
FROM 
    ewaste_listings
LEFT JOIN 
    bids ON ewaste_listings.item_id = bids.item_id AND bids.UserId = '$userId'
WHERE 
    bids.bid_status_c = 'Accepted' OR bids.bid_status_c ='Bids Pending' OR bids.bid_status_c ='Rejected'
GROUP BY 
    ewaste_listings.item_id;";
        }
        if ($status == 'Accepted') {


            $sql = "   SELECT 
    ewaste_listings.*, 
    bids.bid_status_c,
    bids.bid_id
FROM 
    ewaste_listings
LEFT JOIN 
    bids ON ewaste_listings.item_id = bids.item_id AND bids.UserId = '$userId'
WHERE 
    bids.bid_status_c = 'Accepted' 
GROUP BY 
    ewaste_listings.item_id;";
        }

        if ($status == 'Bids Pending') {


            $sql = "   SELECT 
    ewaste_listings.*, 
    bids.bid_status_c,
    bids.bid_id
FROM 
    ewaste_listings
LEFT JOIN 
    bids ON ewaste_listings.item_id = bids.item_id AND bids.UserId = '$userId'
WHERE 
    bids.bid_status_c ='Bids Pending'
GROUP BY 
    ewaste_listings.item_id;";
        }

        if ($status == 'Rejected') {


            $sql = "   SELECT 
    ewaste_listings.*, 
    bids.bid_status_c,
    bids.bid_id
FROM 
    ewaste_listings
LEFT JOIN 
    bids ON ewaste_listings.item_id = bids.item_id AND bids.UserId = '$userId'
WHERE 
    bids.bid_status_c ='Rejected'
GROUP BY 
    ewaste_listings.item_id;";
        }
        return $this->query($sql)->getResultArray();
    }

    public function acceptedBidsForEwc($userId) {
        $sql = "   SELECT 
    ewaste_listings.*, 
    bids.bid_status_c
FROM 
    ewaste_listings
LEFT JOIN 
    bids ON ewaste_listings.item_id = bids.item_id AND bids.UserId = '$userId'
WHERE 
    bids.bid_status_c = 'Accepted'
    AND ewaste_listings.collection_status != 'Collected'
GROUP BY 
    ewaste_listings.item_id;";

        return $this->query($sql)->getResultArray();
    }

    public function acceptedBidsFor($userId) {
        $sql = "   SELECT 
    ewaste_listings.*, 
    bids.bid_status_c
FROM 
    ewaste_listings
LEFT JOIN 
    bids ON ewaste_listings.item_id = bids.item_id AND bids.UserId = '$userId'
WHERE 
    bids.bid_status_c = 'Accepted'
    AND ewaste_listings.collection_status != 'Collected'
GROUP BY 
    ewaste_listings.item_id;";

        return $this->query($sql)->getResultArray();
    }

    public function getColCancellations($userId) {
        $query = $this->query("
        SELECT 
            e.*, 
            b.bid_status_c
        FROM 
            ewaste_listings e
        LEFT JOIN 
            bids b ON e.item_id = b.item_id
        WHERE 
            b.UserId = '$userId' 
            AND b.bid_status_c = 'Cancelled'
        GROUP BY 
            e.item_id;
    ");

        $result = $query->getResultArray();
        return $result;
    }

    public function getRejections($userId) {
        $query = $this->query("
        SELECT 
            e.*, 
            b.bid_status_c,
            b.rejection_reason
        FROM 
            ewaste_listings e
        LEFT JOIN 
            bids b ON e.item_id = b.item_id
        WHERE 
            b.UserId = '$userId' 
            AND b.bid_status_c = 'Rejected'
        GROUP BY 
            e.item_id;
    ");

        $result = $query->getResultArray();
        return $result;
    }

    /* public function monthlyListings($year, $month = null) {
      return $this->db->query("
      SELECT
      item_type,
      COUNT(item_id) AS nooflist
      FROM
      ewaste_listings
      WHERE
      YEAR(date_added) = " . $year .
      ($month ? " AND MONTH(date_added) = " . $month : "") .
      " GROUP BY item_type
      ")->getResultArray();
      } */

    public function monthlyListings($userId, $year, $month = null) {
        // Check if month is provided and is a valid number
        $WHERE = null;
        if (!empty($year)) {
            $WHERE .= " YEAR(date_added) = $year AND";
        }
        if (!empty($month)) {
            $WHERE .= " MONTH(date_added) = $month AND";
        }
        if (!empty($userId)) {
            $WHERE .= " UserId = $userId AND";
        }
        if (!empty($WHERE)) {
            $WHERE = substr($WHERE, 0, -3);
            $WHERE = " WHERE $WHERE";
        }

        $sql = "SELECT 
                    item_type, 
                    COUNT(item_id) AS nooflist
                FROM 
                    ewaste_listings
                $WHERE
                GROUP BY item_type";

        return $this->query($sql)->getResultArray();
    }

    public function getSummary($userId, $year, $month = null) {
        if (!empty($month) && is_numeric($month)) {
            // If a valid month is specified, include it in the WHERE clause
            $sql = "SELECT 
                    COUNT(*) AS totalListed,
                    SUM(CASE WHEN item_status_g NOT IN ('Deleted') THEN 1 ELSE 0 END) AS active,
                    SUM(CASE WHEN item_status_g = 'Accepted' THEN 1 ELSE 0 END) AS soldOut,
                    SUM(CASE WHEN item_status_g = 'Deleted' THEN 1 ELSE 0 END) AS deleted
                FROM 
                    ewaste_listings
                WHERE 
                    YEAR(date_added) = $year AND MONTH(date_added) = $month AND UserId= $userId";
        } else {
            // If no month is provided, omit the MONTH condition
            $sql = "SELECT 
                    COUNT(*) AS totalListed,
                    SUM(CASE WHEN item_status_g NOT IN ('Deleted') THEN 1 ELSE 0 END) AS active,
                    SUM(CASE WHEN item_status_g = 'Accepted' THEN 1 ELSE 0 END) AS soldOut,
                    SUM(CASE WHEN item_status_g = 'Deleted' THEN 1 ELSE 0 END) AS deleted
                FROM 
                    ewaste_listings
                WHERE 
                    YEAR(date_added) = $year AND UserId= $userId";
        }

        $query = $this->db->query($sql);
        $result = $query->getRow();

        return [
            'totalListed' => $result->totalListed ?? 0,
            'active' => $result->active ?? 0,
            'soldOut' => $result->soldOut ?? 0,
            'deleted' => $result->deleted ?? 0
        ];
    }

}
