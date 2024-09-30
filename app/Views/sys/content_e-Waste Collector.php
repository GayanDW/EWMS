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
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Listing Number</th>
                                            <th>Item Image</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Price Option</th>
                                            <th>Quantity</th>
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
                                                <td><?= esc($item['quantity']); ?></td>
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

                                                    <?php if ($item['bid_status_c'] === 'Accepted'): ?>
                                                        <?php if ($item['collection_status'] === 'Collected'): ?>
                                                            <span class="badge text-bg-secondary">Collected</span>
                                                        <?php else: ?>
                                                            <a href="<?= base_url('sys/viewColForm/' . $item['item_id']) ?>" class="btn btn-success">Collect</a>
                                                            <a href="<?= base_url('sys/cancelDeal/' . $item['bid_id']) ?>" class="btn btn-danger">Cancel Deal</a>
                                                        <?php endif; ?>
                                                    <?php elseif ($item['bid_status_c'] === 'Rejected' && ($item['item_status_g'] === 'Accepted' || $item['item_status_g'] === 'Cancelled')): ?>
                                                        <span class="badge bg-warning">Sold Out</span>
                                                    <?php elseif ($item['bid_status_c'] === 'Cancelled' && $item['cancelled_by_ewc'] === 1): ?>
                                                        <span class="badge bg-warning">Cancelled By You</span>
                                                    <?php elseif ($item['bid_status_c'] === 'Bids Pending'): ?>
                                                        <a href="<?= base_url('sys/withdrawBid/' . $item['bid_id']) ?>" class="btn btn-danger">Withdraw Bid</a>

                                                    <?php elseif ($item['price_option'] === 'free'): ?>
                                                        <a href="<?= base_url('sys/displayBiddingForm/' . $item['item_id'] . '/free') ?>" class="btn btn-primary">Request Item</a>
                                                    <?php elseif ($item['bid_status_c'] === 'Cancelled'): ?>
                                                        <span class="badge bg-warning">Cancelled</span>
                                                    <?php elseif ($item['item_status_c'] === 'Cancelled'): ?>
                                                        <span class="badge bg-warning">Cancelled</span> 

                                                    <?php else: ?>
                                                        <a href="<?= base_url('sys/displayBiddingForm/' . $item['item_id']) ?>" class="btn btn-primary">Bid</a>
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
