


<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard Summary</h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Dashboard Summary</li>
        </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">e-Waste Summary</h5>
                        <p>View and manage your e-Waste listings.</p>
                        <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                            <div class="datatable-container">
                                <div>
                                    <h1>Enter Values</h1>
                                    <?= form_open('sys/getAllBidList'); ?>
                                    <select name="status" >
                                        <option value="all">all</option>
                                        <option value="Bids Pending">pending</option>
                                        <option value="Rejected">reject</option>
                                        <option value="Accepted">accepted</option>
                                    </select>
                                    <button type="submit">Submit</button>
                                    <?= form_close(); ?>

                                </div>

                                <table class="table datatable datatable-table">
                                    <thead>
                                        <tr>
                                            <th>Listing Number</th>
                                            <th>Item Image</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Price Option</th>
                                            <th>Amount</th>
                                            <th>Status</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($listings as $item): ?>

                                            <tr>
                                                <td><?= esc($item['item_id']); ?></td>
                                                <td><img src="<?= base_url('public/images/uploads/' . esc($item['item_image'], 'url')) ?>" alt="Item Image" width="50"></td>
                                                <td><?= esc($item['item_title']); ?></td>
                                                <td><?= esc($item['item_type']); ?></td>
                                                <td><?= esc($item['price_option']); ?></td>
                                                <td><?= esc($item['amount']); ?></td>

                                                <td><?= $item['bid_status_c']; ?></td>



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
