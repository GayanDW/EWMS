<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Category</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/'); ?>">Home</a></li>
                <li class="breadcrumb-item active">Edit Category</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="<?= base_url('sys/updateCategory') ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="Category_ID" value="<?= $category['Category_ID'] ?>">

                            <div class="form-group">
                                <label for="Item_Category">Category Name</label>
                                <input type="text" class="form-control" id="Item_Category" name="Item_Category" value="<?= $category['Item_Category'] ?>" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Category</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
