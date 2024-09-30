<main id="main" class="main">
    <div class="pagetitle">
        <h1>Deleted Categories</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/'); ?>">Home</a></li>
                <li class="breadcrumb-item active">Deleted Categories</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Category ID</th>
                                    <th>Item Category</th>
                                    <th>Deleted At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?= $category['Category_ID']; ?></td>
                                    <td><?= $category['Item_Category']; ?></td>
                                    <td><?= $category['deleted_at'] ? $category['deleted_at'] : 'N/A'; ?></td>
                                    <td>
                                        <?php if ($category['deleted_at']): ?>
                                            <a href="<?= base_url('/sys/restoreCategory/' . $category['Category_ID']); ?>" class="btn btn-success">Restore</a>
                                            <a href="<?= base_url('/sys/permanentlyDeleteCategory/' . $category['Category_ID']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure? This cannot be undone!')">Permanently Delete</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
