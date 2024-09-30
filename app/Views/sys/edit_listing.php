<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit E-Waste Listing</title>
        <!-- Include any additional CSS or head content as needed -->
        <link rel="stylesheet" href="/path/to/your/css"> <!-- Update the path to your CSS file -->
    </head>
    <body>

        <main id="main" class="main">
            <div class="pagetitle">
                <h1>Edit E-waste Listing</h1>
                <!-- Breadcrumbs or other navigation elements -->
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Edit E-waste Listing</li>
                    </ol>
                </nav>
            </div>

            <section class="section">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <?php if (session()->getFlashdata('message')): ?>
                                    <div class="alert alert-success">
                                        <?= session()->getFlashdata('message'); ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Display validation errors, if any -->
                                <?php if (isset($validation)): ?>
                                    <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
                                <?php endif; ?>

                                <!-- Form to edit the listing -->
                                <?= form_open('sys/editListing/' . $listing['item_id']) ?>

                                <div class="form-group">
                                    <label for="item_title">Item Title</label>
                                    <input type="text" name="item_title" id="item_title" value="<?= esc($listing['item_title']) ?>" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="item_description">Item Description</label>
                                    <textarea name="item_description" id="item_description" class="form-control" required><?= esc($listing['item_description']) ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" name="quantity" id="quantity" value="<?= esc($listing['quantity']) ?>" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="weight">Weight</label>
                                    <input type="number" name="weight" id="weight" value="<?= esc($listing['weight']) ?>" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="price_option">Price Option</label>
                                    <select name="price_option" id="price_option" class="form-control" required>
                                        <option value="free" <?= $listing['price_option'] == 'free' ? 'selected' : '' ?>>Free</option>
                                        <option value="expected" <?= $listing['price_option'] == 'expected' ? 'selected' : '' ?>>Expected</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="text" name="amount" id="amount" value="<?= esc($listing['amount']) ?>" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="pickup_location">Pickup Location</label>
                                    <textarea name="pickup_location" id="pickup_location" class="form-control" required><?= esc($listing['pickup_location']) ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="google_location">Google Location Link</label>
                                    <input type="text" name="google_location" id="google_location" value="<?= esc($listing['google_location']) ?>" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="contact_name">Contact Name</label>
                                    <input type="text" name="contact_name" id="contact_name" value="<?= esc($listing['contact_name']) ?>" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="contact_number">Contact Number</label>
                                    <input type="text" name="contact_number" id="contact_number" value="<?= esc($listing['contact_number']) ?>" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Update Listing</button>

                                <?= form_close() ?>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

    </body>
</html>
