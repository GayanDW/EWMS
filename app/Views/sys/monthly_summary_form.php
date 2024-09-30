<main id="main" class="main">
    <div class="pagetitle">
        <h1>Recycling Summary Form</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('sys/dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active">Recycling Summary Form</li>
            </ol>
        </nav>
    </div>


    <div class="container">
        <div class="row">
            <!-- Form for Recovered Materials -->
            <div class="col">
                <?= form_open('sys/ewrsubmit'); ?>
                <h4>Recovered Materials</h4>
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label for="recovered_material_name" class="form-label">Recovered Material Name:</label>
                        <input type="text" class="form-control" name="recovered_material_name" id="recovered_material_name" required>
                    </div>
                    <div class="col-md-8">
                        <label for="recovered_mass" class="form-label">Recovered Mass (kg):</label>
                        <input type="number" step="0.01" class="form-control" name="recovered_mass" id="recovered_mass" required>
                    </div>
                    <div class="col-md-8">
                        <label for="recovered_unit" class="form-label">Recovered Unit:</label>
                        <input type="text" class="form-control" name="recovered_unit" id="recovered_unit" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Submit Recovered</button>
                </form>
            </div>

            <!-- Form for Disposed Materials -->
            <div class="col">
                <?= form_open('sys/ewrsubmit'); ?>
                <h4>Disposed Materials</h4>
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label for="disposed_material_name" class="form-label">Disposed Material Name:</label>
                        <input type="text" class="form-control" name="disposed_material_name" id="disposed_material_name" required>
                    </div>
                    <div class="col-md-8">
                        <label for="disposed_mass" class="form-label">Disposed Mass (kg):</label>
                        <input type="number" step="0.01" class="form-control" name="disposed_mass" id="disposed_mass" required>
                    </div>
                    <div class="col-md-8">
                        <label for="disposed_unit" class="form-label">Disposed Unit:</label>
                        <input type="text" class="form-control" name="disposed_unit" id="disposed_unit" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-danger">Submit Disposed</button>
                </form>
            </div>
        </div>
    </div>



    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <form method="GET" action="<?= base_url('sys/recycled_items'); // Adjust the URL based on your routing     ?>">
                    <div class="form-group">
                        <label for="filter_month">Select Month:</label>
                        <select name="month" id="filter_month" class="form-control">
                            <option value="">--Select Month--</option>
                            <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?= $m; ?>"><?= date('F', mktime(0, 0, 0, $m, 10)); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>
        </div>
    </div>


    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h2>Recycled Items</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>Item Type</th>
                            <th>Quantity</th>
                            <th>Weight</th>
                            <th>Status</th>
                            <th>Recycled At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recycledItems as $item): ?>
                            <tr>
                                <td><?= esc($item['item_id']); ?></td>
                                <td><?= esc($item['item_name']); ?></td>
                                <td><?= esc($item['item_type']); ?></td>
                                <td><?= esc($item['quantity']); ?></td>
                                <td><?= esc($item['weight']); ?> <?= esc($item['weight_unit']); ?></td>
                                <td><?= esc($item['status']); ?></td>
                                <td><?= esc($item['recycled_at']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
