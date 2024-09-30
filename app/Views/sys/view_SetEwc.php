<main id="main" class="main">
    <div class="pagetitle">
        <h1>View Listing Set Details</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('sys/dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active">View Listing Set</li>
            </ol>
        </nav>
    </div>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Listing Set: <?= esc($ListingSet['ewc_listing_id']) ?> - <?= esc($ListingSet['ewc_listing_title']) ?></h4>
                <small>Posted on <?= esc($ListingSet['date_added']) ?></small>
            </div>
            <div class="card-body">
                <h5 class="card-title">Collector: <?= esc($ListingSet['collector_name']) ?></h5>
                <p>Sub Listing Count: <?= count($Items) ?></p>
                <p>Total Quantity in Set: <?= array_sum(array_column($Items, 'quantity')) ?></p>
                <p>Total Weight: <?= array_sum(array_column($Items, 'weight')) ?> <?= esc($Items[0]['weight_unit']) ?></p>
                <p>Price: <?= esc($ListingSet['selling_price']) ?></p>
                <div class="list-group">
                    <?php foreach ($Items as $item): ?>
                        <div class="list-group-item">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-1">
                                    <img src="<?= base_url('public/images/uploads/' . esc($item['item_image'])) ?>" class="img-fluid rounded-start" alt="<?= esc($item['item_name']) ?>">
                                </div>
                                <div class="col-md-11">
                                    <h5 class="mb-1"><?= esc($item['item_name']) ?> (<?= esc($item['item_type']) ?>)</h5>
                                    <p class="mb-1"><?= esc($item['description']) ?></p>
                                    <small>Quantity: <?= esc($item['quantity']) ?>, Weight: <?= esc($item['weight']) ?> <?= esc($item['weight_unit']) ?></small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>



                <?php if ($status == 'Collected'): ?>
                    <span class="badge bg-success">Collected</span>
                <?php elseif ($status == 'Accepted'): ?>
                    <span class="badge bg-success">Accepted</span>
                <?php elseif ($status == 'Requested'): ?>
                    <a href="<?= base_url('sys/viewReqEwc/' . $ListingSet['listing_set']) ?>" class="btn btn-primary">Check for Requests</a> 
                <?php elseif ($status == 'Published'): ?>
                    <span class="badge bg-success">No Request received</span>
                <?php endif; ?>

                <?php
                switch ($ListingSet['list_status_r']) {
                    case 'requested':
                        echo '<a href="#" class="btn btn-warning mt-3">Cancel Request</a>';
                        break;
                    case 'accepted':
                        echo '<a href="#" class="btn btn-primary mt-3">Collect Item</a>';
                        echo '<a href="#" class="btn btn-danger mt-3">Cancel Deal</a>';
                        break;
                    case 'collected':
                        echo '<a href="#" class="btn btn-info mt-3">Feedback</a>';
                        echo '<a href="#" class="btn btn-secondary mt-3">Recycled Details</a>';
                        break;
                }
                ?>
            </div>
        </div>
    </div>
</main>
