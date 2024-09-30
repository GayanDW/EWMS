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
                        <?php if (empty($bids)): ?>
                            <div class="text-center">
                                <h5 class="card-title text-muted">No bids to display at this moment.</h5>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Bidder Name</th>
                                            <th>Bid Price</th>
                                            <th>Your Note</th>
                                            <th>Preferred Pickup Day</th>
                                            <th>Time Slot Start</th>
                                            <th>Time Slot End</th>
                                            <th>Alternative Pickup Day</th>
                                            <th>Alternative Time Slot Start</th>
                                            <th>Alternative Time Slot End</th>
                                            <th>Status</th>
                                            <th>Accepted Day</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($bids as $bid): ?>
                                            <tr>
                                                <td><?= esc($bid['businessName']); ?></td>
                                                <td><?= esc($bid['bid_price_per_item']); ?></td>
                                                <td><?= esc($bid['your_note']); ?></td>
                                                <td><?= esc($bid['pref_day']); ?></td>
                                                <td><?= esc($bid['slot_start']); ?></td>
                                                <td><?= esc($bid['slot_end']); ?></td>
                                                <td><?= esc($bid['alt_day1']); ?></td>
                                                <td><?= esc($bid['alt_start1']); ?></td>
                                                <td><?= esc($bid['alt_end1']); ?></td>
                                             

                                                <td>
                                                    <?php
                                                    if ($bid['bid_status_later'] == 'Collected') {
                                                        echo ($bid['bid_status_later']);
                                                    } else { 
                                                        echo esc($bid['bid_status_c']);
                                                    }
                                                    ?>
                                                </td>


                                                <td>
                                                    <?php
                                                    if ($bid['is_pref_day_selected'] == '1') {
                                                        echo esc($bid['pref_day']);
                                                    } elseif ($bid['is_alt_day1_selected'] == '1') {
                                                        echo esc($bid['alt_day1']);
                                                    } else {
                                                        echo "NA";
                                                    }
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php if ($bid['bid_status_later'] == 'Collected'): ?> <!-- Display accepted status -->
                                                        <span class="badge bg-success">Collected</span>
                                                    
                                                    <?php elseif ($bid['bid_status_c'] == 'Accepted'): ?> <!-- Display accepted status -->
                                                        <span class="badge bg-success">Accepted</span>
                                                        <form method="post" action="<?= base_url('sys/cancelDealEwg') ?>">
                                                            <input type="hidden" name="bid_id" value="<?= $bid['bid_id'] ?>">
                                                            <input type="hidden" name="item_id" value="<?= $bid['item_id'] ?>">

                                                            <!-- Accept button -->
                                                            <button type="submit" class="btn btn-warning btn-sm">Cancel Deal</button>
                                                        </form>
                                                    <?php elseif ($bid['bid_status_c'] == 'Cancelled'): ?>  
                                                        <span class="badge bg-warning">Cancelled</span>

                                                    <?php elseif ($bid['bid_status_c'] == 'Rejected'): ?> 
                                                        <span class="badge bg-danger">Rejected</span> <!-- Display rejected status -->
                                                    <?php else: ?>

                                                        <!-- Existing form for accept logic -->
                                                        <form method="post" action="<?= base_url('sys/acceptBid') ?>">
                                                            <input type="hidden" name="bid_id" value="<?= $bid['bid_id'] ?>">
                                                            <input type="hidden" name="item_id" value="<?= $bid['item_id'] ?>">

                                                            <!-- Radio buttons for preferred day -->
                                                            <div>
                                                                <input type="radio" id="pref_day_<?= $bid['bid_id'] ?>" name="day_selection" value="pref_day" required>
                                                                <label for="pref_day_<?= $bid['bid_id'] ?>">Preferred Day: <?= $bid['pref_day'] ?? 'N/A' ?></label>
                                                            </div>
                                                            <div>
                                                                <input type="radio" id="alt_day1_<?= $bid['bid_id'] ?>" name="day_selection" value="alt_day1" required>
                                                                <label for="alt_day1_<?= $bid['bid_id'] ?>">Alternative Day: <?= $bid['alt_day1'] ?? 'N/A' ?></label>
                                                            </div>
                                                            <span class="text-danger"><?= service('validation')->getError('day_selection') ?></span>

                                                            <!-- Accept button -->
                                                            <button type="submit" class="btn btn-success btn-sm">Accept</button>
                                                        </form>


                                                        <form method="post" action="<?= base_url('sys/rejectBid/' . $bid['bid_id']) ?>">
                                                            <input type="hidden" name="bid_id" value="<?= $bid['bid_id'] ?>">
                                                            <input type="hidden" name="item_id" value="<?= $item_id ?>"> 
                                                            <div>
                                                                <input type="radio" id="reject_schedule_<?= $bid['bid_id'] ?>" name="reject_reason" value="Schedule" required>
                                                                <label for="reject_schedule_<?= $bid['bid_id'] ?>">Schedule</label><br>
                                                                <input type="radio" id="reject_price_<?= $bid['bid_id'] ?>" name="reject_reason" value="Price" required>
                                                                <label for="reject_price_<?= $bid['bid_id'] ?>">Bid Price</label><br>
                                                                <input type="radio" id="reject_sold_out_<?= $bid['bid_id'] ?>" name="reject_reason" value="SoldOut" required>
                                                                <label for="reject_sold_out_<?= $bid['bid_id'] ?>">Sold Out</label><br>
                                                            </div>
                                                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                                        </form>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
