<main id="main" class="main">
    <div class="pagetitle">
        <h1>Material Entry Form</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('sys/dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active">Material Entry Form</li>
            </ol>
        </nav>
    </div>

    <form action="<?= site_url('sys/submit_materials') ?>" method="post">
        <table id="materialsTable" class="table">
            <thead>
                <tr>
                    <th>Material Type</th>
                    <th>Material</th>
                    <th>Generated Mass</th>
                    <th>Unit</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="Material_Type[]" class="form-control">
                            <option value="Recovered Material">Recovered Material</option>
                            <option value="Disposal Material">Disposal Material</option>
                        </select>
                    </td>
                    <td><input type="text" name="Material[]" class="form-control" required></td>
                    <td><input type="number" name="generated_mass[]" class="form-control" required></td>
                    <td>
                        <select name="mass_unit[]" class="form-control">
                            <option value="g">g</option>
                            <option value="kg">kg</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <!-- Display Submitted Materials -->
    <table class="table mt-5">
        <thead>
            <tr>
                <th>Material Type</th>
                <th>Category ID</th>
                <th>Category Name</th>
                <th>Unit</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($list) && is_array($list)): ?>
                <?php foreach ($list as $value): ?>
                    <tr>
                        <td><?= esc($value['Material_Type']) ?></td>
                        <td><?= esc($value['Material']) ?></td>
                        <td><?= esc($value['generated_mass']) ?></td>
                        <td><?= esc($value['mass_unit']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No materials submitted.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div>
        <a href="<?php echo base_url('sys/viewEwrInventory'); ?>" class="btn btn-primary">Exit</a> 
    </div>

</main>
