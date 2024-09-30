<main id="main" class="main">
    <div class="pagetitle">
        <h1>View Bids</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                <li class="breadcrumb-item active">Bids for Item #<?= esc($item_id); ?></li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Bids for Item #<?= esc($item_id); ?></h5>
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
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $itemDeleted = false; // Initialize the variable to false by default.
                                    foreach ($bids as $bid):
                                        if ($bid['bid_status_g'] === 'Deleted') {
                                            $itemDeleted = true; // If any bid is marked as deleted, set this variable to true.
                                        }
                                        $statusBadge = 'bg-warning';
                                        $statusText = 'Pending';
                                        if ($bid['bid_status_g'] === 'Accepted') {
                                            $statusText = 'Accepted';
                                            $statusBadge = 'bg-success';
                                        } elseif ($bid['bid_status_g'] === 'Automatically Declined' || $bid['bid_status_g'] === 'Bid Decision Finalized') {
                                            $statusText = 'Sold Out';
                                            $statusBadge = 'bg-danger';
                                        } elseif ($bid['bid_status_g'] === 'Deleted') {
                                            $statusText = 'Deleted By EWG';
                                            $statusBadge = 'bg-danger';
                                        }
                                        ?>


                                        <tr>
                                            <td><?= esc($bid['bidderName']); ?></td>
                                            <td><?= esc($bid['bid_price_per_item']); ?></td>
                                            <td><?= esc($bid['requested_quantity']); ?></td>
                                            <td><?= esc($bid['your_note']); ?></td>
                                            <td><?= esc($bid['pickupDetails']['pref_day']); ?></td>
                                            <td><?= esc($bid['pickupDetails']['slot_start']); ?></td>
                                            <td><?= esc($bid['pickupDetails']['slot_end']); ?></td>
                                            <td><?= esc($bid['pickupDetails']['alt_day1']); ?></td>
                                            <td><?= esc($bid['pickupDetails']['alt_start1']); ?></td>
                                            <td><?= esc($bid['pickupDetails']['alt_end1']); ?></td>
                                            <td>
                                                <?php
                                                $statusBadge = 'bg-warning';
                                                $statusText = 'Pending';
                                                if ($bid['bid_status_g'] === 'Accepted') {
                                                    $statusText = 'Accepted';
                                                    $statusBadge = 'bg-success';
                                                } elseif ($bid['bid_status_c'] === 'Bid Decision Finalized' || $bid['bid_status_g'] === 'Bid Decision Finalized') {
                                                    $statusText = 'Sold Out';
                                                    $statusBadge = 'bg-danger';
                                                } elseif ($bid['bid_status_g'] === 'Deleted') {
                                                    $statusText = 'Deleted By EWG';
                                                    $statusBadge = 'bg-danger';
                                                }
                                                ?>
                                                <span class="badge <?= $statusBadge; ?>"><?= $statusText; ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if ($itemDeleted): ?>
                            <div class="alert alert-danger" role="alert">
                                This item has been deleted by the e-waste generator.
                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="<?= base_url('feedback/giveFeedback/' . $item_id); ?>" class="btn btn-primary me-2">Give Feedback</a>
                                <a href="<?= base_url('sys/viewBidsewc/' . $item_id); ?>" class="btn btn-info">View Bid Info</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
