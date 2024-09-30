<main id="main" class="main">
    <div class="pagetitle">
        <h1>System Administrator</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item active">Add User</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add New User</h5>
                <span class="text-success"><?= @$msg ?></span>
                <!-- Multi Columns Form -->
                <?= form_open('admin/addUser') ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="Username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="Username" name="Username" value="<?=set_value('Username') ?>">
                        <span class="text-danger"><?= service('validation')->getError('Username') ?></span>
                    </div>
                    <div class="col-md-6">
                        <label for="Role" class="form-label">Role</label>
                        <select id="Role" class="form-select" name="Role">
                            <option>--</option>
                            <option value="E-waste Generator">E-waste Generator</option>
                            <option value="E-waste Collector">E-waste Collector</option>
                            <option value="Recycler">Recycler</option>
                            <option value="Government Agency">Government Agency</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="Email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="Email" name="Email" value="<?= set_value('Email') ?>">
                        <span class="text-danger"><?= service('validation')->getError('Email') ?></span>
                    </div>
                    <div class="col-md-6">
                        <label for="TelNo" class="form-label">Tel. No.</label>
                        <input type="text" class="form-control" id="TelNo" name="TelNo" value="<?= set_value('TelNo') ?>">
                        <span class="text-danger"><?= service('validation')->getError('TelNo') ?></span>
                    </div>
                    <div class="col-12">
                        <label for="Address" class="form-label">Address</label>
                        <textarea class="form-control" id="Address" name="Address" value="<?= set_value('Address') ?>"></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Add User</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </div><!-- End Multi Columns Form -->
                <?= form_close() ?>
            </div>
        </div> 
    </section>
</main>
