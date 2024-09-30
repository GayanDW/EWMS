<?php

namespace App\Models;

use CodeIgniter\Model;

class EwcListingsModel extends Model {

    protected $table = 'ewc_listings';
    protected $primaryKey = 'ewc_listing_id';
    protected $allowedFields = [
        'ewc_listing_title', 'listing_set', 'collector_name', 'item_name', 'item_type', 'item_image', 'quantity', 'weight', 'description', 'selling_price',
        'weight_unit', 'list_status_r', 'list_status_c', 'item_id', 'UserId', 'inventory_number', 'pickup_location', 'google_location', 'contact_name', 'contact_number',
        'date_added', 'time_added'
    ];

    public function getListingsToEwc($userId) {
        $sql = "
        SELECT 
           ewc_listings.*,
            ewr_req.req_status_c,
            ewr_req.req_status_later
        FROM
            ewc_listings
        LEFT JOIN
            ewr_req ON ewc_listings.listing_set = ewr_req.listing_set
        WHERE
            ewc_listings.UserId = ?
        ORDER BY
            ewc_listings.date_added DESC, ewc_listings.time_added DESC
    ";

        return $this->db->query($sql, [$userId])->getResultArray();
    }

    public function getListingsToEwcSet($userId, $listingSet) {
        $sql = "
    SELECT ewc_listings.*, 
           ewr_req.req_status_c,
           ewr_req.req_status_later,
           SUM(CASE WHEN ewr_req.req_status_c = 'requested' THEN 1 ELSE 0 END) AS pending_requests
    FROM ewc_listings
    LEFT JOIN ewr_req ON ewc_listings.listing_set = ewr_req.listing_set
    WHERE ewc_listings.UserId = ? AND ewc_listings.listing_set = ?
    GROUP BY ewc_listings.listing_set
    ";

        return $this->db->query($sql, [$userId, $listingSet])->getRowArray(); // Ensure to fetch single result correctly
    }

    public function getListingsWithRequestStatus($userId) {
        $sql = "
        SELECT 
    ewc_listings.*,
    COALESCE(
        MAX(CASE WHEN ewr_req.req_status_later = 'collected' THEN 'Collected' END),
        MAX(CASE WHEN ewr_req.req_status_c = 'accepted' THEN 'Accepted' END),
        MAX(CASE WHEN ewr_req.req_status_c = 'requested' THEN 'Requested' END),
        'Published'
    ) AS status
FROM
    ewc_listings
LEFT JOIN
    ewr_req ON ewc_listings.listing_set = ewr_req.listing_set
WHERE
    ewc_listings.UserId = ?
GROUP BY
    ewc_listings.ewc_listing_id, ewc_listings.listing_set
ORDER BY
    ewc_listings.date_added DESC, ewc_listings.time_added DESC
    ";
        return $this->db->query($sql, [$userId])->getResultArray();
    }

    public function getListingDetailsAndItems($userId, $listingSet) {
        $sql = "
    SELECT 
        ewc_listings.*,
        COALESCE(
            MAX(CASE WHEN ewr_req.req_status_later = 'collected' THEN 'Collected' END),
            MAX(CASE WHEN ewr_req.req_status_c = 'accepted' THEN 'Accepted' END),
            MAX(CASE WHEN ewr_req.req_status_c = 'requested' THEN 'Requested' END),
            'Published'
        ) AS status
    FROM
        ewc_listings
    LEFT JOIN
        ewr_req ON ewc_listings.listing_set = ewr_req.listing_set
    WHERE
        ewc_listings.UserId = ? AND ewc_listings.listing_set = ?
    GROUP BY
        ewc_listings.ewc_listing_id, ewc_listings.listing_set
    ORDER BY
        ewc_listings.date_added DESC, ewc_listings.time_added DESC
    ";
        // Notice the change here, combining $userId and $listingSet into a single array
        return $this->db->query($sql, [$userId, $listingSet])->getResultArray();
    }

    public function getListingsEwr($userId) {
        $sql = "
        SELECT 
            ewc_listings.*,
            COALESCE(
                (CASE 
                    WHEN ewr_req.rejection_reason IN ('SoldOut') THEN ewr_req.rejection_reason
                    WHEN ewr_req.req_status_later IN ('collected') THEN ewr_req.req_status_later
                    WHEN ewr_req.req_status_r IN ('accepted', 'requested') THEN ewr_req.req_status_r
                    ELSE 'Available'
                END),
                'Available'
            ) AS final_status
        FROM
            ewc_listings
        LEFT JOIN
            ewr_req ON ewc_listings.listing_set = ewr_req.listing_set AND ewr_req.UserId = ?
        GROUP BY
            ewc_listings.ewc_listing_id, ewc_listings.listing_set
        ORDER BY
            ewc_listings.date_added DESC, ewc_listings.time_added DESC
    ";
        return $this->db->query($sql, [$userId])->getResultArray();
    }

}
