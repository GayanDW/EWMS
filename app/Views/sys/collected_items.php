
<main id="main" class="main">
    <div class="pagetitle">
        <h1></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(''); ?>"></li>
                <li class="breadcrumb-item active"></li>
            </ol>
        </nav>
    </div>

    <div class="col-lg-12">

        <form action="<?= base_url('sys/calculateSellingPrice') ?>" method="POST">
            <table class="table datatable datatable-table">
                <thead>
                    <tr>

                        <th>Item Name</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Quantity</th>
                        <th>Weight</th>
                        <th>Weight Unit</th>
                        <th>Price</th>
                        <th>Status</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                  
                    foreach ($listItems as $item):
                        ?>
                        <tr>

                            <td><?= esc($item['item_name']) ?></td>
                            <td><?= esc($item['item_type']) ?></td>
                            <td><?= esc($item['item_description']) ?></td>
                            <td><img src="<?= base_url('public/images/uploads/' . esc($item['item_image'])) ?>" alt="Item Image" width="50"></td>
                            <td><?= esc($item['quantity']) ?></td>
                            <td><?= esc($item['weight']) ?></td>
                            <td><?= esc($item['weight_unit']) ?></td>
                            <td><?= esc($item['amount']) ?></td>
                            <td><?= esc($item['collection_status']) ?></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

    </div>