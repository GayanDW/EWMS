

<main id="main" class="main">
    <style>
        .btn {
            margin-bottom: 10px;
            display: block;
        }

        .short-btn {
            width: 150px;
            white-space: nowrap;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
        }
    </style>

    <div class="pagetitle">
        <h1>Dashboard</h1>

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('sys/index'); ?>">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>

    <section class="sectionl">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">e-Waste Listings</h5>
                        <p>View and manage your e-Waste listings and bids.</p>

                        <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                            <div class="datatable-container">
                                <table class="table datatable datatable-table">
                                    <thead>
                                        <tr>
                                            <th>Listing Number</th>
                                            <th>Item Image</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Quantity</th>
                                            <th>Price Option</th>
                                            <th>Amount</th>
                                            
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($listings as $item): ?>
                                            <tr>
                                                <td><?= $item['item_id'] ?></td>
                                                <td>
                                                    <a href="<?= base_url('sys/detailedViewEwg/' . $item['item_id']) ?>">

                                                        <img src="<?= base_url('public/images/uploads/' . $item['item_image']) ?>" alt="Item Image" width="50">
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('sys/detailedViewEwg/' . $item['item_id']) ?>"><?= $item['item_title'] ?></a>
                                                </td>
                                                <td><?= $item['item_type'] ?></td>
                                                <td><?= $item['quantity'] ?></td>




                                                <td><?= $item['price_option'] ?></td>
                                                <td><?= number_format($item['amount'], 2) ?></td>
                                                


                                                <td>
                                                    <?php
                                                    // Determine the status based on item conditions
                                                    if ($item['item_status_g'] == 'Cancelled') {
                                                        echo '<span class="badge bg-danger">Cancelled</span>'; // Red background for Cancelled
                                                    } elseif ($item['collection_status'] == 'Collected') {
                                                        echo '<span class="badge bg-success">Collected</span>'; 
                                                    } elseif ($item['item_status_g'] == 'Accepted') {
                                                        echo '<span class="badge bg-primary">Accepted</span>'; // Blue background for Accepted
                                                    } elseif ($item['pending_bids'] > 0) {
                                                        echo '<span class="badge bg-warning">Bids Received</span>'; // Yellow background for Bids Received
                                                    } else {
                                                        echo '<span class="badge text-bg-secondary">No Bids Yet</span>'; // Default gray background
                                                    }
                                                    ?>
                                                </td>


                                                <td>
                                                    <a href="<?= base_url('sys/detailedViewEwg/' . $item['item_id']) ?>" class="btn btn-primary">View More</a>

                                                    <?php if ($item['nobids'] > 0): ?>
                                                        <a href="<?= base_url('sys/viewBidsEwg/' . $item['item_id']) ?>" class="btn btn-warning btn-sm">Bid Info</a>
                                                    <?php endif; ?>





                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton<?= $item['item_id'] ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= $item['item_id'] ?>">
                                                            <!-- Edit option, available for 'No Bids Yet' and 'Bids Pending' statuses -->
                                                            <!-- <?php
                                                            if ($item['pending_bids'] == 0 && $item['item_status_g'] !== 'Accepted'):
                                                                ?>
                                                                <li style="background-color: lightgreen;">
                                                                    <a class="dropdown-item" href="<?= base_url('sys/editListing/' . $item['item_id']) ?>">Edit</a>
                                                                </li>
                                                            <?php endif; ?>-->


                                                            <!-- Delete option, available for 'No Bids Yet' and 'Bids Pending' statuses -->
                                                            <?php if ($item['item_status_g'] == 'No Bids Yet' || $item['item_status_g'] == 'Bids Pending'): ?>
                                                                <li style="background-color: yellow;">
                                                                    <a class="dropdown-item" href="<?= base_url('sys/deleteListing/' . $item['item_id']) ?>" onclick="return confirm('Are you sure you want to delete this listing?');">Delete</a>
                                                                </li>
                                                            <?php endif; ?>
                                                        </ul>
                                                    </div>
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
