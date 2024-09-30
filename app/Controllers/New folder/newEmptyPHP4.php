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
                                        <th>Preferred Pickup Day</th>
                                        <th>Time Slot Start</th>
                                        <th>Time Slot End</th>
                                        <th>Preferred Pickup Day</th>
                                        <th>Alternative Time Slot Start</th>
                                        <th>Alternative Time Slot End</th>
                                        
                                        
                                        <th>Bidder Note</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bids as $bid): ?>
                                        <?php
                                            // Determine the bidder type and fetch the appropriate name

                                        ?>
                                        <tr>
                                            
                                            <td><?= $bid['bid_price_per_item'] ?></td>

                                            <td><?= $bid['your_note'] ?></td>
                                            <td>
                                                <!-- Accept, Reject, Reschedule buttons -->
                                                <a href="<?= base_url('sys/acceptBid/'.$bid['bid_id']) ?>" class="btn btn-success btn-sm">Accept</a>
                                                <a href="<?= base_url('sys/rejectBid/'.$bid['bid_id']) ?>" class="btn btn-danger btn-sm">Reject</a>
                                                <a href="<?= base_url('sys/rescheduleBid/'.$bid['bid_id']) ?>" class="btn btn-warning btn-sm">Reschedule</a>
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
