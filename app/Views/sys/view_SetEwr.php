<main id="main" class="main">
    <div class="pagetitle">
        <h1></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"></a></li>
                <li class="breadcrumb-item active"></li>
            </ol>
        </nav>
    </div>


    <div class="row">
        <!-- Check if the message is set -->
        <?php if (isset($message)) : ?>
            <div class="alert alert-success" role="alert">
                <?= $message ?>
            </div>
        <?php endif; ?>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Listing Set: <?= esc($ListingSet['ewc_listing_id']) ?> - <?= esc($ListingSet['ewc_listing_title']) ?></h4>
                    <small>Posted on <?= esc($ListingSet['date_added']) ?></small>
                </div>

                <form action="<?= base_url('sys/updateEwrInv') ?>" method="POST">

                    <div class="card-body">
                        <div class="row" >
                            <div class="col-md-6">
                                <h5 class="card-title">Collector: <?= esc($ListingSet['collector_name']) ?> </h5>
                                <p>Sub Listing Count: <?= count($Items) ?></p>
                                <p>Total Quantity in Set: <?= array_sum(array_column($Items, 'quantity')) ?></p>
                                <p>Total Weight: <?= array_sum(array_column($Items, 'weight')) ?> <?= esc($Items[0]['weight_unit']) ?></p>
                                <p>Price: <?= esc($ListingSet['selling_price']) ?></p>  
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-6">
                                    <?php if (!empty($requestStatus)): ?>

                                        <!-- Determine and display the appropriate status -->
                                        <?php
                                        $displayStatus = 'Available'; // Default status
                                        if ($requestStatus['rejection_reason'] === 'SoldOut') {
                                            $displayStatus = 'Sold Out';
                                        } elseif ($requestStatus['req_status_r'] === 'requested') {
                                            $displayStatus = 'Requested';
                                        } elseif ($requestStatus['req_status_r'] === 'accepted') {
                                            if ($requestStatus['req_status_later'] === 'collected') {
                                                $displayStatus = 'Collected';
                                            } else {
                                                $displayStatus = 'Accepted';
                                            }
                                        }
                                        ?>
                                        <p>Status: <?= $displayStatus; ?></p>

                                        <!-- Display details based on the status -->
                                        <?php if ($requestStatus['req_status_r'] === 'requested'): ?>
                                            <p>Your Note: <?= esc($requestStatus['your_note']); ?> </p>
                                            <p>Preferred Day: <?= esc($requestStatus['pref_day']); ?>, Time Slot: <?= esc($requestStatus['slot_start']); ?> to <?= esc($requestStatus['slot_end']); ?></p>
                                            <p>Alternative Day: <?= esc($requestStatus['alt_day1']); ?>, Time Slot: <?= esc($requestStatus['alt_start1']); ?> to <?= esc($requestStatus['alt_end1']); ?></p>
                                        <?php elseif ($requestStatus['req_status_r'] === 'accepted'): ?>
                                            <?php if ($requestStatus['req_status_later'] === 'collected'): ?>
                                                <!-- Specific message for when an item has been successfully collected -->
                                                <p>Item was successfully collected.</p>
                                            <?php else: ?>
                                                <p>Your Note: <?= esc($requestStatus['your_note']); ?> </p>
                                                <?php
                                                // Determine which day was accepted
                                                $acceptedDay = $requestStatus['pref_selection'] === '1' ? esc($requestStatus['pref_day']) : ($requestStatus['alt_selection'] === '1' ? esc($requestStatus['alt_day1']) : 'N/A');
                                                ?>
                                                <p>Accepted Day: <?= $acceptedDay; ?></p>
                                                <p>Payment Method: <?= esc($requestStatus['payment_method']); ?></p>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <p>Status: Available</p>
                                    <?php endif; ?>
                                </div>


                                <input type="hidden" name="ewr_req_id" value="<?= $requestStatus ? esc($requestStatus['ewr_req_id']) : ''; ?>">
                            </div>

                        </div>

                        <div class="list-group">
                            <?php foreach ($Items as $index => $item): ?>
                                <div class="list-group-item">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-md-1">
                                            <img src="<?= base_url('public/images/uploads/' . esc($item['item_image'])) ?>" class="img-fluid rounded-start" alt="Item Image">
                                        </div>
                                        <div class="col-md-11">
                                            <h5 class="mb-1"><?= esc($item['item_name']) ?> (<?= esc($item['item_type']) ?>)</h5>
                                            <p class="mb-1"><?= esc($item['description']) ?></p>
                                            <small>Quantity: <?= esc($item['quantity']) ?>, Weight: <?= esc($item['weight']) ?> <?= esc($item['weight_unit']) ?></small>
                                        </div>
                                    </div>
                                </div>
                                <!-- Adjusting the hidden inputs to be properly indexed for each item -->
                                <input type="hidden" name="items[<?= $index ?>][item_id]" value="<?= esc($item['item_id']) ?>">
                                <input type="hidden" name="items[<?= $index ?>][ewc_listing_id]" value="<?= esc($item['ewc_listing_id']) ?>">
                                <input type="hidden" name="items[<?= $index ?>][listing_set]" value="<?= esc($item['listing_set']) ?>">
                                <input type="hidden" name="items[<?= $index ?>][collector_id]" value="<?= esc($item['UserId']) ?>">
                                <input type="hidden" name="items[<?= $index ?>][item_name]" value="<?= esc($item['item_name']) ?>">
                                <input type="hidden" name="items[<?= $index ?>][item_type]" value="<?= esc($item['item_type']) ?>">
                                <input type="hidden" name="items[<?= $index ?>][quantity]" value="<?= esc($item['quantity']) ?>">
                                <input type="hidden" name="items[<?= $index ?>][weight]" value="<?= esc($item['weight']) ?>">
                                <input type="hidden" name="items[<?= $index ?>][weight_unit]" value="<?= esc($item['weight_unit']) ?>">
                                <input type="hidden" name="items[<?= $index ?>][item_image]" value="<?= esc($item['item_image']) ?>">
                                <input type="hidden" name="items[<?= $index ?>][set_buying_price]" value="<?= esc($item['selling_price']) ?>">
                                <input type="hidden" name="items[<?= $index ?>][description]" value="<?= esc($item['description']) ?>">
                            <?php endforeach; ?>
                        </div>



                        <?php if ($requestStatus): ?>
                            <?php if ($requestStatus['rejection_reason'] === 'SoldOut'): ?>
                                <span class="badge bg-success">Sold Out</span>
                            <?php elseif ($requestStatus['req_status_later'] === 'collected'): ?>
                                <span class="badge bg-success">Collected</span>
                            <?php else: ?>
                                <?php
                                switch ($requestStatus['req_status_r']):
                                    case 'accepted':
                                        ?>
                                        <button type="submit" class="btn btn-primary"">Collect</button>
                                        <button type="submit" class="btn btn-danger" formaction="<?= base_url('sys/cancelDeal/' . $ListingSet['listing_set']) ?>">Cancel Deal</button>
                                        <?php break; ?>
                                    <?php case 'requested': ?>
                                        <a href="<?= base_url('sys/viewReqEwr/' . $ListingSet['listing_set']) ?>" class="btn btn-primary">View Request</a>
                                        <a href="<?= base_url('sys/cancelRequest/' . $ListingSet['listing_set']) ?>" class="btn btn-danger">Cancel Request</a>
                                        <?php break; ?>
                                    <?php default: ?>
                                        <a href="<?= base_url('sys/displayRequestForm/' . $ListingSet['listing_set']) ?>" class="btn btn-primary">Request Item Set</a>
                                <?php endswitch; ?>
                            <?php endif; ?>
                        <?php else: ?>
                            <!-- If no requestStatus (including when req_status_r is null) -->
                            <a href="<?= base_url('sys/displayRequestForm/' . $ListingSet['listing_set']) ?>" class="btn btn-primary">Request Item Set</a>
                        <?php endif; ?>
                    </div>
                </form>


            </div>
        </div>
    </div>
</main>

