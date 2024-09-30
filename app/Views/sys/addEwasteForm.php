<main id="main" class="main">

    <!-- Page Title and Breadcrumbs -->



    <section id="contact" class="contact">
        <div class="container-fluid" data-aos="fade-up">

            <div class="section-title">
                <h2>Add a New E-waste Listing</h2>
                <p>Follow the steps below to accurately fill out the E-waste listing form. Make sure all details are correct to ensure your listing reaches the right audience.</p>
            </div>

            <div class="row">



                <div class="col">


                    <?= form_open_multipart('sys/submitEwaste', ['novalidate' => 'novalidate', 'role' => 'form', 'class' => 'php-email-form']); ?>

                    <!-- E-waste Details Section -->
                    <h3>E-waste Details</h3>

                    <div class="form-group">
                        <label for="item_title">Item Title (Set an eye-catching title here)</label>
                        <input type="text" name="item_title" class="form-control" id="item_title" value="<?= set_value('item_title') ?>" required>
                        <span class="text-danger"><?= service('validation')->getError('item_title') ?></span>
                    </div>


                    <div class="form-group">
                        <label for="item_name">Item Name</label>
                        <input type="text" name="item_name" class="form-control" id="item_name" value="<?= set_value('item_name') ?>" required>
                        <span class="text-danger"><?= service('validation')->getError('item_name') ?></span>
                    </div>

                    <div class="form-group">
                        <label for="item_type">Item Type</label>
                        <select name="item_type" class="form-control" id="item_type" required>
                            <option value="">--Select Item Type--</option>
                            <option value="Mobile & Personal Devices" <?= set_select('item_type', 'Mobile & Personal Devices') ?>>Mobile & Personal Devices</option>
                            <option value="Computing Equipment" <?= set_select('item_type', 'Computing Equipment') ?>>Computing Equipment</option>
                            <option value="Storage & Media Devices" <?= set_select('item_type', 'Storage & Media Devices') ?>>Storage & Media Devices</option>
                            <option value="Audio & Video Equipment" <?= set_select('item_type', 'Audio & Video Equipment') ?>>Audio & Video Equipment</option>
                            <option value="Gaming & Entertainment Systems" <?= set_select('item_type', 'Gaming & Entertainment Systems') ?>>Gaming & Entertainment Systems</option>
                            <option value="Office Electronics" <?= set_select('item_type', 'Office Electronics') ?>>Office Electronics</option>
                            <option value="Networking Equipment" <?= set_select('item_type', 'Networking Equipment') ?>>Networking Equipment</option>
                            <option value="Batteries" <?= set_select('item_type', 'Batteries') ?>>Batteries</option>
                            <option value="Household Appliances" <?= set_select('item_type', 'Household Appliances') ?>>Household Appliances</option>
                            <option value="Lighting" <?= set_select('item_type', 'Lighting') ?>>Lighting</option>
                            <option value="Cables & Connectors" <?= set_select('item_type', 'Cables & Connectors') ?>>Cables & Connectors</option>
                            <option value="Miscellaneous Electronics" <?= set_select('item_type', 'Miscellaneous Electronics') ?>>Miscellaneous Electronics</option>
                        </select>
                        <span class="text-danger"><?= service('validation')->getError('item_type') ?></span>
                    </div>



                    <div class="form-group">
                        <label for="item_description">Description</label>
                        <textarea class="form-control" name="item_description" id="item_description" required><?= set_value('item_description') ?></textarea>
                        <span class="text-danger"><?= service('validation')->getError('item_description') ?></span>
                    </div>


                    <!-- Image Upload Field -->
                    <div class="form-group">
                        <label for="item_image">Upload Image</label>
                        <input type="file" class="form-control-file" name="item_image" id="item_image" required>
                        <span class="text-danger"><?= service('validation')->getError('item_image') ?></span>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" class="form-control" id="quantity" value="<?= set_value('quantity') ?>" required>
                        <span class="text-danger"><?= service('validation')->getError('quantity') ?></span>
                    </div>
                    <div class="form-group">
                        <label for="weight">Weight of all of the Items </label>
                        <input type="number" name="weight" class="form-control" id="weight"  value="<?= set_value('weight') ?>" required>
                        <span class="text-danger"><?= service('validation')->getError('weight') ?></span>
                        <div>
                            <input type="radio" id="gram" name="weight_unit" value="g" <?= set_radio('weight_unit', 'g') ?> required>
                            <label for="gram">Grams</label>
                            <input type="radio" id="kilogram" name="weight_unit" value="kg" <?= set_radio('weight_unit', 'kg') ?> required>
                            <label for="kilogram">Kilograms</label>
                        </div>
                        <span class="text-danger"><?= service('validation')->getError('weight_unit') ?></span>
                    </div>

                    <div class="form-group">
                        <label for="price_option">Price (please enter the price of one item)</label>
                        <input type="radio" id="free" name="price_option" value="free" <?= set_radio('price_option', 'free') ?>>
                        <label for="free">Free</label>
                        <input type="radio" id="expected" name="price_option" value="expected" <?= set_radio('price_option', 'expected') ?>>
                        <label for="expected">Expected</label>
                        <input type="text" class="form-control-inline" name="amount" id="amount" placeholder="Enter amount per item if expected" value="<?= set_value('amount') ?>">
                        <span class="text-danger"><?= service('validation')->getError('price_option') ?></span>
                        <span class="text-danger"><?= service('validation')->getError('amount') ?></span>
                    </div>





                    <div class="form-group">
                        <label for="pickup_location">Pickup Location (Address)</label>
                        <textarea class="form-control" name="pickup_location" id="pickup_location" required><?= set_value('pickup_location') ?></textarea>
                        <span class="text-danger"><?= service('validation')->getError('pickup_location') ?></span>
                    </div>

                    <div class="form-group"> <!-- Corrected this line -->
                        <label for="google_location">Google Location Link (Optional)</label>
                        <input type="text" class="form-control" name="google_location" id="google_location" placeholder="Paste Google location link here ">
                        <span class="text-danger"><?= service('validation')->getError('google_location') ?></span>
                    </div>



                    <div class="form-group">
                        <label for="contact_name">Contact Name (preferred)</label>
                        <input type="text" class="form-control" name="contact_name" id="contact_name" value="<?= set_value('contact_name') ?>" required>
                        <span class="text-danger"><?= service('validation')->getError('contact_name') ?></span>
                    </div>


                    <div class="form-group">
                        <label for="contact_number">Contact Number (preferred)</label>
                        <input type="text" class="form-control" name="contact_number" id="contact_number" value="<?= set_value('contact_number') ?>" required>
                        <span class="text-danger"><?= service('validation')->getError('contact_number') ?></span>
                    </div>


                    <!-- Submit Button -->
                    <div class="text-center"><button class="btn btn-success mt-2" type="submit">Add E-waste Listing</button></div>

                    <?= form_close() ?>

                </div>

            </div>
        </div>
    </section>


</main><!-- End #main -->
