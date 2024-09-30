<?php

namespace App\Controllers;

use Config\Services;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\EwasteListModel;
use App\Models\BiddingModel;
use App\Models\UserModel;
use App\Models\PickupModel;
use App\Models\EwcInventoryModel;
use App\Models\EwcSalesListModel;
use App\Models\EwrBiddingModel;
use App\Models\NotificationModel;
use App\Models\EwcListingsModel;
use App\Models\EwrRequestModel;
use App\Models\EwasteCollectorModel;
use App\Models\EwrInventoryModel;
use App\Models\RecyclingSummaryModel;
use App\Models\RecycledMaterialsModel;
use App\Models\CategoryModel;

class Sys extends BaseController {

    public function index() {
        helper('form');
        echo view('sys/login');
    }

    public function dashboard() {
        helper('form');
        $user_type = strtolower(session()->get('UserType'));
        $userId = session()->get('UserId');
        $ewasteModel = new EwasteListModel();
        $ewcModel = new EwcListingsModel();
        $reqModel = new EwrRequestModel();
        $data['userId'] = $userId;

        if ($user_type === 'e-waste collector') {
            $data['listings'] = $ewasteModel->getColDash($userId);
            $data['pending'] = $ewasteModel->getListingsForPendingBids($userId);
        } elseif ($user_type === 'e-waste recycler') {
            // Using refined function to get listings with additional status details
            $data['listings'] = $ewcModel->getListingsEwr($userId);
            $data['ewasterequestModel'] = $reqModel;
        } elseif ($user_type === 'gov-agency') {
            $data['govAgencyData'] = "Data specific to gov-agency users";
            return $this->viewUserReview();
        } elseif ($user_type === 'admin') {
            $data['adminData'] = "Data specific to admin users";
            return $this->viewUserMgt();
        } else {
            $data['listings'] = $ewasteModel->getListings($userId);
            //$data['listings'] = $ewasteModel->where('UserId', $userId)->findAll();
        }

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/content_' . $user_type, $data);
        echo view('sys/footer');
    }

    public function pendingBids() {
        $user_type = strtolower(session()->get('UserType'));
        $userId = session()->get('UserId');
        $ewasteModel = new \App\Models\EwasteListModel();
        $biddingModel = new \App\Models\BiddingModel();
        $data['userId'] = $userId;

        if ($user_type === 'e-waste collector') {
            $data['listings'] = $ewasteModel->getListingsForPendingBids($userId);
            $data['bids'] = $biddingModel->where('UserId', $userId)->findAll();
        }

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/pending_bids', $data);
        echo view('sys/footer');
    }

    public function getAllBidList() {
        helper('form');
        $user_type = strtolower(session()->get('UserType'));
        $userId = session()->get('UserId');
        $ewasteModel = new \App\Models\EwasteListModel();
        $status = $this->request->getPost('status');

        if ($user_type === 'e-waste collector') {
            $data['listings'] = $ewasteModel->getAllBidList($userId, $status);
        }

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/get_all_bids', $data);
        echo view('sys/footer');
    }

    public function colCancellations() {
        $user_type = strtolower(session()->get('UserType'));
        $userId = session()->get('UserId');
        $ewasteModel = new \App\Models\EwasteListModel();
        $data['listings'] = $ewasteModel->getColCancellations($userId);
        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/col_cancel_ewc', $data);
        echo view('sys/footer');
    }

    public function rejectedBids() {
        $user_type = strtolower(session()->get('UserType'));
        $userId = session()->get('UserId');
        $ewasteModel = new \App\Models\EwasteListModel();
        $data['listings'] = $ewasteModel->getRejections($userId);
        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/rejected_bids', $data);
        echo view('sys/footer');
    }

    public function acceptedBids() {
        $user_type = strtolower(session()->get('UserType'));
        $userId = session()->get('UserId');
        $ewasteModel = new \App\Models\EwasteListModel();

        $data['userId'] = $userId;

        if ($user_type === 'e-waste collector') {
            $data['listings'] = $ewasteModel->acceptedBidsForEwc($userId);
        }

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/accepted_for_ewc', $data);
        echo view('sys/footer');
    }

    public function sendmail() {
        $email = \Config\Services::email();
        $email->setTo('gayanyn@gmail.com');
        $email->setFrom('your_email@gmail.com', 'Your Name');
        $email->setSubject('Gayan');
        $message = '<h1>account verification</h1>';
        $message .= '<a href="http://localhost/ewms/sys/verifymyaccount/999"> click here to verify my account</a>';
        $email->setMessage($message);
        if ($email->send()) {
            echo 'Email sent successfully';
        } else {
            echo 'Email could not be sent';
            echo $email->printDebugger(['headers']);
        }
    }

    public function verifymyaccount($userId = null) {
        echo 'you are verified now';
        echo '<br>';
        echo $userId;
    }

    public function notAuthorised() {
        $data['message'] = 'Your account is not verified. Please check your email for the verification link.';
        echo view('sys/warnings', $data);
    }

    public function adminNotAuthorised() {
        $data['message'] = 'Your account has not been authorized by an administrator yet. Please wait for admin approval.
If there are any inquiries, contact us via support@cea.lk.';
        echo view('sys/warnings', $data);
    }

    public function viewNotifications($itemId = null) {
        $userId = session()->get('UserId');
        $notificationModel = new \App\Models\NotificationModel();

        if (is_null($itemId)) {
            $notifications = $notificationModel->getNotificationsForUser($userId);
        } else {
            $notifications = $notificationModel->where('UserId', $userId)->where('item_id', $itemId)->orderBy('created_at', 'DESC')->findAll();
        }

// Mark each notification as read
        foreach ($notifications as $notification) {
            $notificationModel->markAsRead($notification['notification_id']);
        }

        $data['notifications'] = $notifications;

        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/notifications', $data);
        echo view('sys/footer');
    }

    public function handleNotification($notificationId, $itemId) {
        $notificationModel = new \App\Models\NotificationModel();
        $userId = session()->get('UserId');

// Mark the notification as read
        $notificationModel->markAsRead($notificationId);

// Redirect to the detailed view of the item
        return redirect()->to(base_url('sys/detailedView/' . $itemId));
    }

    public function thankYou() {
// Retrieve the message from session flashdata
        $data['message'] = session()->getFlashdata('message');

// Load the thank_you view with the message
        echo view('sys/thank_you', $data);
    }

    public function success() {
// Retrieve the message from session flashdata
        $data['message'] = session()->getFlashdata('message');

// Load the thank_you view with the message
        echo view('sys/success', $data);
    }

    public function warnings() {
// Retrieve the message from session flashdata
        $data['message'] = session()->getFlashdata('message');

// Load the thank_you view with the message
        echo view('sys/warnings', $data);
    }

    public function viewAddEwaste() {
        helper('form');
        $Item_Category = new CategoryModel();
        $data['Item_Category'] = $Item_Category->findAll();
        $user_type = strtolower(session()->get('UserType'));

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/addEwasteForm', $data);
        echo view('sys/footer');
    }

    public function submitEwaste() {
        helper(['form']);
        $user_type = strtolower(session()->get('UserType'));
        $data = [];
        $ewasteModel = new EwasteListModel();

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'item_title' => ['label' => 'Item Title', 'rules' => 'required'],
                'item_name' => ['label' => 'Item Name', 'rules' => 'required'],
                'item_type' => ['label' => 'Item Type', 'rules' => 'required'],
                'item_description' => ['label' => 'Description', 'rules' => 'required'],
                'item_image' => [
                    'label' => 'Image',
                    'rules' => 'uploaded[item_image]|is_image[item_image]|max_size[item_image,2048]',
                    'errors' => [
                        'uploaded' => 'Valid image is required.'
                    ]
                ],
                'quantity' => ['label' => 'Quantity', 'rules' => 'required|is_numeric'],
                'weight' => ['label' => 'Weight of all of the Items', 'rules' => 'required|is_numeric'],
                'weight_unit' => ['label' => 'Weight Unit', 'rules' => 'required|in_list[g,kg]'],
                'price_option' => ['label' => 'Price Option', 'rules' => 'required|in_list[free,expected]'],
                'amount' => ['label' => 'Amount', 'rules' => 'permit_empty|is_numeric'],
                'pickup_location' => ['label' => 'Pickup Location', 'rules' => 'required'],
                'google_location' => ['label' => 'Google Location Link', 'rules' => 'permit_empty'],
                'contact_name' => ['label' => 'Contact Name', 'rules' => 'required'],
                'contact_number' => ['label' => 'Contact Number', 'rules' => 'required|min_length[10]|max_length[10]'],
            ];

            $priceOption = $this->request->getPost('price_option');
            if ($priceOption == 'expected') {
                $rules['amount'] = ['label' => 'Amount', 'rules' => 'required|is_numeric'];
            } else {
                $rules['amount'] = ['label' => 'Amount', 'rules' => 'permit_empty|is_numeric'];
            }


            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $item_image = $this->request->getFile('item_image');
                $newName = $item_image->getRandomName();
                $item_image->move('public/images/' . 'uploads', $newName);

                // Convert weight to kilograms if submitted in grams
                $weight = $this->request->getPost('weight');
                $weight_unit = $this->request->getPost('weight_unit');
                if ($weight_unit === 'g') {
                    $weight_in_kg = $weight / 1000;
                } else {
                    $weight_in_kg = $weight;
                }


                $success = $ewasteModel->save([
                    'UserId' => session()->get('UserId'),
                    'item_title' => $this->request->getPost('item_title'),
                    'item_name' => $this->request->getPost('item_name'),
                    'item_type' => $this->request->getPost('item_type'),
                    'item_description' => $this->request->getPost('item_description'),
                    'item_image' => $newName,
                    'quantity' => $this->request->getPost('quantity'),
                    'weight' => $this->request->getPost('weight'),
                    'weight_unit' => $this->request->getPost('weight_unit'),
                    'weight_in_kg' => $weight_in_kg,
                    'price_option' => $this->request->getPost('price_option'),
                    'amount' => $this->request->getPost('amount'),
                    'pickup_location' => $this->request->getPost('pickup_location'),
                    'google_location' => $this->request->getPost('google_location'),
                    'contact_name' => $this->request->getPost('contact_name'),
                    'contact_number' => $this->request->getPost('contact_number'),
                    'item_status_g' => 'No Bids Yet',
                    'item_status_c' => 'Open for Bidding',
                    'date_added' => date("Y-m-d"),
                    'time_added' => date("H:i:s"),
                ]);

                if ($success) {
// Successfully saved the data
                    $data['message'] = 'E-waste submitted successfully.';
                    echo view('sys/thank_you', $data);
                }
            }
            // If validation fails, reload the form view with validation errors
            echo view('sys/header');
            echo view('sys/menu_' . $user_type);
            echo view('sys/addEwasteForm', $data);
            echo view('sys/footer');
        }
    }

    public function detailedViewEwg($item_id) {
        $ewasteModel = new EwasteListModel();
        $data['item'] = $ewasteModel->find($item_id);
        $user_type = strtolower(session()->get('UserType'));

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/detailed_view_ewg', $data);
        echo view('sys/footer');
    }

    public function detailedViewEwc($item_id) {
        $ewasteModel = new \App\Models\EwasteListModel();
        $biddingModel = new \App\Models\BiddingModel();

        $data['item'] = $ewasteModel->find($item_id);
        $userId = session()->get('UserId');

// Fetch user bid for the item, if exists
        $userBid = $biddingModel->where('item_id', $item_id)
                ->where('UserId', $userId)
                ->first();
        $data['userBid'] = $userBid;

// Check if there are any accepted bids for the item
        $acceptedBid = $biddingModel->where('item_id', $item_id)
                ->where('bid_status_c', 'Accepted')
                ->first();
        $data['acceptedBid'] = $acceptedBid;

// Determine if the user can bid on the item
        $canBid = !$acceptedBid || ($acceptedBid && $acceptedBid['UserId'] != $userId);
        $data['canBid'] = $canBid;

// Check for existing bids on the item to enable 'Bid Info' button
        $hasBids = $biddingModel->where('item_id', $item_id)->countAllResults() > 0;
        $data['hasBids'] = $hasBids;

        $user_type = strtolower(session()->get('UserType'));

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/detailed_view_ewc', $data); // Ensure the view path matches your application structure
        echo view('sys/footer');
    }

    public function displayBiddingForm($item_id, $type = null) {
        helper(['form']);

        $data = [];
        $ewasteModel = new \App\Models\EwasteListModel();
        $data['itemDetails'] = $ewasteModel->where('item_id', $item_id)->first();
        $user_type = strtolower(session()->get('UserType'));
        $data['item_id'] = $item_id;
        $data['free'] = ($type == 'free');

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/bidding_form', $data);
        echo view('sys/footer');
    }

    public function saveBid() {
        helper(['form']);

        $biddingModel = new \App\Models\BiddingModel();
        $pickupModel = new \App\Models\PickupModel();
        $ewasteListingModel = new \App\Models\EwasteListModel();
        $userId = session()->get('UserId');
        $userType = session()->get('UserType');
        $data = [];

// Fetch item_id from POST data and ensure it's available for use in this method
        $data['item_id'] = $this->request->getPost('item_id');
        $data['free'] = $this->request->getPost('free');
        $ewasteListing = $ewasteListingModel->where('item_id', $data['item_id'])->first();

        $contact_name = $ewasteListing['contact_name'];
        $quantity = $ewasteListing['quantity'];

        // Check if the user has already submitted a bid for this item
        $existingBid = $biddingModel->where('item_id', $data['item_id'])
                ->where('UserId', $userId)
                ->first();

        if ($existingBid) {
            // Display an error message indicating that the user has already submitted a bid for this item
            session()->setFlashdata('error', 'You have already submitted a bid for this item.');
            return redirect()->to(previous_url());
        }


        $ewasteModel = new \App\Models\EwasteListModel();
        $data['itemDetails'] = $ewasteModel->where('item_id', $data['item_id'])->first();

        if ($this->request->getMethod() === 'post') {

            $rules = [
                'your_note' => 'required',
                'pref_day' => 'required',
                'slot_start' => 'required',
                'slot_end' => 'required',
                'payment_method' => 'required',
            ];

            if ($ewasteListing['price_option'] !== 'free') {
                $rules['bid_price_per_item'] = 'required|numeric';
                $bidPrice = $this->request->getPost('bid_price_per_item');
            } else {
                $bidPrice = 0;
            }

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $bidData = [
                    'item_id' => $data['item_id'], // Use the fetched $item_id
                    'UserId' => $userId,
                    'user_type' => $userType,
                    'bid_price_per_item' => $bidPrice,
                    'quantity' => $quantity,
                    'your_note' => $this->request->getPost('your_note'),
                    'bid_status_g' => 'Bids Pending',
                    'bid_status_c' => 'Bids Pending',
                    'payment_method' => $this->request->getPost('payment_method'),
                    'bid_date' => date("Y-m-d"),
                ];

                if ($biddingModel->save($bidData)) {
                    $bidId = $biddingModel->getInsertID();
                    $pickupData = [
                        'item_id' => $data['item_id'],
                        'bid_id' => $bidId,
                        'contact_name' => $contact_name,
                        'pref_day' => $this->request->getPost('pref_day'),
                        'slot_start' => $this->request->getPost('slot_start'),
                        'slot_end' => $this->request->getPost('slot_end'),
                        'alt_day1' => $this->request->getPost('alt_day1'),
                        'alt_start1' => $this->request->getPost('alt_start1'),
                        'alt_end1' => $this->request->getPost('alt_end1'),
                    ];

                    if ($pickupModel->save($pickupData)) {
                        session()->setFlashdata('message', 'Your bid has been successfully submitted.');
                        return redirect()->to('sys/thankYou');
                    }
                }
            }

// Include $item_id in the data array passed to the view

            echo view('sys/header');
            echo view('sys/menu_' . $userType);
            echo view('sys/bidding_form', $data);
            echo view('sys/footer');
        }
    }

    public function withdrawBid($bid_id) {
        helper(['form', 'url']);

        $biddingModel = new BiddingModel();

// Retrieve the bid based on bid_id
        $bid = $biddingModel->find($bid_id);

        if (!$bid) {
            session()->setFlashdata('message', 'Bid not found.');
            return redirect()->to('sys/dashboard'); // Ensure this points to your actual dashboard route
        }

// Update the bid status to "Bid withdrawn"
        $updateData = [
            'bid_status_g' => 'Withdrew',
            'bid_status_c' => 'Withdrew'
        ];

        if ($biddingModel->update($bid_id, $updateData)) {
            session()->setFlashdata('message', 'Bid withdrawing successful.');
        } else {
            session()->setFlashdata('message', 'Failed to withdraw the bid.');
        }

        return redirect()->to('sys/dashboard'); // Adjust the redirect path to your actual dashboard view
    }

    public function viewBidsewc($item_id) {
        $session = session();
        $UserId = $session->get('UserId'); // Get user ID from session
        $user_type = strtolower($session->get('UserType')); // Assuming UserType is stored in session

        $biddingModel = new BiddingModel(); // Ensure this model is loaded either here or automatically via the constructor
        // Fetch data from the model
        $data['bids'] = $biddingModel->getDetailedListings($UserId, $item_id);
        $data['item_id'] = $item_id;

        // Load views with data
        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/view_one_bid', $data);
        echo view('sys/footer');
    }

    public function viewAllBidsForUser() {
        helper(['form', 'url']);

        $session = session();
        $userId = $session->get('UserId');
        $user_type = strtolower($session->get('UserType'));

        $biddingModel = new \App\Models\BiddingModel();
        $pickupModel = new \App\Models\PickupModel(); // Assuming you have this model for handling pickup_details
// Adjust the select() to properly join with the pickup_details table and fetch the required fields
        $bids = $biddingModel
                ->select('bids.*, ewaste_listings.item_title AS item_title, user.UserName AS seller_name, 
                      pickup_details.pref_day, pickup_details.slot_start, pickup_details.slot_end, 
                      pickup_details.alt_day1, pickup_details.alt_start1, pickup_details.alt_end1')
                ->join('ewaste_listings', 'ewaste_listings.item_id = bids.item_id', 'left')
                ->join('user', 'user.UserId = ewaste_listings.UserId', 'left')
                ->join('pickup_details', 'pickup_details.bid_id = bids.bid_id', 'left') // Correct join for pickup details
                ->where('bids.UserId', $userId)
                ->findAll();

        $data = [
            'bids' => $bids,
            'item_id' => null
        ];

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/view_all_bids', $data);
        echo view('sys/footer');
    }

    /*
     * 
     * public function viewBids($item_id) {
      helper(['url', 'form']);

      $data = [];
      $biddingModel = new \App\Models\BiddingModel();
      $pickupModel = new \App\Models\PickupModel();
      $userModel = new \App\Models\UserModel();
      $ewasteListingModel = new \App\Models\EwasteListModel();
      $user_type = strtolower(session()->get('UserType'));

      // Fetch bids and item status
      $bids = $biddingModel->where('item_id', $item_id)->findAll();
      $itemStatus = $ewasteListingModel->where('item_id', $item_id)->first()['item_status_g'];

      // Process bids
      foreach ($bids as $key => $bid) {
      $pickupDetails = $pickupModel->where('bid_id', $bid['bid_id'])->first();
      $bidder = $userModel->find($bid['UserId']);
      $collectorModel = new \App\Models\EwasteCollectorModel();
      $collector = $collectorModel->where('UserId', $bid['UserId'])->first();
      $businessName = $collector ? $collector['businessName'] : ($bidder['UserName'] ?? 'Unknown');

      $bids[$key]['pickupDetails'] = $pickupDetails;
      $bids[$key]['bidderName'] = $businessName;
      $bids[$key]['current_status'] = $bid['bid_status_g'];
      }

      $data['bids'] = $bids;
      $data['item_id'] = $item_id;
      $data['item_status'] = $itemStatus;
      $data['ewasteListingModel'] = $ewasteListingModel; // Pass the model to the view
      // Load views
      echo view('sys/header');
      echo view('sys/menu_' . $user_type);
      echo view('sys/view_bids', $data);
      echo view('sys/footer');
      } */

    public function viewBidsEwg($item_id) {
        $biddingModel = new BiddingModel();
        $session = session();

        $user_type = strtolower($session->get('UserType'));

        $data['bids'] = $biddingModel->getBidsEwg($item_id);
        $data['item_id'] = $item_id;

        if (empty($data['bids'])) {
            // Optionally handle the case where no bids are found
            $session->setFlashdata('error', 'No bids found for this item.');
        }

        // Load views with data
        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/view_bids_ewg', $data);
        echo view('sys/footer');
    }

    public function acceptBid() {
        $biddingModel = new \App\Models\BiddingModel();
        $ewasteListingModel = new \App\Models\EwasteListModel();
        $pickupModel = new \App\Models\PickupModel();

        $acceptedBidId = $this->request->getPost('bid_id');
        $item_id = $this->request->getPost('item_id');
        $day_selection = $this->request->getPost('day_selection');

        // Basic validation
        if (empty($acceptedBidId) || empty($item_id) || empty($day_selection)) {
            return redirect()->back()->with('error', 'Missing required information.');
        }

        // Update the day selection status
        $updateDayData = [
            'is_pref_day_selected' => ($day_selection === 'pref_day'),
            'is_alt_day1_selected' => ($day_selection === 'alt_day1'),
        ];
        $pickupModel->where('bid_id', $acceptedBidId)->set($updateDayData)->update();

        // Update the status of the accepted bid to 'Accepted'
        $biddingModel->update($acceptedBidId, [
            'bid_status_g' => 'Accepted',
            'bid_status_c' => 'Accepted'
        ]);

        // Reject all other bids for the same item
        $biddingModel->where('item_id', $item_id)
                ->where('bid_id !=', $acceptedBidId)
                ->set([
                    'bid_status_g' => 'Rejected',
                    'bid_status_c' => 'Rejected',
                    'rejection_reason' => 'Sold Out'
                ])->update();

        // Update the e-waste listing with the new status
        $ewasteListingModel->update($item_id, [
            'item_status_g' => 'Accepted'
        ]);

        // Redirect to the bids view with updated information
        return redirect()->to('sys/viewBids/' . $item_id)->with('message', 'Bid accepted successfully. Other bids have been rejected.');
    }

    public function rejectBid($bidId) {
        $biddingModel = new \App\Models\BiddingModel();

        $rejectionReason = $this->request->getPost('reject_reason');
        $item_id = $this->request->getPost('item_id'); // Make sure to capture the item_id

        $data = [
            'bid_status_g' => 'Rejected',
            'bid_status_c' => 'Rejected',
            'rejection_reason' => $rejectionReason
        ];

        $biddingModel->update($bidId, $data);

// Ensure item_id is included in the redirect URL
        return redirect()->to('sys/viewBids/' . $item_id);
    }

    /*     public function cancelDeal() {
      $userId = session()->get('UserId');
      $item_id = $this->request->getPost('item_id');
      $biddingModel = new \App\Models\BiddingModel();
      $notificationModel = new \App\Models\NotificationModel();

      // Update the bid status
      $biddingModel->update($this->request->getPost('bid_id'), [
      'bid_status_g' => 'Cancel',
      'bid_status_c' => 'Cancel'
      ]);

      return $this->viewBids($item_id);



      // Create a notification
      $notificationMessage = "Deal on item ID {$itemId} was cancelled by EWG.";
      $notificationModel->addNotification($bid['UserId'], $itemId, $notificationMessage);

      $data['message'] = 'Deal canceled successfully. Listing is now open for bidding.';
      } else {
      $data['error'] = 'Error cancelling deal. No such bid found.';
      }

      // Load the view with the message or error
      } */

    public function cancelDeal($bid_id) {
        helper(['form', 'url']);

        $biddingModel = new \App\Models\BiddingModel();
        $ewasteListModel = new \App\Models\EwasteListModel();

        $bid = $biddingModel->find($bid_id);

        if (!$bid) {
            session()->setFlashdata('message', 'Bid not found.');
            return redirect()->to('sys/dashboard');
        }

        // Update bid status to "Cancelled"
        $updateData = [
            'bid_status_g' => 'Cancelled', // General status for generator view
            'bid_status_c' => 'Cancelled'  // Specific status for collector view
        ];

        if ($biddingModel->update($bid_id, $updateData)) {
            // Also update the associated item status in ewaste_list table
            $itemUpdateData = [
                'item_status_g' => 'Cancelled', // General status for generator view
                'item_status_c' => 'Cancelled'  // Specific status for collector view
            ];
            $ewasteListModel->update($bid['item_id'], $itemUpdateData);

            session()->setFlashdata('message', 'Bid cancellation successful.');
        } else {
            session()->setFlashdata('message', 'Failed to cancel the bid.');
        }

        return redirect()->to('sys/dashboard');
    }

    public function cancelDealEwg() {
        helper(['form', 'url']);

        $biddingModel = new \App\Models\BiddingModel();
        $ewasteListModel = new \App\Models\EwasteListModel();
        $bid_id = $this->request->getPost('bid_id');
        $bid = $biddingModel->find($bid_id);

        if (!$bid) {
            session()->setFlashdata('message', 'Bid not found.');
            return redirect()->to('sys/dashboard');
        }

        // Update bid status to "Cancelled"
        $updateData = [
            'bid_status_g' => 'Cancelled',
            'bid_status_c' => 'Cancelled'
        ];

        if ($biddingModel->update($bid_id, $updateData)) {
            // Also update the associated item status in ewaste_list table
            $itemUpdateData = [
                'item_status_g' => 'Cancelled',
                'item_status_c' => 'Cancelled',
                'cancelled_by_ewg' => '1'
            ];
            $ewasteListModel->update($bid['item_id'], $itemUpdateData);

            session()->setFlashdata('message', 'Bid cancellation successful.');
        } else {
            session()->setFlashdata('message', 'Failed to cancel the bid.');
        }

        return redirect()->to('sys/dashboard');
    }

    public function cancelDealEwc($bid_id) {
        helper(['form', 'url']);

        $biddingModel = new \App\Models\BiddingModel();
        $ewasteListModel = new \App\Models\EwasteListModel();

        $bid = $biddingModel->find($bid_id);

        if (!$bid) {
            session()->setFlashdata('message', 'Bid not found.');
            return redirect()->to('sys/dashboard');
        }


        $updateData = [
            'bid_status_g' => 'Cancelled',
            'bid_status_c' => 'Cancelled'
        ];

        if ($biddingModel->update($bid_id, $updateData)) {
            // Also update the associated item status in ewaste_list table
            $itemUpdateData = [
                'item_status_g' => 'Cancelled',
                'item_status_c' => 'Cancelled',
                'cancelled_by_ewc' => '1'
            ];
            $ewasteListModel->update($bid['item_id'], $itemUpdateData);

            session()->setFlashdata('message', 'Bid cancellation successful.');
        } else {
            session()->setFlashdata('message', 'Failed to cancel the bid.');
        }

        return redirect()->to('sys/dashboard');
    }

    public function editListing($item_id) {
        helper(['form', 'url']);
        $ewasteModel = new \App\Models\EwasteListModel();
        $biddingModel = new \App\Models\BiddingModel(); // Make sure this model is created and has the necessary methods
        $notificationModel = new \App\Models\NotificationModel();
        $userId = session()->get('UserId');

        $listing = $ewasteModel->find($item_id);

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'item_title' => 'required',
                'item_description' => 'required',
                'quantity' => 'required|numeric',
                'weight' => 'required|numeric',
                'price_option' => 'required|in_list[free,expected]',
                'amount' => 'permit_empty|numeric',
                'pickup_location' => 'required',
                'google_location' => 'permit_empty|valid_url',
                'contact_name' => 'required',
                'contact_number' => 'required|min_length[10]|max_length[15]',
                    // Add any additional rules for other fields you have in your form
            ];

            if ($this->validate($rules)) {
                $updateData = [
                    'item_title' => $this->request->getPost('item_title'),
                    'item_description' => $this->request->getPost('item_description'),
                    'quantity' => $this->request->getPost('quantity'),
                    'weight' => $this->request->getPost('weight'),
                    'price_option' => $this->request->getPost('price_option'),
                    'amount' => $this->request->getPost('amount'),
                    'pickup_location' => $this->request->getPost('pickup_location'),
                    'google_location' => $this->request->getPost('google_location'),
                    'contact_name' => $this->request->getPost('contact_name'),
                    'contact_number' => $this->request->getPost('contact_number'),
                        // Add any additional fields you are updating
                ];

                $ewasteModel->update($item_id, $updateData);

// Notify bidders of the update, if any
                $existingBids = $biddingModel->where('item_id', $item_id)->findAll();
                if ($existingBids) {
                    foreach ($existingBids as $bid) {
                        if ($bid['UserId'] != $userId) {
                            $notificationMessage = "Listing #" . $item_id . " has been updated. Please review the changes.";
                            $notificationModel->addNotification($bid['UserId'], $item_id, $notificationMessage);
                        }
                    }
                }

// Update the listing to indicate it has been edited
                $ewasteModel->update($item_id, ['is_edited' => 1]);

                session()->setFlashdata('message', 'Listing updated successfully.');
// Redirect to the detailed view of the updated listing
                return redirect()->to('/sys/detailedViewEwg/' . $item_id);
            } else {
                $data['validation'] = $this->validator;
            }
        }

        $data['listing'] = $listing;
        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/edit_listing', $data);
        echo view('sys/footer');
    }

// Controller Method: Delete Listing
    public function deleteListing($item_id) {
        $ewasteModel = new \App\Models\EwasteListModel();
        $biddingModel = new \App\Models\BiddingModel();
        $notificationModel = new \App\Models\NotificationModel();
        $userId = session()->get('UserId');

// Mark the listing as 'Deleted'
        $ewasteModel->update($item_id, ['item_status_g' => 'Deleted', 'item_status_c' => 'Deleted']);

        $bids = $biddingModel->where('item_id', $item_id)->findAll();
        foreach ($bids as $bid) {
// Fetch original bid status for conditional notification
            $originalBidStatus = $bid['bid_status_g'];

// Update bid statuses to 'Item Deleted by EWG'
            $biddingModel->update($bid['bid_id'], ['bid_status_c' => 'Deleted', 'bid_status_g' => 'Deleted']);

            if ($bid['UserId'] != $userId) {
// Notification message based on bid status
                $notificationMessage = $originalBidStatus === 'Accepted' ? "Your Deal was cancelled. Listing #{$item_id} has been deleted by EWG." : "Listing #{$item_id} has been deleted by EWG.";
                $notificationModel->addNotification($bid['UserId'], $item_id, $notificationMessage);
            }
        }

        session()->setFlashdata('message', 'Your listing was deleted.');
        return redirect()->to('/sys/thankYou');
    }

    public function viewBidsOneItem($item_id) {
        helper(['url', 'form']);

        $data = [];
        $biddingModel = new \App\Models\BiddingModel();
        $ewcUserId = session()->get('UserId'); // EWC's User ID from session
        $user_type = strtolower(session()->get('UserType'));

        $ewasteListingModel = new \App\Models\EwasteListModel();
        $item = $ewasteListingModel->where('item_id', $item_id)
                ->where('UserId', $ewcUserId)
                ->first();

        if (!$item) {
// If item not found or access denied, redirect with error message
            return redirect()->to('/dashboard')->with('error', 'Item not found or access denied.');
        }

// Fetch all bids for the item
        $bids = $biddingModel->where('item_id', $item_id)->findAll();

// Add necessary data to the $data array
        $data['item_id'] = $item_id; // Ensuring item_id is set
        $data['bids'] = $bids; // Ensuring bids are set
        $data['item'] = $item; // Item details

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/view_bids', $data); // Pass the $data array to the view
        echo view('sys/footer');
    }

    public function view_sample_reports() {
        helper(['form']);

        $user_type = strtolower(session()->get('UserType'));
        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/reports');
        echo view('sys/footer');
    }

    public function view_reports() {
        helper(['form']);

        $user_type = strtolower(session()->get('UserType'));
        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
//echo view('sys/reports');
        echo view('sys/report_' . $user_type);
        echo view('sys/footer');
    }

    public function ewgListings0() {
        $model = new EwasteListModel();
        $userId = session()->get('UserId');
        $year = $this->request->getPost('year') ?? date('Y');
        $month = $this->request->getPost('month');

        $data = [
            'selectedYear' => $year,
            'selectedMonth' => $month,
            'listings' => $model->monthlyListings($userId, $year, $month),
            'summary' => $model->getSummary($userId, $year, $month)
        ];

        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/ewg_monthly_listings', $data);
        echo view('sys/footer');
    }

    public function ewgListings() {
        $model = new EwasteListModel();
        $userId = session()->get('UserId');
        $year = $this->request->getPost('year') ?? date('Y');
        $month = $this->request->getPost('month');

        $data = [
            'selectedYear' => $year,
            'selectedMonth' => $month,
            'listings' => $model->monthlyListings($userId, $year, $month)
        ];

        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/ewg_listings_summary_1', $data);
        echo view('sys/footer');
    }

    public function ewgBids0() {
        $model = new \App\Models\BiddingModel();
        $session = session();
        $userId = $session->get('UserId');
        $user_type = strtolower(session()->get('UserType'));
        $year = $this->request->getPost('year') ?? date('Y');
        $month = $this->request->getPost('month');

        $data = [
            'selectedYear' => $year,
            'selectedMonth' => $month,
            'bidSummary' => $model->getBidSummary($userId, $year, $month),
            'rejectionReasons' => $model->getRejReasons($userId, $year, $month)
        ];

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/ewg_bid_analysis', $data);
        echo view('sys/footer');
    }

    public function ewgBids() {
        $model = new \App\Models\BiddingModel();
        $session = session();
        $userId = $session->get('UserId');
        $user_type = strtolower(session()->get('UserType'));
        $year = $this->request->getPost('year') ?? date('Y');
        $month = $this->request->getPost('month');

        $data = [
            'selectedYear' => $year,
            'selectedMonth' => $month,
            'bidSummary' => $model->getBidSummary($userId, $year, $month),
        ];

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/ewg_bid_analysis_1', $data);
        echo view('sys/footer');
    }

    public function ewgIncome0() {
        $biddingModel = new BiddingModel();
        $session = session();
        $userId = $session->get('UserId');
        $user_type = strtolower(session()->get('UserType'));

        $year = $this->request->getPost('year') ?? date('Y');
        $month = $this->request->getPost('month');

        $data = [
            'selectedYear' => $year,
            'selectedMonth' => $month,
            'incomeReport' => $biddingModel->getIncome($userId, $year, $month)
        ];

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/ewg_income_report', $data);
        echo view('sys/footer');
    }

    public function ewgIncome() {
        $biddingModel = new BiddingModel();
        $session = session();
        $userId = $session->get('UserId');
        $user_type = strtolower($session->get('UserType'));

        $year = $this->request->getPost('year') ?? date('Y');
        $month = $this->request->getPost('month');

        $incomeReport = [];
        if (!empty($month)) {
            $incomeReport = $biddingModel->getIncome($userId, $year, $month);
        }

        $data = [
            'selectedYear' => $year,
            'selectedMonth' => $month,
            'incomeReport' => $incomeReport
        ];

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/ewg_income_report_2', $data);
        echo view('sys/footer');
    }

    public function ewcCollections() {
        $session = session();
        $biddingModel = new BiddingModel();
        $UserId = $session->get('UserId');
        $user_type = strtolower(session()->get('UserType'));

        $year = $this->request->getPost('year') ?? date('Y');
        $month = $this->request->getPost('month');

        $data = [
            'selectedYear' => $year,
            'selectedMonth' => $month,
            'collectionsInfo' => $biddingModel->getEwcCollections($UserId, $year, $month)
        ];

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/ewc_collections', $data);
        echo view('sys/footer');
    }

    public function ewcTransactions() {
        $inventoryModel = new \App\Models\EwcInventoryModel();
        $session = session();
        $userId = $session->get('UserId');
        $user_type = strtolower($session->get('UserType'));

        $year = $this->request->getPost('year') ?? date('Y');
        $month = $this->request->getPost('month');

        $summary = $inventoryModel->getEwcTransactions($userId, $year, $month);

        $transactions = $inventoryModel->getEwcTCount($userId, $year, $month);
        $data['selectedYear'] = $year;
        $data['selectedMonth'] = $month;
        $data['transactions'] = $transactions;
        $data['transactionAnalysis'] = [
            'selectedYear' => $year,
            'selectedMonth' => $month,
            'transactionsProcessed' => $summary,
            'methods' => $summary
        ];

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/ewc_transactions', $data);
        echo view('sys/footer');
    }

    public function EwrRequests() {
        $requestModel = new EwrRequestModel();
        $session = session();
        $userId = $session->get('UserId');
        $userType = strtolower($session->get('UserType'));

        $year = $this->request->getPost('year') ?? date('Y');
        $month = $this->request->getPost('month');

        $data = [
            'selectedYear' => $year,
            'selectedMonth' => $month,
            'requestSummary' => $requestModel->getRequestSummary($userId, $year, $month),
            'rejectionReasons' => $requestModel->getRejectionReasons($userId, $year, $month)
        ];

        echo view('sys/header');
        echo view('sys/menu_' . $userType);
        echo view('sys/ewr_requests', $data);
        echo view('sys/footer');
    }

    public function EwrCollections() {
        $inventoryModel = new \App\Models\EwrInventoryModel();
        $session = session();
        $userId = $session->get('UserId');
        $user_type = strtolower($session->get('UserType'));

        $year = $this->request->getPost('year');
        $month = $this->request->getPost('month');
        $selectedDistrict = $this->request->getPost('district');

        $data = [
            'selectedYear' => $year,
            'selectedMonth' => $month,
            'selectedDistrict' => $selectedDistrict,
            'collectionActivities' => $inventoryModel->getCollectionActivity($userId, $year, $month, $selectedDistrict),
        ];

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/ewr_collections', $data);
        echo view('sys/footer');
    }

    public function EwrRecycling() {

        $session = session();
        $userId = $session->get('UserId');
        $user_type = strtolower(session()->get('UserType'));

        $ewrInventoryModel = new EwrInventoryModel();
        $recycledMaterialsModel = new RecycledMaterialsModel();

        $data = [
            'selectedYear' => date('Y'), // Default to current year
            'selectedMonth' => date('m'), // Default to current month
            'inventorySummary' => [],
            'recycledSummary' => []
        ];

        if ($this->request->getMethod() === 'post') {
            $data['selectedYear'] = $this->request->getPost('year');
            $data['selectedMonth'] = $this->request->getPost('month');

// Get inventory data
            $data['inventorySummary'] = $ewrInventoryModel->getMonthlyInventorySummary($userId, $data['selectedYear'], $data['selectedMonth']);

// Get recycled materials data
            $data['recycledSummary'] = $recycledMaterialsModel->getMonthlyRecycledSummary($data['selectedYear'], $data['selectedMonth']);
        }

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/ewr_recycling', $data);
        echo view('sys/footer');
    }

    public function view_reports1() {
        helper(['form', 'url']);
        echo view('sys/header');
        echo view('sys/menu');
        echo view('sys/e_waste_category_distribution');
        echo view('sys/footer');
    }

    public function ewcPurchases() {
        helper(['form', 'url']);
        $session = session();
        $userId = $session->get('UserId');
        $user_type = strtolower(session()->get('UserType'));
    }

    public function ewcBidAnalysis() {
        helper(['form', 'url']);
        $session = session();
        $userId = $session->get('UserId');
        $user_type = strtolower(session()->get('UserType'));
        $data = [
            'selectedYear' => $this->request->getPost('year') ?? date('Y'),
            'selectedMonth' => $this->request->getPost('month') ?? null, // Changed to null for the option of an annual overview
        ];

        $biddingModel = new \App\Models\BiddingModel();
// Fetch bid summary and rejection reasons based on selected year and, optionally, month
        $data['bidSummary'] = $biddingModel->getBidSummary1($userId, $data['selectedYear'], $data['selectedMonth']);
        $data['rejectionReasons'] = $biddingModel->getRejectionReasons1($userId, $data['selectedYear'], $data['selectedMonth']);

// Prepare additional view data
        $data['selectedMonthName'] = $data['selectedMonth'] ? date('F', mktime(0, 0, 0, $data['selectedMonth'], 10)) : null;

// Load views with the prepared data
        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/ewc_bid_analysis', $data);
        echo view('sys/footer');
    }

    public function viewColForm($item_id) {
        helper(['form', 'url']); // Load the form and URL helpers

        $ewasteModel = new \App\Models\EwasteListModel();
        $biddingModel = new \App\Models\BiddingModel();
        $ewasteGeneratorModel = new \App\Models\EwasteGeneratorModel();

        $item = $ewasteModel->find($item_id);
        $biddingInfo = $biddingModel->where(['item_id' => $item_id, 'bid_status_c' => 'Accepted'])->first();

        if (!$item) {
            return redirect()->to('sys/dashboard')->with('error', 'Invalid item ID.');
        }

// Convert the object to an array for easier manipulation
        $itemData = (array) $item;

// Check if description exists in item data and assign it
        $itemData['description'] = $itemData['item_description'] ?? 'No description available';

// If bidding info is available, merge it with item data
        if ($biddingInfo) {
            $itemData['bid_price_per_item'] = $biddingInfo['bid_price_per_item'];
            $itemData['quantity'] = $biddingInfo['quantity'];
            $itemData['payment_method'] = $biddingInfo['payment_method'];
        } else {
// Default values if no biddingInfo is found
            $itemData['bid_price_per_item'] = 0;
            $itemData['quantity'] = 0;
            $itemData['payment_method'] = 'N/A'; // Or any default value you see fit
        }

// Fetch bank details if payment method is 'bank_deposit'
        $bankInfo = [];
        if ($itemData['payment_method'] === 'bank_deposit') {
            $bankInfo = $ewasteGeneratorModel->where('UserId', $item['UserId'])->first();
        }

        $user_type = strtolower(session()->get('UserType'));

// Prepare the data array to be passed to the view
        $data = [
            'item' => $itemData,
            'bankInfo' => $bankInfo,
        ];

// Render the views and pass the data
        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/collection_form', $data);
        echo view('sys/footer');
    }

    public function submitInventoryUpdate() {
        helper(['form', 'url']);
        $session = session();
        $userId = $session->get('UserId');
        $inventoryModel = new \App\Models\EwcInventoryModel();

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'quantity' => 'required|numeric',
                'weight' => 'required|numeric',
                'weight_unit' => 'required|in_list[g,kg]',
                'description' => 'required',
                'item_id' => 'required|is_numeric',
                'total_payment' => 'required|numeric',
                'payment_method' => 'required',
                'bank_slip' => 'permit_empty|uploaded[bank_slip]|mime_in[bank_slip,image/jpg,image/jpeg,image/png]|max_size[bank_slip,2048]'
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {

                $bankSlipName = '';
                if ($this->request->getPost('payment_method') === 'bank_deposit') {
                    $file = $this->request->getFile('bank_slip');
                    if ($file && $file->isValid() && !$file->hasMoved()) {
                        $newName = $file->getRandomName();
                        $file->move('public/images/uploads', $newName);
                        $bankSlipName = 'images/uploads/' . $newName;
                    }
                }

                $newData = [
                    'UserId' => session()->get('UserId'),
                    'item_id' => $this->request->getPost('item_id'),
                    'item_name' => $this->request->getPost('item_name'),
                    'item_type' => $this->request->getPost('item_type'),
                    'item_image' => $this->request->getPost('item_image'),
                    'quantity' => $this->request->getPost('quantity'),
                    'weight' => $this->request->getPost('weight'),
                    'weight_unit' => $this->request->getPost('weight_unit'),
                    'description' => $this->request->getPost('description'),
                    'total_payment' => $this->request->getPost('total_payment'),
                    'payment_method' => $this->request->getPost('payment_method'),
                    'bank_slip' => $bankSlipName,
                    'date_collected' => date("Y-m-d"),
                ];

                if ($inventoryModel->save($newData)) {
                    $newdata = [
                        'collection_status' => 'Collected',
                        'collector_id' => $userId
                    ];
                    $listingsModel = new \App\Models\EwasteListModel();
                    $listingsModel->update($this->request->getPost('item_id'), $newdata);

                    $bidModel = new \App\Models\BiddingModel();

// Fetch the bid IDs for all bids with 'Accepted' status for the given item_id
                    $acceptedBids = $bidModel->where('item_id', $this->request->getPost('item_id'))
                            ->where('bid_status_c', 'Accepted')
                            ->findAll();

// Update each bid individually
                    foreach ($acceptedBids as $bid) {
                        $bidModel->update($bid['bid_id'], ['bid_status_later' => 'Collected']);
                    }

                    return redirect()->to('sys/thankYou')->with('message', 'Inventory updated successfully.');
                } else {
                    return redirect()->back()->withInput()->with('error', 'Failed to update inventory.');
                }
            }
// Render the views and pass the data
            echo view('sys/header');
            echo view('sys/menu_' . strtolower(session()->get('UserType')));
            echo view('sys/collection_form', $data);
            echo view('sys/footer');
        }
    }

    public function viewEwcInventorySubs() {
        helper('form');
        $inventoryModel = new \App\Models\EwcInventoryModel();
        $userId = session()->get('UserId');
        $inventoryItems = $inventoryModel->where('UserId', $userId)->findAll();
        $data['inventoryItems'] = $inventoryItems;
        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/ewc_inventory_all', $data);
        echo view('sys/footer');
    }

    public function viewEwcInventory() {
        helper('form');
        $inventoryModel = new \App\Models\EwcInventoryModel();
        $userId = session()->get('UserId');
        $inventoryItems = $inventoryModel->where('UserId', $userId)->findAll();
        $data['inventoryItems'] = $inventoryItems; // Add inventory items to the data array
        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/ewc_inventory', $data); // Pass the data array to the view
        echo view('sys/footer');
    }

    public function viewEwcInventoryGra0() {
        helper('form');
        $inventoryModel = new \App\Models\EwcInventoryModel();

        $inventoryItems = $inventoryModel->where('UserId', '')->findAll();
        $data['inventoryItems'] = $inventoryItems; // Add inventory items to the data array
        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/ewc_inventory', $data); // Pass the data array to the view
        echo view('sys/footer');
    }

    public function viewEwcInventoryGra() {
        helper('form');
        $inventoryModel = new \App\Models\EwcInventoryModel();

        // Fetch all inventory items without considering UserId
        $inventoryItems = $inventoryModel->findAll();
        $data['inventoryItems'] = $inventoryItems; // Add inventory items to the data array

        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/ewc_inventory', $data); // Pass the data array to the view
        echo view('sys/footer');
    }

    public function listByEwc() {
        helper('form');
        $inventoryModel = new \App\Models\EwcInventoryModel();
        $userId = session()->get('UserId');
        $inventoryItems = $inventoryModel->where('UserId', $userId)->where('list_status_c', 'not published')->findAll();
        $data['inventoryItems'] = $inventoryItems; // Add inventory items to the data array
        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/ewc_list_inventory', $data); // Pass the data array to the view
        echo view('sys/footer');
    }

    public function filter() {
        helper(['form']);
        $userId = session()->get('UserId');

        $itemType = $this->request->getPost('item_type', null);
        $minCost = $this->request->getPost('min_cost', null);
        $maxCost = $this->request->getPost('max_cost', null);

        $inventoryModel = new \App\Models\EwcInventoryModel();
        $data['inventoryItems'] = $inventoryModel->filterInventory($userId, $itemType, $minCost, $maxCost);

        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/ewc_list_inventory', $data);
        echo view('sys/footer');
    }

    public function calculateSellingPrice() {
        helper(['form']);
        $model = new \App\Models\EwcInventoryModel();

        // Retrieve selected items and profit percentage from the form
        $selectedItemIDs = $this->request->getPost('selected_items') ?? [];
        $profitPercentage = $this->request->getPost('profit_percentage');

        if (!$selectedItemIDs || !$profitPercentage) {
            // Handle error or set flashdata for notification
            return redirect()->back()->with('error', 'Required data missing.');
        }

        // Bulk retrieve items from the database
        $items = $model->find($selectedItemIDs);
        $totalCost = array_sum(array_column($items, 'total_payment'));

        // Calculate total profit and selling price
        $profit = $totalCost * ($profitPercentage / 100);
        $sellingPrice = ceil(($totalCost + $profit) / 100) * 100;

        // Prepare data for the view
        $data = [
            'inventoryItems' => $items,
            'selectedItemIDs' => $selectedItemIDs,
            'calculatedSellingPrice' => $sellingPrice
        ];

        // Load views
        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/ewc_list_inventory', $data);
        echo view('sys/footer');
    }

    public function publishSet() {
        helper(['form', 'url']);

        $inventoryModel = new \App\Models\EwcInventoryModel();
        $listingsModel = new \App\Models\EwcListingsModel();
        $userModel = new \App\Models\UserModel();

        // Retrieve form data
        $selectedItems = $this->request->getPost('selected_items');
        $listingTitle = $this->request->getPost('listing_title');
        $profitPercentage = (float) $this->request->getPost('profit_percentage');
        $pickupLocation = $this->request->getPost('pickup_location');
        $googleLocation = $this->request->getPost('google_location');
        $contactName = $this->request->getPost('contact_name');
        $contactNumber = $this->request->getPost('contact_number');
        $dateAdded = date('Y-m-d');
        $timeAdded = date('H:i:s');
        $userId = session()->get('UserId');

        if (empty($selectedItems) || empty($listingTitle) || is_null($profitPercentage)) {
            return redirect()->back()->with('error', 'All fields including selected items, listing title, and profit percentage are required.');
        }

        $totalCost = 0;
        $itemsDetails = [];
        foreach ($selectedItems as $inventoryNumber) {
            $item = $inventoryModel->find($inventoryNumber);
            if ($item) {
                $totalCost += (float) $item['total_payment'];
                $itemsDetails[] = $item;
            }
        }

        if (empty($itemsDetails)) {
            return redirect()->back()->with('error', 'No valid items found for publishing.');
        }

        $sellingPrice = ceil(($totalCost + ($totalCost * $profitPercentage / 100)) / 100) * 100;
        $collector = $userModel->find($userId);
        $collectorName = $collector ? $collector['UserName'] : 'Unknown Collector';
        $listingSet = time() . '-' . $userId;

        foreach ($itemsDetails as $item) {
            $data = [
                'ewc_listing_title' => $listingTitle,
                'listing_set' => $listingSet,
                'collector_name' => $collectorName,
                'item_name' => $item['item_name'],
                'item_type' => $item['item_type'],
                'item_image' => $item['item_image'],
                'quantity' => $item['quantity'],
                'weight' => $item['weight'],
                'description' => $item['description'],
                'selling_price' => $sellingPrice,
                'weight_unit' => $item['weight_unit'],
                'list_status_r' => 'available',
                'list_status_c' => 'published',
                'item_id' => $item['item_id'],
                'UserId' => $userId,
                'inventory_number' => $item['inventory_number'],
                'pickup_location' => $pickupLocation,
                'google_location' => $googleLocation,
                'contact_name' => $contactName,
                'contact_number' => $contactNumber,
                'date_added' => $dateAdded,
                'time_added' => $timeAdded
            ];

            $listingsModel->insert($data);
            $inventoryModel->update($item['inventory_number'], ['list_status_c' => 'published']);
        }

        return redirect()->to('sys/thankYou')->with('message', "Items published successfully with a total selling price of $sellingPrice and listing set: $listingSet.");
    }

    /* public function viewEwcListings() {
      $listingsModel = new \App\Models\EwcListingsModel();
      $ewasterequestModel = new \App\Models\EwrRequestModel();

      $userId = session()->get('UserId');
      $listings = $listingsModel->getListingsToEwc($userId);

      $groupedListings = [];
      $displayedItems = []; // Tracker for displayed items

      foreach ($listings as $listing) {
      $listingSet = $listing['listing_set'];
      if (!isset($groupedListings[$listingSet])) {
      $groupedListings[$listingSet] = [
      'details' => [],
      'req_status_c' => $listing['req_status_c'],
      'collector_name' => $listing['collector_name'],
      'date_added' => $listing['date_added'],
      'time_added' => $listing['time_added'],
      'ewc_listing_title' => $listing['ewc_listing_title'],
      'item_count' => 0,
      ];
      }

      // Avoid displaying the same item multiple times
      $itemKey = $listing['ewc_listing_id']; // Unique identifier for each item
      if (!in_array($itemKey, $displayedItems)) {
      $groupedListings[$listingSet]['details'][] = $listing;
      $groupedListings[$listingSet]['item_count']++;
      $displayedItems[] = $itemKey; // Add to tracker
      }

      $requestStatus = $ewasterequestModel->where('listing_set', $listingSet)->findAll();
      $groupedListings[$listingSet]['request_status'] = $requestStatus;
      }

      $userType = strtolower(session()->get('UserType'));

      echo view('sys/header');
      echo view('sys/menu_' . $userType);
      echo view('sys/ewc_listings', ['groupedListings' => $groupedListings]);
      echo view('sys/footer');
      } */

    public function viewEwcListings() {
        $listingsModel = new \App\Models\EwcListingsModel();
        $userId = session()->get('UserId');

        // Use the correct model instance variable
        $listings = $listingsModel->getListingsWithRequestStatus($userId);
        foreach ($listings as $key => $listing) {
            $listings[$key]['status'] = $listing['status'] ?? 'Published';  // Default to 'Published' if not set
        }

        $groupedListings = [];
        foreach ($listings as $listing) {
            $listingSet = $listing['listing_set'];
            if (!isset($groupedListings[$listingSet])) {
                $groupedListings[$listingSet] = [
                    'details' => [],
                    'collector_name' => $listing['collector_name'],
                    'date_added' => $listing['date_added'],
                    'time_added' => $listing['time_added'],
                    'ewc_listing_title' => $listing['ewc_listing_title'],
                    'item_count' => 0,
                    'status' => $listing['status']
                ];
            }
            $groupedListings[$listingSet]['details'][] = $listing;
            $groupedListings[$listingSet]['item_count']++;
        }


        $userType = strtolower(session()->get('UserType'));

        echo view('sys/header');
        echo view('sys/menu_' . $userType);
        echo view('sys/ewc_listings', ['groupedListings' => $groupedListings]);
        echo view('sys/footer');
    }

    /* public function viewListingSetItemsEwc($listingSet) {
      helper(['form', 'url']);
      $ListModel = new \App\Models\EwcListingsModel();
      $userId = session()->get('UserId');
      $user_type = strtolower(session()->get('UserType'));
      // Assuming you have a method to fetch the listing set details
      $Data['ListingSet'] = $ListModel->where('UserId', $userId)
      ->where('listing_set', $listingSet)
      ->first();

      $Data['Items'] = $ListModel->where('UserId', $userId)
      ->where('listing_set', $listingSet)
      ->findAll();

      // Load the view with items and listing set details
      echo view('sys/header');
      echo view('sys/menu_' . $user_type);
      echo view('sys/view_SetEwc', $Data);
      echo view('sys/footer');
      } */

    public function viewListingSetItemsEwc($listingSet) {
        helper(['form', 'url']);
        $ListModel = new \App\Models\EwcListingsModel();
        $userId = session()->get('UserId');
        $user_type = strtolower(session()->get('UserType'));

        // Fetching the items details
        $items = $ListModel->getListingDetailsAndItems($userId, $listingSet);

        // Assume the first item contains the set details
        $ListingSet = $items[0] ?? null;
        if (!$ListingSet) {
            // Handle case where no listings are found
            return view('sys/no_listing');
        }

        // Assuming status is a part of each item's data fetched and you want the status from the first item
        $status = $ListingSet['status'] ?? 'Published';  // Default status if not set

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/view_SetEwc', [
            'ListingSet' => $ListingSet,
            'Items' => $items,
            'status' => $status  // Passing status to the view
        ]);
        echo view('sys/footer');
    }

    public function viewListingSetItemsEwr($listingSet) {
        helper(['form', 'url']);
        $user_type = strtolower(session()->get('UserType'));

        $ewcListModel = new \App\Models\EwcListingsModel();
        $ewrRequestModel = new \App\Models\EwrRequestModel();

        $userId = session()->get('UserId');

// Fetch the details for the listing set
        $listingSetDetails = $ewcListModel->where('listing_set', $listingSet)->first();
        $items = $ewcListModel->where('listing_set', $listingSet)->findAll();

// Check for an existing request status for this user and listing set
        $requestStatus = $ewrRequestModel->where('listing_set', $listingSet)
                ->where('UserId', $userId)
                ->orderBy('ewr_req_id', 'desc')
                ->first();

// Determine the appropriate action based on the statuses
        $buttonAction = 'none'; // Default action when no specific condition is met
        if ($requestStatus && $requestStatus['req_status_r'] === 'accepted') {
            $buttonAction = 'collect';
        } elseif ($listingSetDetails && $listingSetDetails['list_status_r'] === 'accepted') {
            $buttonAction = 'Request';
        }

// Pass the data along with the determined action to the view
        $data = [
            'Items' => $items,
            'ListingSet' => $listingSetDetails,
            'ButtonAction' => $buttonAction, // This will control which button to display
            'requestStatus' => $requestStatus
        ];

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/view_SetEwr', $data);
        echo view('sys/footer');
    }

    public function displayRequestForm($listingSet) {
        helper(['form']);

        $data = [];
// Use EwcListingsModel to handle both listing sets and items within those sets
        $listingSetModel = new \App\Models\EwcListingsModel();

// Fetch the listing set details along with the associated items
        $data['ListingSet'] = $listingSetModel->where('listing_set', $listingSet)->first();
        $data['Items'] = $listingSetModel->where('listing_set', $listingSet)->findAll();
// Add listingSetId to the data array to be passed to the view
        $data['listingSet'] = $listingSet;

// Check if the listing set and items were successfully fetched
        if (!$data['ListingSet'] || empty($data['Items'])) {
// Handle cases where the listing set or items could not be found
            session()->setFlashdata('error', 'Listing set not found.');
            return redirect()->to('/path/to/redirect');
        }

        $user_type = strtolower(session()->get('UserType'));

// Load the views with the fetched data
        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/request_form', $data); // Adjust the path to your actual form view file
        echo view('sys/footer');
    }

    public function submitRequest() {
        helper(['form', 'url']);

        $rules = [
            'payment_method' => 'required|in_list[cash,bank_transfer]',
            'your_note' => 'permit_empty|string',
            'pref_day' => 'required',
            'slot_start' => 'required',
            'slot_end' => 'required',
            'alt_day' => 'permit_empty',
            'alt_start' => 'permit_empty',
            'alt_end' => 'permit_empty',
            'listing_set' => 'required'
        ];

        if ($this->validate($rules)) {
            $ewrRequestModel = new \App\Models\EwrRequestModel();

// Retrieve listing_set directly from the POST data
            $listing_set = $this->request->getPost('listing_set');

            $newData = [
                'listing_set' => $listing_set,
                'UserId' => session()->get('UserId'),
                'payment_method' => $this->request->getPost('payment_method'),
                'your_note' => $this->request->getPost('your_note'),
                'pref_day' => $this->request->getPost('pref_day'),
                'slot_start' => $this->request->getPost('slot_start'),
                'slot_end' => $this->request->getPost('slot_end'),
                'alt_day1' => $this->request->getPost('alt_day'),
                'alt_start1' => $this->request->getPost('alt_start'),
                'alt_end1' => $this->request->getPost('alt_end'),
                'req_status_c' => 'requested',
                'req_status_r' => 'requested',
                'req_made_at' => 'date("Y-m-d")'
            ];

            $ewrRequestModel->save($newData);

// Prepare data for the 'thank_you' view if needed
            //$data['message'] = 'Request submitted successfully!';
            //return view('web/thank_you', $data);
            return redirect()->to('sys/dashboard')->with('message', 'Request processed successfully.');
        } else {
// Prepare validation errors for the view
            $data['validation'] = $this->validator;

// Reload the form view with old input and validation errors
            return view('sys/displayRequestForm', $data);
        }
    }

    public function viewReqEwr($listingSetId = null) {
        $user_type = strtolower(session()->get('UserType'));
        $userId = session()->get('UserId');
        $ewrRequestModel = new \App\Models\EwrRequestModel();
        $collectorModel = new \App\Models\EwasteCollectorModel();
        $listingsModel = new \App\Models\EwcListingsModel();
// Fetch requests either for a specific listing set or all requests by the user
        $requests = $listingSetId !== null ?
                $ewrRequestModel->where('UserId', $userId)->where('listing_set', $listingSetId)->findAll() :
                $ewrRequestModel->where('UserId', $userId)->findAll();

        foreach ($requests as &$request) {
// Fetch the listing set to retrieve the UserId (collector_id)
            $listingSet = $listingsModel->where('listing_set', $request['listing_set'])->first();

            if ($listingSet) {
// Fetch collector details using UserId from ewc_listings
                $collectorDetails = $collectorModel->where('UserId', $listingSet['UserId'])->first();

// Add collector details to request
                $request['collectorDetails'] = $collectorDetails ? $collectorDetails : null;
            } else {
                $request['collectorDetails'] = null; // Handle cases where no collector details are found
            }
        }

// Pass the requests with collector details to the view
        $data['requests'] = $requests;
        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/sent_requests', $data); // Ensure this view exists and is correctly set up to display the data
        echo view('sys/footer');
    }

    public function viewReqEwc($listingSet = null) {

        helper(['form', 'url']);
        $userType = strtolower(session()->get('UserType'));

        $userId = session()->get('UserId'); // Assuming session stores UserId
        $ewrRequestModel = new \App\Models\EwrRequestModel();

// First, check if there are any accepted requests for the listing set
        $acceptedRequestExists = $ewrRequestModel->where('listing_set', $listingSet)
                ->where('req_status_c', 'accepted')
                ->first();

        $isAccepted = $acceptedRequestExists ? true : false;

// Fetching all requests for a specific listing set if $listingSetId is provided
        $requests = $listingSet !== null ?
                $ewrRequestModel->join('ewaste_recycler', 'ewaste_recycler.user_id=ewr_req.UserId', 'left')->where('listing_set', $listingSet)->findAll() :
                $ewrRequestModel->where('UserId', $userId)->findAll();

        $data = [
            'requests' => $requests,
            'listingSet' => $listingSet,
            'isAccepted' => $isAccepted, // Pass this variable to  view
        ];

        echo view('sys/header');
        echo view('sys/menu_' . $userType);
        echo view('sys/received_requests', $data); // Pass the data to view
        echo view('sys/footer');
    }

    /* public function viewReqEwc($listingSetId) {
      $ewrRequestModel = new \App\Models\EwrRequestModel();
      $requests = $ewrRequestModel->where('listing_set', $listingSetId)->findAll();

      $data = [
      'requests' => $requests,
      'listingSetId' => $listingSetId,
      ];

      return view('sys/recieved_requests', $data);
      } */

    public function ReqRespond() {
        helper(['form', 'url']);

        $ewrRequestModel = new \App\Models\EwrRequestModel();
        $ewcListModel = new \App\Models\EwcListingsModel();
        $requestId = $this->request->getPost('requestId');
        $listingSetId = $this->request->getPost('listing_set');
        $action = $this->request->getPost('action');

        if ($action == 'accept') {
            $acceptAction = $this->request->getPost('accept_action');
            $data = [
                'req_status_r' => 'accepted',
                'req_status_c' => 'accepted'
            ];

            if ($acceptAction == 'pref_day') {
                $data['pref_selection'] = 1;
                $data['alt_selection'] = 0;
            } elseif ($acceptAction == 'alt_day') {
                $data['alt_selection'] = 1;
                $data['pref_selection'] = 0;
            }

            // Update the specific request as accepted
            $ewrRequestModel->update($requestId, $data);

            // Update the listing status to 'Accepted'
            $ewcListModel->where('listing_set', $listingSetId)->set(['list_status_c' => 'Accepted'])->update();

            // Reject all other requests for the same item set
            $ewrRequestModel->where('listing_set', $listingSetId)
                    ->where('ewr_req_id !=', $requestId)
                    ->set([
                        'rejection_reason' => 'SoldOut',
                        'req_status_r' => 'rejected',
                        'req_status_c' => 'rejected'
                    ])->update();

            return redirect()->to('sys/thankYou')->with('message', 'Request processed successfully.');
        } elseif ($action == 'reject') {
            $rejectReason = $this->request->getPost('reject_reason');
            $data = [
                'req_status_r' => 'rejected',
                'req_status_c' => 'rejected',
                'rejection_reason' => $rejectReason
            ];

            $ewrRequestModel->update($requestId, $data);
            return redirect()->to('sys/thankYou')->with('message', 'Rejection processed successfully.');
        }

        return redirect()->back()->with('error', 'Error processing the request.');
    }

    public function collectItemsEwr() {
        helper(['form', 'url']);

        $userId = session()->get('UserId'); // Assuming session stores UserId
        $listingSetId = $this->request->getPost('listing_set_id'); // Get listing set ID from the form or URL

        $ewcListingModel = new \App\Models\EwcListingModel();
        $ewrInventoryModel = new \App\Models\EwrInventoryModel();
        $ewrInventoryItemsModel = new \App\Models\EwrInventoryItemsModel(); // Assume this model exists for ewr_inventory_items table
// Fetch the listing set details
        $listingSetDetails = $ewcListingModel->where('listing_set', $listingSetId)->findAll();

// Calculate the sub listing count, total quantity, total weight, and price
        $subListingCount = count($listingSetDetails);
        $totalQuantity = array_sum(array_column($listingSetDetails, 'quantity'));
        $totalWeight = array_sum(array_column($listingSetDetails, 'weight'));
        $price = array_sum(array_column($listingSetDetails, 'selling_price')); // Assuming each sub listing has a price
// Insert data into ewr_inventory table
        $inventoryData = [
            'listing_set' => $listingSetId,
            'UserId' => $userId,
            'sub_listing_count' => $subListingCount,
            'total_quantity' => $totalQuantity,
            'total_weight' => $totalWeight,
            'price' => $price,
        ];

        if ($ewrInvId = $ewrInventoryModel->insert($inventoryData)) {
// Insert each item into ewr_inventory_items
            foreach ($listingSetDetails as $item) {
                $itemData = [
                    'ewr_inv_id' => $ewrInvId,
                    'listing_set' => $listingSetId,
                    'item_id' => $item['item_id'],
                    'item_name' => $item['item_name'],
                    'quantity' => $item['quantity'],
                    'weight' => $item['weight'],
                    'description' => $item['description'],
                    'item_image' => $item['item_image'],
                ];
                $ewrInventoryItemsModel->insert($itemData);
            }

// Success, redirect or inform the user
            return redirect()->to('/some/success/page')->with('message', 'Items collected successfully.');
        } else {
// Error, redirect or inform the user
            return redirect()->back()->with('error', 'Error collecting the items.');
        }
    }

    public function viewUserMgt() {
        helper(['form']); // Ensure form helper is loaded
// Instantiate the UserModel to fetch users
        $userModel = new \App\Models\UserModel();
        $users = $userModel->findAll(); // Fetch all users
// Retrieve the user type from session for conditional display in the view
        $userType = session()->get('UserType');

// Prepare the data to be passed to the view
        $data = [
            'users' => $users, // Always include the users
            'success' => session()->getFlashdata('success') // Retrieve success message if it's set
        ];

// Load the views with the data
        echo view('sys/header');
        echo view('sys/menu_' . $userType, $data);
        echo view('sys/user_management', $data); // Make sure to pass $data here
        echo view('sys/footer');
    }

    public function rejectUser($userId) {
        $model = new UserModel();
        $data = ['is_admin_verified' => -1]; // Assuming -1 represents rejected
        $model->update($userId, $data);

// Prepare the message to display
        $viewData['message'] = 'User rejected successfully.';
// Render the view with the warning message
        return view('sys/warnings', $viewData);
    }

    public function activateUser($userId) {
        $db = \Config\Database::connect();
        $builder = $db->table('user');
        $builder->where('UserId', $userId);
        $builder->update(['account_status' => 'Active']);
        return redirect()->to('sys/viewUserMgt'); // Adjust the redirect path as necessary
    }

    public function deactivateUser($userId) {
        $db = \Config\Database::connect();
        $builder = $db->table('user');
        $builder->where('UserId', $userId);
        $builder->update(['account_status' => 'Inactive']);
        return redirect()->to('sys/viewUserMgt'); // Adjust the redirect path as necessary
    }

    public function suspendUser($userId) {
        $db = \Config\Database::connect();
        $builder = $db->table('user');
        $builder->where('UserId', $userId);
        $builder->update(['account_status' => 'Suspended']);
        return redirect()->to('sys/viewUserMgt'); // Adjust the redirect path as necessary
    }

    public function viewReqPassword() {
        helper('form');
        echo view('sys/header');
        echo view('sys/menu_addEwaste');
        echo view('sys/request_password_reset');
        echo view('sys/footer');
    }

    public function handlePasswordResetRequest() {
        if ($this->request->getMethod() == 'post') {
            $email = $this->request->getPost('email');
            $userModel = new \App\Models\UserModel();
            $user = $userModel->where('email', $email)->first();

            if ($user) {
                $userModel->update($user['UserId'], ['password_reset_requested_at' => date("Y-m-d H:i:s")]);

                $notificationModel = new \App\Models\NotificationModel();
// Fetch the admin user ID by the known admin role or admin email. Adjust this logic based on your system.
                $adminUser = $userModel->where('UserType', 'Admin')->first();
                $adminUserId = $adminUser ? $adminUser['UserId'] : null;

                if ($adminUserId) {
                    $notificationModel->addNotification(
                            $adminUserId,
                            $user['UserId'],
                            "Password reset requested for user ID: {$user['UserId']} by user email: {$email}"
                    );
                }

// Redirect with a success message
                return redirect()->to('/sys/login')->with('message', 'Password reset requested. An admin will review your request.');
            } else {
// Redirect with an error message if the email is not found
                return redirect()->to('/sys/request_password_reset')->with('message', 'No account found with that email address.');
            }
        }
// If not a POST request, show the reset request form
        return view('sys/request_password_reset');
    }

    public function viewResetbA($userId) {
        helper('form');
        $data = ['userId' => $userId]; // Make sure to pass the userId to the view
        echo view('sys/header');
        echo view('sys/menu_addEwaste');
        echo view('sys/reset_password', $data); // Pass $userId to the view here
        echo view('sys/footer');
    }

    public function resetUserPassword() {
        if (session()->get('UserType') !== 'admin') {
            return redirect()->to('/sys/login'); // Only admins can perform this action
        }

        if ($this->request->getMethod() === 'post') {
            $userId = $this->request->getPost('userId'); // Get userId from form input
            $newPassword = $this->request->getPost('newPassword');

// Validation rules
            $rules = [
                'newPassword' => 'required|min_length[8]',
            ];

            if (!$this->validate($rules)) {
// If validation fails, reload the form with validation errors
                return view('sys/reset_password', [
                    'validation' => $this->validator,
                    'userId' => $userId,
                ]);
            } else {
// If validation passes, proceed with updating the user's password
                $userModel = new \App\Models\UserModel();
                $userModel->update($userId, [
                    'Password' => password_hash($newPassword, PASSWORD_DEFAULT),
                    'password_reset_requested_at' => null, // Clear the reset request
                ]);

// Send email to the user about password reset
                $user = $userModel->find($userId);
                $email = \Config\Services::email();
                $email->setTo($user['email']);
                $email->setFrom('your_email@example.com', 'Your Site Name');
                $email->setSubject('Password Reset Confirmation');
                $message = "<h1>Password Reset</h1><p>Your password has been successfully reset.</p>";
                $email->setMessage($message);
                $email->send();

// Redirect the admin back to the user management page with a success message
                return redirect()->to('sys/viewUserMgt')->with('message', 'User password has been reset.');
            }
        }

// If not a POST request or the userId is not provided, redirect to the user management page
        return redirect()->to('/sys/viewUserMgt')->with('message', 'Invalid password reset request.');
    }

    public function updateEwrInv() {
        helper(['form', 'url']);
        $userId = session()->get('UserId');
        $inventoryModel = new \App\Models\EwrInventoryModel();
        $ewcListModel = new \App\Models\EwcListingsModel();

        // Receive all items as an array of items, each item being an associative array
        $items = $this->request->getPost('items'); // Assume 'items' is an array of arrays from the form

        foreach ($items as $item) {
            $inventoryData = [
                'listing_set' => $item['listing_set'],
                'item_id' => $item['item_id'],
                'item_name' => $item['item_name'],
                'item_type' => $item['item_type'],
                'quantity' => $item['quantity'],
                'weight' => $item['weight'],
                'weight_unit' => $item['weight_unit'],
                'description' => $item['description'],
                'item_image' => $item['item_image'],
                'set_buying_price' => $item['set_buying_price'],
                'UserId' => $userId,
                'status' => 'collected',
                'collected_at' => date("Y-m-d")
            ];

            // Save each item to the inventory
            $inventoryModel->save($inventoryData);

            // Update the corresponding listing status
            $newdata = ['list_status_c' => 'collected'];
            $ewcListModel->where(['listing_set' => $item['listing_set']])->set($newdata)->update();
        }

        // Updating the request status
        $ewr_req_id = $this->request->getPost('ewr_req_id');
        $model = new \App\Models\EwrRequestModel();
        $newdata = ['req_status_later' => 'collected'];
        $model->update($ewr_req_id, $newdata);

        return redirect()->to('/sys/thankYou');
    }

    public function eWasteCategoryDistributionReport() {
        helper(['form', 'url']);
        $model = new \App\Models\EwcInventoryModel(); // Assumed model for handling e-waste inventory

        $timeFrame = $this->request->getPost('timeFrame');
        $ewg = $this->request->getPost('ewg');

// Convert time frame to date range
        $dateRange = $this->getDateRangeFromTimeFrame($timeFrame);

// Fetch data based on the filters
        $reportData = $model->getCategoryDistribution($dateRange['start'], $dateRange['end'], $ewg);

// Pass data to the view
        return view('sys/e_waste_category_distribution', ['reportData' => $reportData]);
    }

    private function getDateRangeFromTimeFrame($timeFrame) {
        $today = new DateTime();
        switch ($timeFrame) {
            case 'day':
                $start = $today->format('Y-m-d');
                break;
            case 'month':
                $start = $today->modify('-1 month')->format('Y-m-d');
                break;
            case 'year':
                $start = $today->modify('-1 year')->format('Y-m-d');
                break;
            default:
                $start = $today->format('Y-m-d');
                break;
        }
        $end = (new DateTime())->format('Y-m-d');

        return ['start' => $start, 'end' => $end];
    }

    public function viewEwrInventory() {
        $model = new \App\Models\EwrInventoryModel();
        $session = session();
        $userId = session()->get('UserId');
        $data['inventoryItems'] = $model->where('UserId', $userId)->findAll();
        $userType = $session->get('UserType');
        echo view('sys/header');
        echo view('sys/menu_' . $userType, $data);
        echo view('sys/ewr_inventory', $data);
        echo view('sys/footer');
    }

    public function viewEwrInventoryAll() {
        $model = new \App\Models\EwrInventoryModel();

        $data['inventoryItems'] = $model->join('ewaste_recycler', 'ewaste_recycler.user_id=ewr_inventory.UserId', 'left')->findAll();

        $session = session();
        $userType = $session->get('UserType');
        echo view('sys/header');
        echo view('sys/menu_' . $userType, $data);
        echo view('sys/ewr_inventory_all', $data);
        echo view('sys/footer');
    }

    public function updateRecyclingStatus() {

        $session = session();
        $userType = $session->get('UserType');

        if ($this->request->getMethod() === 'post') {
            $selectedItems = $this->request->getPost('selected_items');

            if (is_array($selectedItems) && !empty($selectedItems)) {
                $model = new \App\Models\EwrInventoryModel();

// Get the current highest batch_id
                $latestBatchId = $model->selectMax('batch_id')->first();
                $batchId = $latestBatchId ? $latestBatchId['batch_id'] + 1 : 1;

// Save batch_id to session
                $session->set('batch_id', $batchId);

                foreach ($selectedItems as $itemId) {
                    $model->update($itemId, [
                        'status' => 'recycled',
                        'recycled_at' => date("Y-m-d H:i:s"),
                        'batch_id' => $batchId,
                    ]);
                }
            }

            echo view('sys/header');
            echo view('sys/menu_' . $userType);
            echo view('sys/recycle_form');
            echo view('sys/footer');
        }
    }

    public function submit_materials() {
        helper(['form', 'url']);
        $session = session();
        $userType = $session->get('UserType');

        $model = new \App\Models\RecycledMaterialsModel(); // Ensure you're using the correct namespace

        if ($this->request->getMethod() === 'post') {
            $materialTypes = $this->request->getPost('Material_Type') ?? [];
            $materials = $this->request->getPost('Material') ?? [];
            $generatedMasses = $this->request->getPost('generated_mass') ?? [];
            $massUnits = $this->request->getPost('mass_unit') ?? []; // Ensure the form field names match

            $batchId = $session->get('batch_id') ?? $this->generateBatchId(); // Fallback to generating if not in session

            foreach ($materials as $index => $material) {
                if (!empty($material)) {
                    $data = [
                        'Material_Type' => $materialTypes[$index] ?? '',
                        'Material' => $material,
                        'generated_mass' => $generatedMasses[$index] ?? 0,
                        'mass_unit' => $massUnits[$index] ?? 'g', // Default to 'g' if not set
                        'recycled_at' => date("Y-m-d"),
                        'batch_id' => $batchId,
                    ];
                    $model->insert($data);
                }
            }
            $data['list'] = $model->where('batch_id', $batchId)->findAll();

            echo view('sys/header');
            echo view('sys/menu_' . $userType);
            echo view('sys/recycle_form', $data);
            echo view('sys/footer');
        }
    }

    /* public function updateRecyclingStatus($itemId) {
      $model = new \App\Models\EwrInventoryModel();
      $model->update($itemId, [
      'status' => 'recycled',
      'recycled_at' => date("Y-m-d H:i:s") // Current datetime
      ]);
      return redirect()->to('sys/viewEwrInventory');
      }

      /* public function EwrRecycling() {
      helper(['form', 'url']);
      $model = new \App\Models\EwrInventoryModel();
      $userId = session()->get('UserId');
      $user_type = strtolower(session()->get('UserType'));
      // Assuming you want the current month, but you can adjust this for user input
      $currentMonthStart = date('Y-m-01');
      $currentMonthEnd = date('Y-m-t');

      // Fetch items recycled within the current month
      // Fetch items recycled within the current month by a specific user
      $recycledItems = $model->where('UserId', $userId)
      ->where('status', 'recycled')
      ->where('recycled_at >=', $currentMonthStart)
      ->where('recycled_at <=', $currentMonthEnd)
      ->findAll();

      $data = [
      'recycledItems' => $recycledItems,
      'currentMonth' => date('F Y'),
      ];

      echo view('sys/header');
      echo view('sys/menu_' . $user_type);
      echo view('sys/monthly_summary_form', $data);
      echo view('sys/footer');
      } */

    public function showMonthlySummaryForm() {
        helper(['form', 'url']);
        $model = new \App\Models\EwrInventoryModel();
        $userId = session()->get('UserId');

// Fetch all items with 'recycled' status regardless of the date/time
        $recycledItems = $model->where('UserId', $userId)
                ->where('status', 'recycled')
                ->findAll();

        $data = [
            'recycledItems' => $recycledItems,
        ];

        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/monthly_summary_form', $data);
        echo view('sys/footer');
    }

    public function recycled_items() {
        helper(['form', 'url']);
        $recycledMaterialsModel = new RecycledMaterialsModel();
        $model = new EwrInventoryModel();
        $userId = session()->get('UserId');

        $month = $this->request->getGet('month');
        $monthName = ""; // Initialize month name
        if (!empty($month)) {
            $model->where('UserId', $userId)
                    ->where('status', 'recycled')
                    ->where('MONTH(recycled_at)', $month);
            $monthName = date('F', mktime(0, 0, 0, $month, 10)); // Convert month number to name
        } else {
            $model->where('UserId', $userId)
                    ->where('status', 'recycled');
        }
        $year = date('Y');
        $data = [
            'recycledItems' => $model->findAll(),
            'filteredMonth' => $monthName, // Add the month name to the data array
            'filteredMonthNum' => $month // Pass the month number for the form
        ];
        $data['recycledSummary'] = $recycledMaterialsModel->getMonthlyRecycledSummary($year, $data['filteredMonthNum']);
        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/monthly_summary_form_filtered', $data);
        echo view('sys/footer');
    }

    /* public function submitMonthlySummary() {
      helper(['form']);
      $recyclerId = session()->get('UserId'); // Get the recycler's user ID from the session
      $monthYear = $this->request->getPost('month_year'); // Get the month and year from the form
      $recoveredMaterials = $this->request->getPost('recovered_materials'); // Array of recovered materials
      $recoveredMasses = $this->request->getPost('recovered_masses'); // Array of masses for recovered materials
      $disposedMaterials = $this->request->getPost('disposed_materials'); // Array of disposed materials
      $disposedMasses = $this->request->getPost('disposed_masses'); // Array of masses for disposed materials
      // Prepare the details array for serialization
      $details = [];
      foreach ($recoveredMaterials as $key => $material) {
      $details['recovered'][] = [
      'name' => $material,
      'mass' => $recoveredMasses[$key],
      'unit' => 'kg', // Assuming kilograms as the unit of mass
      ];
      }
      foreach ($disposedMaterials as $key => $material) {
      $details['disposed'][] = [
      'name' => $material,
      'mass' => $disposedMasses[$key],
      'unit' => 'kg', // Assuming kilograms as the unit of mass
      ];
      }

      // Load the RecyclingSummaryModel
      $model = model('App\Models\RecyclingSummaryModel');
      // Insert the summary data into the database
      $model->insert([
      'recycler_id' => $recyclerId,
      'month_year' => $monthYear,
      'details' => json_encode($details), // Serialize details as JSON
      ]);

      // Redirect to the inventory view or a confirmation page
      return redirect()->to('sys/viewEwrInventory');
      } */

    public function ewrsubmit() {
        helper(['form']);
        $summaryModel = new \App\Models\RecyclingSummaryModel();
        $inventoryModel = new \App\Models\EwrInventoryModel();
        $userId = session()->get('UserId');

        if ($this->request->getMethod() === 'post') {
            $postData = $this->request->getPost([
                'recovered_material_name', 'recovered_mass', 'recovered_unit',
                'disposed_material_name', 'disposed_mass', 'disposed_unit',
                'filteredMonthNum'
            ]);

// Basic validation example, ensure to tailor it as per your actual validation rules
            if (!$this->validate([
                        'recovered_material_name' => 'string',
                        'recovered_mass' => 'numeric',
                        'recovered_unit' => 'string',
                        'disposed_material_name' => 'string',
                        'disposed_mass' => 'numeric',
                        'disposed_unit' => 'string',
                    ])) {
// If validation fails, reload the form view with validation errors
                return view('monthly_summary_form_filtered', ['validation' => $this->validator]);
            } else {
// Prepare and insert summary data
                $newData = [
                    'UserId' => $userId,
                    'month_year' => $postData['filteredMonthNum'] ? date('Y-m-d', strtotime($postData['filteredMonthNum'])) : date('Y-m-01'),
                    'recovered_material_name' => $postData['recovered_material_name'],
                    'recovered_mass' => $postData['recovered_mass'],
                    'recovered_unit' => $postData['recovered_unit'],
                    'disposed_material_name' => $postData['disposed_material_name'],
                    'disposed_mass' => $postData['disposed_mass'],
                    'disposed_unit' => $postData['disposed_unit']
                ];

                if ($summaryModel->insert($newData)) {
// Convert the filtered month/year to the appropriate format
                    $filteredMonth = date('m', strtotime($newData['month_year']));
                    $filteredYear = date('Y', strtotime($newData['month_year']));

// Update the status of the inventory items
                    $inventoryModel->set('status', 'report submitted')
                            ->where('UserId', $userId)
                            ->where('MONTH(recycled_at)', $filteredMonth)
                            ->where('YEAR(recycled_at)', $filteredYear)
                            ->update();

                    return redirect()->to('sys/thankYou')->with('message', 'Recycling summary submitted successfully');
                } else {
                    return redirect()->to('sys/warnings')->with('message', 'Error in submitting recycling summary');
                }
            }
        }
    }

    public function viewUserReview() {
        $userType = session()->get('UserType');
        $userModel = new \App\Models\UserModel();
        // Fetch all users along with their license data
        $users = $userModel->getAllUsersWithLicense();
        // Prepare the data to be passed to the view
        $data = [
            'users' => $users, // Always include the users
            'success' => session()->getFlashdata('success') // Retrieve success message if it's set
        ];

        // Load the views with the data
        echo view('sys/header');
        echo view('sys/menu_' . strtolower($userType), $data);
        echo view('sys/user_review', $data); // Make sure to pass $data here
        echo view('sys/footer');
    }

    public function graApproval($userId) {
        $status = $this->request->getPost('status');
        $userModel = new \App\Models\UserModel();
        $notificationModel = new \App\Models\NotificationModel(); // Ensure this model is correctly loaded
// Fix for "Attempt to read property 'UserId' on array"
        $adminUser = $userModel->where('UserType', 'Admin')->first();
        $adminUserId = $adminUser['UserId']; // Use array access since ->first() returns an array

        $user = $userModel->find($userId); // Fetch user details for email sending

        if ($status == 'accepted') {
// If GRA approves, set gra_approval to 'Activate this'
            $updateData = ['gra_approval' => 'Activate this'];

// Notification message to admin to activate the account
            $notificationMessage = "GRA approved the account for user ID: {$userId}. Admin needs to activate this account.";
// Add notification for the admin
            $notificationModel->addNotification($adminUserId, $userId, $notificationMessage);
        } else {
// If GRA rejects, set gra_approval to 'rejected'
            $updateData = ['gra_approval' => 'rejected'];

// Email to the user upon rejection
            $email = \Config\Services::email();
            $email->setTo($user['email']);
            $email->setFrom('support@cea.com', 'EWMS Support');
            $email->setSubject('Application Rejected');
            $email->setMessage('Your application has been rejected. Contact support@cea for more details.');
            if (!$email->send()) {
// Optionally log an error or handle email send failure
                log_message('error', 'Email to user ID ' . $userId . ' could not be sent.');
            }
        }

// Update the user's GRA approval status
        $userModel->update($userId, $updateData);

// Redirect back with a success message
        return redirect()->back()->with('success', "The user's GRA approval status has been updated.");
    }

    public function GraAction($userId) {
        $action = $this->request->getPost('action');
        $userModel = new \App\Models\UserModel();
        $notificationModel = new \App\Models\NotificationModel();

// Assuming that adminUserId is fetched once and used for notification purposes
        $adminUser = $userModel->where('UserType', 'Admin')->first();
        $adminUserId = $adminUser['UserId']; // Using array access since ->first() returns an array

        if ($action == 'activate') {
            $updateData = ['gra_action' => 'Activate'];
        } elseif ($action == 'deactivate') {
            $updateData = ['gra_action' => 'Deactivate'];
        } elseif ($action == 'suspend') {
            $updateData = ['gra_action' => 'Suspend'];
        } elseif ($action == 'reset_password') {
            $updateData = ['gra_action' => 'Reset Password'];
        } else {
// If an unknown action is specified
            return redirect()->back()->with('error', "Invalid action requested for User ID: {$userId}.");
        }

// Update the user's record with the new data
        $userModel->update($userId, $updateData);

// Send a common notification to admin regarding GRA action
        $notificationMessage = "GRA action performed for user ID: {$userId}. Admin need to take an action  accordingly. Check the GRA request column for details.";

// Add notification for the admin
        $notificationModel->addNotification($adminUserId, $userId, $notificationMessage);

// Redirect back with a success message
        return redirect()->back()->with('success', " '{$action}' request successfully performed for User ID: {$userId}.");
    }

    public function submit_category() {
        helper(['form', 'url']);
        $session = session();
        $userType = $session->get('UserType');

        $model = new \App\Models\categoryModel(); // Ensure you're using the correct namespace

        if ($this->request->getMethod() === 'post') {

            $CategoryId = $this->request->getPost('Category_ID') ?? [];
            $CategoryName = $this->request->getPost('category_name') ?? [];

            foreach ($categories as $index => $category) {
                if (!empty($category)) {
                    $data = [
                        'Category_ID' => $CategoryId,
                        'category_name' => $CategoryName,
                    ];
                    $model->insert($data);
                }
            }


            echo view('sys/header');
            echo view('sys/menu_' . $userType);
            echo view('sys/add_category', $data);
            echo view('sys/footer');
        }
    }

    public function viewitemsAll() {
        helper('form');
        $listModel = new \App\Models\EwasteListModel();
        $userId = session()->get('UserId');
        $listItems = $listModel->where('UserId', $userId)->where('collection_status', 'Collected')->findAll();
        $data['listItems'] = $listItems;
        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/listed_items', $data);
        echo view('sys/footer');
    }

    public function collectedItemsAll() {
        helper('form');
        $listModel = new \App\Models\EwasteListModel();
        $userId = session()->get('UserId');
        $data['listItems'] = $listModel->where('collector_id', $userId)->where('collection_status', 'Collected')->findAll();
        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/collected_items', $data);
        echo view('sys/footer');
    }

    public function view_add_new_category() {
        helper('form');
        $user_type = strtolower(session()->get('UserType'));

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/add_new_category');
        echo view('sys/footer');
    }

    public function saveCategory() {
        helper('form');
        $data = array();
        $Item_Category = new CategoryModel();

        $user_type = strtolower(session()->get('UserType'));

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'Item_Category' => ['label' => 'Item Category', 'rules' => 'required|is_unique[category.Item_Category]'],
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $Item_Category = new CategoryModel();
                $Item_Category->save(['Item_Category' => $this->request->getPost('Item_Category')]);
                // Set flash message
                session()->setFlashdata('message', 'Category successfully added.');

                // Redirect back to add new category view
                return redirect()->to('sys/view_add_new_category');
            }
            echo view('sys/header');
            echo view('sys/menu_' . $user_type);
            echo view('sys/add_new_category', $data);
            echo view('sys/footer');
        }
    }

    public function listCategories() {
        $model = new CategoryModel();

        // Fetch categories where deleted_at is not set
        $data['categories'] = $model->where('deleted_at')->findAll();

        // Load views
        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/list_categories', $data);
        echo view('sys/footer');
    }

    public function editCategory($Category_ID) {
        $model = new CategoryModel();
        $category = $model->find($Category_ID);

        if (!$category) {
            // If no category found, redirect or show an error
            return redirect()->to('sys/listCategories'); // Adjust as needed
        }

        $data['category'] = $category;

        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/edit_category', $data);
        echo view('sys/footer');
    }

    public function updateCategory() {
        $model = new CategoryModel();
        $Category_ID = $this->request->getPost('Category_ID');
        $data = [
            'Item_Category' => $this->request->getPost('Item_Category'),
        ];

        $model->where('Category_ID', $Category_ID)->set($data)->update();

        return redirect()->to('/sys/listCategories')->with('message', 'Category successfully Updated.');
    }

    public function deleteCategory($Category_ID) {
        $model = new CategoryModel();

        if (!$Category_ID) {
            $Category_ID = $this->request->getPost('Category_ID');
        }

        if ($Category_ID) {
            $model->where('Category_ID', $Category_ID)->set(['deleted_at' => date("Y-m-d")])->update();

            return redirect()->to('/sys/listCategories')->with('message', 'Category successfully deleted.');
        } else {
            return redirect()->back()->with('errors', ['Could not delete the category.']);
        }
    }

    public function listDeletedCategories() {
        $model = new CategoryModel();
        $data['categories'] = $model->where('deleted_at IS NOT NULL')->findAll();

        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/list_deleted_categories', $data);
        echo view('sys/footer');
    }

    public function restoreCategory($CategoryID) {
        $model = new CategoryModel();
        if ($model->update($CategoryID, ['deleted_at' => null])) {
            return redirect()->to('/sys/listDeletedCategories')->with('message', 'Category restored successfully');
        } else {
            return redirect()->back()->with('errors', ['Could not restore the category.']);
        }
    }

    public function permanentlyDeleteCategory($CategoryID) {
        $model = new CategoryModel();
        if ($model->delete($CategoryID, true)) { // The second parameter `true` indicates a hard delete.
            return redirect()->to('/sys/listDeletedCategories')->with('message', 'Category permanently deleted successfully');
        } else {
            return redirect()->back()->with('errors', ['Could not delete the category permanently.']);
        }
    }

    public function saveCategory1() {

        helper('form');
        $model = new CategoryModel();

        $categoryID = $data = [
            'category_ID' => $categoryID,
            'category' => $this->request->getPost('category_name'),
        ];

        $model->save($data);
        return redirect()->to('sys/view_add_new_category');
    }

    public function practiceDashboard() {
        $session = session();
        $userType = strtolower($session->get('UserType'));

        echo view('sys/header');
        echo view('sys/menu_' . $userType);
        echo view('sys/Practice_Dashboard');
        echo view('sys/footer');
    }

    public function viewAddEwaste1() {
        helper('form');
        $Item_Category = new CategoryModel();
        $data['Item_Category'] = $Item_Category->findAll();
        $user_type = strtolower(session()->get('UserType'));

        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/addEwasteForm', $data);
        echo view('sys/footer');
    }

    public function export_monthly_report() {
        $model = new EwasteListModel();
        $userId = session()->get('UserId');
        $year = $this->request->getPost('year') ?? date('Y');
        $month = $this->request->getPost('month');

        // Retrieve monthly report data
        $listings = $model->monthlyListings($userId, $year, $month);

        // Retrieve summary data
        $summary = $model->getSummary($userId, $year, $month);

        // Construct the filename with user ID
        $filename = 'monthly_report_' . $userId . '.csv';

        // Set CSV headers with the dynamically generated filename
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        /* // Set CSV headers
          header('Content-Type: text/csv');
          header('Content-Disposition: attachment; filename="monthly_report.csv"');

         */

        // Open output stream
        $output = fopen('php://output', 'w');

        // Write CSV headers for monthly report data
        fputcsv($output, ['Item Type', 'Number of Listings']);

        // Write report data to CSV
        foreach ($listings as $listing) {
            fputcsv($output, [$listing['item_type'], $listing['nooflist']]);
        }

        // Add empty line for separation
        fputcsv($output, []);

        // Write CSV headers for summary data
        fputcsv($output, ['Listing Status', 'Count']);
        fputcsv($output, ['Total Listed', $summary['totalListed']]);
        fputcsv($output, ['Active (Not Sold Out or Not Deleted)', $summary['active']]);
        fputcsv($output, ['Sold Out', $summary['soldOut']]);
        fputcsv($output, ['Deleted', $summary['deleted']]);

        // Close output stream
        fclose($output);
    }

    public function export_monthly_report_pdf() {
        $model = new EwasteListModel();
        $userId = session()->get('UserId');
        $year = $this->request->getPost('year') ?? date('Y');
        $month = $this->request->getPost('month');

        // Retrieve monthly report data
        $listings = $model->monthlyListings($userId, $year, $month);

        // Retrieve summary data
        $summary = $model->getSummary($userId, $year, $month);

        // Initialize PDF options

        $options = new Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        // Create new PDF instance
        $dompdf = new Dompdf($options);

        // HTML content for PDF
        $html = '<h1>Monthly Report</h1>';
        $html .= '<h2>Monthly Listings</h2>';
        $html .= '<table>';
        $html .= '<tr><th>Item Type</th><th>Number of Listings</th></tr>';
        foreach ($listings as $listing) {
            $html .= '<tr><td>' . $listing['item_type'] . '</td><td>' . $listing['nooflist'] . '</td></tr>';
        }
        $html .= '</table>';

        $html .= '<h2>Listing Status Insights</h2>';
        $html .= '<table>';
        $html .= '<tr><th>Status</th><th>Count</th></tr>';
        $html .= '<tr><td>Total Listed</td><td>' . $summary['totalListed'] . '</td></tr>';
        $html .= '<tr><td>Active (Not Sold Out or Not Deleted)</td><td>' . $summary['active'] . '</td></tr>';
        $html .= '<tr><td>Sold Out</td><td>' . $summary['soldOut'] . '</td></tr>';
        $html .= '<tr><td>Deleted</td><td>' . $summary['deleted'] . '</td></tr>';
        $html .= '</table>';

        // Load HTML content into PDF
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF
        $dompdf->render();

        // Output PDF to browser
        $dompdf->stream('monthly_report.pdf', array('Attachment' => 0));
    }

    public function viewCollected() {
        helper('form');
        $listModel = new \App\Models\EwasteListModel();
        $userId = session()->get('UserId');
        $listItems = $listModel->where('UserId', $userId)->where('collection_status', 'Collected')->findAll();
        $data['listItems'] = $listItems;
        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/collected', $data);
        echo view('sys/footer');
    }

    public function viewCollected1() {
        helper('form');
        $listModel = new \App\Models\EwasteListModel();
        $userId = session()->get('UserId');
        $listItems = $listModel->getCollectedInfo($userId);
        $listItems1 = $listModel->getCollectedAmount($userId);
        $data['listItems'] = $listItems;
        $data['listItems1'] = $listItems1;
        echo view('sys/header');
        echo view('sys/menu_' . strtolower(session()->get('UserType')));
        echo view('sys/collected', $data);
        echo view('sys/footer');
    }

}
