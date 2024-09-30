<main id="main" class="main">
    <div class="pagetitle">
        <h1>All Sent Bids</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                <li class="breadcrumb-item active">All Sent Bids</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Item Title</th>
                                        <th>Seller Name</th>
                                        <th>Bid Price</th>
                                        <th>Your Note</th>
                                        <th>Preferred Pickup Day</th>
                                        <th>Time Slot Start</th>
                                        <th>Time Slot End</th>
                                        <th>Alternative Pickup Day</th>
                                        <th>Alternative Time Slot Start</th>
                                        <th>Alternative Time Slot End</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bids as $bid): ?>
                                        <tr>
                                            <td><?= $bid['item_title'] ?></td>
                                            <td><?= $bid['seller_name'] ?></td>
                                            <td><?= $bid['bid_price_per_item'] ?></td>
                                            <td><?= $bid['your_note'] ?></td>
                                            <td><?= $bid['pref_day'] ?? 'N/A' ?></td>
                                            <td><?= $bid['slot_start'] ?? 'N/A' ?></td>
                                            <td><?= $bid['slot_end'] ?? 'N/A' ?></td>
                                            <td><?= $bid['alt_day1'] ?? 'N/A' ?></td>
                                            <td><?= $bid['alt_start1'] ?? 'N/A' ?></td>
                                            <td><?= $bid['alt_end1'] ?? 'N/A' ?></td>
                                            <td><?= $bid['bid_status_c'] ?></td>
                                            <td>
                                                <!-- Add your action buttons here -->
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($bids)): ?>
                                        <tr>
                                            <td colspan="13" class="text-center">No bids have been sent.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
