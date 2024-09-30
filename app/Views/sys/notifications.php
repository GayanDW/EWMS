<main id="main" class="main">
    <div class="pagetitle">
        <h1>Notifications</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('sys/dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active">Notifications</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4>Your Notifications</h4>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($notifications as $notification): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= esc($notification['message']); ?>
                            <small class="text-muted"><?= date('Y-m-d H:i', strtotime($notification['created_at'])); ?></small>
                            <div>
                                <a href="<?= base_url('feedback/giveFeedback/' . $notification['item_id']); ?>" class="btn btn-primary btn-sm"></a>
                                <a href="<?= base_url('sys/viewBidsewc/' . $notification['item_id']); ?>" class="btn btn-info btn-sm"></a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>
</main>
