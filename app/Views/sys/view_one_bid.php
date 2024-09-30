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
                                        <th>Contact Name</th>
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
                                            <td><?= esc($bid['contact_name']); ?></td>
                                            <td><?= esc($bid['bid_price_per_item']); ?></td>
                                            <td><?= esc($bid['your_note']); ?></td>
                                            <td><?= esc($bid['pref_day']); ?></td>
                                            <td><?= esc($bid['slot_start']); ?></td>
                                            <td><?= esc($bid['slot_end']); ?></td>
                                            <td><?= esc($bid['alt_day1']); ?></td>
                                            <td><?= esc($bid['alt_start1']); ?></td>
                                            <td><?= esc($bid['alt_end1']); ?></td>
                                            <td><?= esc($bid['bid_status_c']); ?></td>
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

                                            <td><button class="btn btn-primary">View Details</button></td>
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
