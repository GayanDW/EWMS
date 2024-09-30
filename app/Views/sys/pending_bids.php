<?php

use App\Models\BiddingModel;
use App\Models\NotificationModel;
use App\Models\EwasteListModel;

$biddingModel = new BiddingModel();

$notificationModel = new NotificationModel();
$ewasteModel = new EwasteListModel();
$userId = session()->get('UserId');

$listings = $ewasteModel->getListingsForPendingBids($userId);

?>


<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard Summary</h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Dashboard Summary</li>
        </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">e-Waste Summary</h5>
                        <p>View and manage your e-Waste listings.</p>
                        <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                            <div class="datatable-container">
                                <table class="table datatable datatable-table">
                                    <thead>
                                        <tr>
                                            <th>Listing Number</th>
                                            <th>Item Image</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Price Option</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($listings as $item): ?>

                                            <tr>
                                                <td><?= esc($item['item_id']); ?></td>
                                                <td><img src="<?= base_url('public/images/uploads/' . esc($item['item_image'], 'url')) ?>" alt="Item Image" width="50"></td>
                                                <td><?= esc($item['item_title']); ?></td>
                                                <td><?= esc($item['item_type']); ?></td>
                                                <td><?= esc($item['price_option']); ?></td>
                                                <td><?= esc($item['amount']); ?></td>

                                                <td><?= isset($item['bid_status_c']) ? esc($item['bid_status_c']) : 'Open for Bidding'; ?></td>


                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton<?= $item['item_id']; ?>" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= $item['item_id']; ?>">
                                                            <a class="dropdown-item" href="<?= base_url('sys/detailedViewEwc/' . $item['item_id']); ?>">View Full Listing</a>
                                                            <a class="dropdown-item" href="<?= base_url('sys/viewBidsewc/' . $item['item_id']); ?>">Bid Info</a>
                                                        </div>
                                                    </div>

                             
                                                    <?php if ($item['bid_status_c'] === 'Bids Pending'): ?>
                                                        <a href="<?= base_url('sys/withdrawBid/' . $item['bid_id']) ?>" class="btn btn-danger">Withdraw Bid</a>
                                                
                                                    <?php endif; ?>
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
        </div>
    </section>

</main>
