<main id="main" class="main">
    <div class="pagetitle">
        <h1>Detailed View</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                <li class="breadcrumb-item active">Detailed View</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">e-Waste Detailed View</h5>

                        <!-- Item Image -->
                        <div class="text-center mb-4">
                            <img src="<?= base_url('public/images/uploads/' . $item['item_image']) ?>" alt="Item Image" class="img-fluid rounded" style="max-width: 400px;">
                        </div>

                        <!-- Item Details -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <?php
                                            $details = [
                                                'Item Title' => $item['item_title'],
                                                'Item Name' => $item['item_name'],
                                                'Item Type' => $item['item_type'],
                                                'Item Description' => $item['item_description'],
                                                'Quantity' => $item['quantity'],
                                                'Weight' => $item['weight'] . " " . $item['weight_unit'],
                                                'Amount Per Item' => $item['amount'],
                                                'Pickup Location' => $item['pickup_location'],
                                                'Google Location Link' => "<a href=\"" . htmlspecialchars($item['google_location']) . "\" target=\"_blank\">View Location</a>",
                                                'Contact Name' => $item['contact_name'],
                                                'Contact Number' => $item['contact_number'],
                                                'Item Status' => $item['item_status_g'],
                                                'Date Added' => $item['date_added'],
                                                'Time Added' => $item['time_added']
                                            ];

                                            foreach ($details as $label => $value):
                                                ?>
                                                <tr>
                                                    <th><?= $label ?></th>
                                                    <td><?= $value ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-end">
                                    <div class="dropdown">
                                        <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton<?= $item['item_id']; ?>" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= $item['item_id']; ?>">
                                            <?php if ($hasBids): ?>
                                                <a class="dropdown-item" href="<?= base_url('sys/viewBidsewc/' . $item['item_id']); ?>">Bid Info</a>
                                            <?php else: ?>
                                                <span class="dropdown-item">No other actions can be taken at this moment</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if ($userBid && $userBid['bid_status_c'] === 'Accepted'): ?>
                                        <a href="<?= base_url('sys/collectItem/' . $item['item_id']) ?>" class="btn btn-success">Collect</a>
                                        <a href="<?= base_url('sys/cancelDeal/' . $item['item_id']) ?>" class="btn btn-danger">Cancel Deal</a>
                                    <?php elseif ($userBid && $userBid['bid_status_c'] == 'Bid Submitted'): ?>
                                        <a href="<?= base_url('sys/withdrawBid/' . $userBid['bid_id']) ?>" class="btn btn-danger">Withdraw Bid</a>
                                    <?php elseif ($canBid): ?>
                                        <?php if ($item['price_option'] == 'free'): ?>
                                            <a href="<?= base_url('sys/displayBiddingForm/' . $item['item_id'] . '/free') ?>" class="btn btn-success">Request Item</a>
                                        <?php else: ?>
                                            <a href="<?= base_url('sys/displayBiddingForm/' . $item['item_id']) ?>" class="btn btn-primary">Bid</a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</main>
