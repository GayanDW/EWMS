<main id="main" class="main">
    <div class="pagetitle">
        <h1>Add Category</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/'); ?>">Home</a></li>
                <li class="breadcrumb-item active">Add Category</li>
            </ol>
        </nav>
        <?php if (session()->has('message')): ?>
            <div class="alert alert-success">
                <?= session('message'); ?>
            </div>
        <?php endif; ?>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <?= form_open('sys/saveCategory', ['novalidate' => 'novalidate', 'role' => 'form']); ?>

                        <div class="form-group">
                            <label for="Item_Category">Category</label>
                            <input type="text" class="form-control" id="Item_Category" name="Item_Category" >
                            <span class="text-danger"><?= service('validation')->getError('Item_Category') ?></span>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>