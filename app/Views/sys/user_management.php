


<main id="main" class="main">
    <div class="pagetitle">
        <h1>User Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('sys/dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active">User Management</li>
            </ol>
        </nav>
    </div>




    <div class="container mt-5">
        <!-- Display success message if it exists -->
        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                <?= $success; ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-12">
                <h2></h2>
                <?php if (session()->get('UserType') === 'Admin'): ?>
                    <a href="<?= base_url('/sys/addUser') ?>" class="btn btn-primary mb-3">Add New User</a>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>User Type</th>
                                <th>User Status</th>
                                <th>Approval</th>
                                <th>Actions</th>                                
                                <th>GRA Approval</th>
                                <th>GRA Requests</th>
                                <th>Admin Actions</th>
                                <th>Account Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= esc($user['UserId']) ?></td>
                                    <td><?= esc($user['UserName']) ?></td>
                                    <td><?= esc($user['email']) ?></td> <!-- Assuming 'email' is a column in your users table -->
                                    <td><?= esc($user['UserType']) ?></td>
                                    <td><?= $user['is_verified'] ? 'Verified' : 'Unverified' ?></td> <!-- Display verification status -->
                                    <td>
                                        <?= $user['is_admin_verified'] == 1 ? '<span class="badge bg-success">Approved</span>' : ($user['is_admin_verified'] == 0 ? '<span class="badge bg-warning text-dark">Pending</span>' : '<span class="badge bg-danger">Rejected</span>') ?>
                                    </td>

                                    <td>
                                        <?php if ($user['is_admin_verified'] == 0 && $user['is_verified'] == 1): ?>
                                            <a href="<?= base_url('/sys/approveUser/' . $user['UserId']) ?>" class="btn btn-success btn-sm">Approve</a>
                                            <a href="<?= base_url('/sys/rejectUser/' . $user['UserId']) ?>" class="btn btn-danger btn-sm">Reject</a>
                                        <?php elseif ($user['is_verified'] == 0): ?>
                                            <span class="badge bg-warning">Not Verified</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Action Taken</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php
                                        if ($user['is_verified'] && isset($user['gra_approval'])):
                                            ?>
                                            <span class="badge bg-success"><?= $user['gra_approval']; ?></span>
                                        <?php else: ?>
                                            User not verified or pending approval
                                        <?php endif; ?>
                                    </td>



                                    <td>
                                        <span class="badge bg-danger"><?= $user['gra_action']; ?></span>
                                    </td>

                                    <td>

                                        <?php if ($user['is_admin_verified'] == 1): ?>
                                            <!-- Reset Password Button Form -->
                                            <?= form_open('user/adminSendResetLink') ?>
                                            <input type="hidden" name="userId" value="<?= $user['UserId'] ?>" />
                                            <button class="btn btn-warning btn-sm" type="submit">Reset Password</button>
                                            <?= form_close(); ?>



                                            <!-- Activate User Button -->
                                            <a href="<?= base_url('/sys/activateUser/' . $user['UserId']) ?>" class="btn btn-primary btn-sm">Activate</a>



                                            <!-- Suspend User Button -->
                                            <a href="<?= base_url('/sys/suspendUser/' . $user['UserId']) ?>" class="btn btn-warning btn-sm">Suspend</a>

                                            <!-- Simplified Delete Button Logic -->

                                        <?php else: ?>
                                            <!-- Display badge when no actions can be made or preventing deletion of admin by admin -->
                                            <span class="badge bg-secondary">No actions can be made</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($user['account_status'] == 'Active'): ?>
                                            <span class="badge bg-success"><?= esc($user['account_status']) ?></span>
                                        <?php elseif ($user['account_status'] == 'Inactive'): ?>
                                            <span class="badge bg-warning"><?= esc($user['account_status']) ?></span>
                                        <?php elseif ($user['account_status'] == 'Suspended'): ?>
                                            <span class="badge bg-danger"><?= esc($user['account_status']) ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><?= esc($user['account_status']) ?></span>
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

