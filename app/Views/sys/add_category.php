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
                    
                    <th>Category ID</th>
                    <th>Category Name</th>
                   
                </tr>
            </thead>
            <tbody>
                <tr>
   
                    <td><input type="number" name="category_ID[]" class="form-control" required></td>
                    <td><input type="text" name="category_name[]" class="form-control" required></td>
 
                </tr>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <!-- Display Submitted Materials -->
    <table class="table mt-5">
        <thead>
            <tr>
                
                <th>Material</th>
                <th>Generated Mass</th>
               
            </tr>
        </thead>
        <tbody>
            <?php if (isset($list) && is_array($list)): ?>
                <?php foreach ($list as $value): ?>
                    <tr>
                       
                        <td><?= esc($value['Material']) ?></td>
                        <td><?= esc($value['generated_mass']) ?></td>
                       
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">No categories submitted.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div>
        <a href="<?php echo base_url('sys/dashboard'); ?>" class="btn btn-primary">Exit</a> 
    </div>

</main>
