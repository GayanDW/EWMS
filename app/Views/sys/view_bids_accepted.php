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
                                                <?php if ($bid['current_status'] == 'Accepted'): ?>
                                                    <span class="badge bg-success">Accepted</span>
                                                <?php elseif ($item_status !== 'Accepted'): ?>
                                                    <form method="post" action="<?= base_url('sys/updateBidStatus') ?>">
                                                        <input type="hidden" name="bid_id" value="<?= $bid['bid_id'] ?>">
                                                        <input type="hidden" name="collector_id" value="<?= $bid['UserId'] ?>">
                                                        <input type="hidden" name="item_id" value="<?= $bid['item_id'] ?>">

                                                        <!-- Radio buttons for preferred day -->
                                                        <div>
                                                            <input type="radio" id="pref_day_<?= $bid['bid_id'] ?>" name="day_selection" value="pref_day" required>
                                                            <label for="pref_day_<?= $bid['bid_id'] ?>">Preferred Day: <?= $bid['pickupDetails']['pref_day'] ?></label>
                                                        </div>
                                                        <div>
                                                            <input type="radio" id="alt_day1_<?= $bid['bid_id'] ?>" name="day_selection" value="alt_day1" required>
                                                            <label for="alt_day1_<?= $bid['bid_id'] ?>">Alternative Day: <?= $bid['pickupDetails']['alt_day1'] ?></label>
                                                        </div>
                                                        <span class="text-danger"><?= service('validation')->getError('day_selection') ?></span>

                                                        <!-- Accept, Reject, Reschedule buttons -->
                                                        <button type="submit" class="btn btn-success btn-sm">Accept</button>
                                                        <a href="<?= base_url('sys/rejectBid/' . $bid['bid_id']) ?>" class="btn btn-danger btn-sm">Reject</a>
                                                        <a href="<?= base_url('sys/rescheduleBid/' . $bid['bid_id']) ?>" class="btn btn-warning btn-sm">Reschedule</a>
                                                    </form>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Bid Decision Finalized</span>
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
    </section>
</main>

