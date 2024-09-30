


<main id="main" class="main">
    <div class="pagetitle">
        <h1>View Bids</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                <li class="breadcrumb-item active">Bids for Item #<?= $item_id ?></li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Bids for Item #<?= $item_id ?></h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Bidder Name</th>
                                        <th>Bid Price</th>
                                        <th>Requested Quantity</th>
                                        <th>Your Note</th>
                                        <th>Preferred Pickup Day</th>
                                        <th>Time Slot Start</th>
                                        <th>Time Slot End</th>
                                        <th>Alternative Pickup Day</th>
                                        <th>Alternative Time Slot Start</th>
                                        <th>Alternative Time Slot End</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bids as $bid): ?>
                                        <tr>
                                        <tr>
                                            <td><?= $bid['bidderName'] ?></td>
                                            <td><?= $bid['bid_price_per_item'] ?></td>
                                            <td><?= $bid['requested_quantity'] ?></td>
                                            <td><?= $bid['your_note'] ?></td>
                                            <?php if (!is_null($bid['pickupDetails'])): ?>
                                                <td><?= $bid['pickupDetails']['pref_day'] ?></td>
                                                <td><?= $bid['pickupDetails']['slot_start'] ?></td>
                                                <td><?= $bid['pickupDetails']['slot_end'] ?></td>
                                                <td><?= $bid['pickupDetails']['alt_day1'] ?></td>
                                                <td><?= $bid['pickupDetails']['alt_start1'] ?></td>
                                                <td><?= $bid['pickupDetails']['alt_end1'] ?></td>
                                            <?php else: ?>
                                                <td colspan="6">No pickup details available</td>
                                            <?php endif; ?>
                                            <td>
                                               
                                                
                                                <?php
                                                if ($bid['bid_status_g']=='Accepted'){
                                                    echo 'Accepted';
                                                }else{
                                                ?>
                                               
                                                <form method="post" action="<?= base_url('sys/updateBidStatus') ?>">
                                                    <input type="hidden" name="bid_id" value="<?= $bid['bid_id'] ?>">
                                                    <input type="hidden" name="collector_id" value="<?= $bid['UserId'] ?>">
                                                    <input type="hidden" name="item_id" value="<?= $bid['item_id'] ?>">
                                                    <button type="submit" name='bid_status' value='Accepted' class="btn btn-success btn-sm">Accept</button>
                                                    
                                                    <a href="<?= base_url('sys/rejectBid/' . $bid['bid_id']) ?>" class="btn btn-danger btn-sm">Reject</a>
                                                    <a href="<?= base_url('sys/rescheduleBid/' . $bid['bid_id']) ?>" class="btn btn-warning btn-sm">Reschedule</a>
                                                </form>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>



public function viewBids($item_id) {
        helper(['url', 'form']);

        $data = [];
        $biddingModel = new \App\Models\BiddingModel();
        $pickupModel = new \App\Models\PickupModel();
        $userModel = new \App\Models\UserModel();
        $user_type = strtolower(session()->get('UserType'));

        // Fetch bids for the item
        $bids = $biddingModel->where('item_id', $item_id)->findAll();

        // Enhance bids with pickup details and bidder info
        foreach ($bids as $key => $bid) {
            $pickupDetails = $pickupModel->where('bid_id', $bid['bid_id'])->first();
            $bidder = $userModel->find($bid['UserId']);

            // Fetch collector's business name
            $collectorModel = new \App\Models\EwasteCollectorModel();
            $collector = $collectorModel->where('UserId', $bid['UserId'])->first();
            $businessName = $collector ? $collector['businessName'] : $bidder['UserName'];

            $bids[$key]['pickupDetails'] = $pickupDetails;
            $bids[$key]['bidderName'] = $businessName ?? 'Unknown';
        }

        $data['bids'] = $bids;
        $data['item_id'] = $item_id;

        // Load views
        echo view('sys/header');
        echo view('sys/menu_' . $user_type);
        echo view('sys/view_bids', $data);
        echo view('sys/footer');
    }

    public function updateBidStatus() {

        $biddingModel = new \App\Models\BiddingModel();

        $bidData = [
            'bid_status_g' => $this->request->getPost('bid_status'),
        ];

        $biddingModel->where(['bid_id' => $this->request->getPost('bid_id')])->set($bidData)->update();
        $ewasteListingModel = new \App\Models\EwasteListModel();

        $bidData = [
            'item_status_g' => $this->request->getPost('bid_status'),
            'bid_id' => $this->request->getPost('bid_id'),
            'collector_id' => $this->request->getPost('collector_id'),
            
        ];
         $ewasteListingModel->where(['item_id' => $this->request->getPost('item_id')])->set($bidData)->update();
    }

}
