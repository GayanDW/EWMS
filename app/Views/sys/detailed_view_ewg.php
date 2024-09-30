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

                        <!-- Flash Message Display -->
                        <?php if (session()->getFlashdata('message')): ?>
                            <div class="alert alert-success" role="alert">
                                <?= session()->getFlashdata('message'); ?>
                            </div>
                        <?php endif; ?>

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



                                    <?php if ($item['collection_status'] == 'Collected'): ?>
                                        <span class="badge bg-success">Collected</span>
                                    <?php elseif ($item['item_status_g'] == 'Accepted'): ?>
                                        <!-- Cancel Deal Button (Visible when item is accepted) -->
                                        <a href="<?= base_url('sys/cancelDeal/' . $item['item_id']) ?>" class="btn btn-danger me-2">Cancel Deal</a>
                                    <?php elseif ($item['item_status_g'] == 'Bids Received'): ?>
                                        <!-- View Bids Button (Visible when bids are received) -->
                                        <a href="<?= base_url('sys/viewBids/' . $item['item_id']) ?>" class="btn btn-warning me-2">View Bids</a>
                                    <?php endif; ?>

                                    <!-- Edit and Delete Buttons (Visible for 'No Bids Yet' and 'Bids Received' statuses) -->
                                    <?php if (in_array($item['item_status_g'], ['No Bids Yet', 'Bids Received'])): ?>
                                        <!--<a href="<?= base_url('sys/editListing/' . $item['item_id']) ?>" class="btn btn-success me-2">Edit</a>-->
                                        <a href="<?= base_url('sys/deleteListing/' . $item['item_id']) ?>" class="btn btn-secondary" onclick="return confirm('Are you sure you want to delete this listing?');">Delete</a>
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
