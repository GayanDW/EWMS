<!-- Sys/show_bids.php -->
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Tracked Bids</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">List of Bids</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Bid Price Per Item</th>
                        <th>Requested Quantity</th>
                        <!-- Add other fields if necessary -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($bids as $bid): ?>
                        <tr>
                            <td><?= $bid['item_name'] ?></td>
                            <td><?= $bid['bid_price_per_item'] ?></td>
                            <td><?= $bid['requested_quantity'] ?></td>
                            <!-- Add other fields if necessary -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
