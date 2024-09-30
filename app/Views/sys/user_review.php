


<main id="main" class="main">
    <div class="pagetitle">
        <h1>User Review</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('sys/dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active">User Review</li>
            </ol>
        </nav>
    </div>

    <div class="container mt-5">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success'); ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>User Type</th>
                                <th>User Status</th>
                                <th>License Certificate</th>
                                <th>Approval</th>
                                <th>License Status</th>
                                <th>Actions</th>
                                <th>Account Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= esc($user['UserId']) ?></td>
                                    <td><?= esc($user['UserName']) ?></td>
                                    <td><?= esc($user['email']) ?></td>
                                    <td><?= esc($user['UserType']) ?></td>
                                    <td><span class="badge bg-<?= $user['is_verified'] ? 'success' : 'danger' ?>"><?= $user['is_verified'] ? 'Verified' : 'Unverified' ?></span></td>
                                    <td>
                                        <?php if ($user['UserType'] == 'e-Waste Generator'): ?>
                                            <span class="badge bg-success">Exempted</span>
                                        <?php elseif (!empty($user['license_certificate_path'])): ?>
                                            <a href="<?= base_url('public/licenses/' . $user['license_certificate_path']); ?>" target="_blank" class="btn btn-primary btn-sm">View License</a>
                                        <?php else: ?>
                                            <span class="text-muted">No License Uploaded</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if (in_array($user['UserType'], ['gov-agency', 'admin'])): ?>
                                            <span class="badge bg-success">No need approval</span>
                                        <?php elseif ($user['gra_approval'] == 'Activate this'): ?>
                                            <span class="badge bg-success">Accepted</span>
                                        <?php elseif ($user['gra_approval'] == 'rejected'): ?>
                                            <span class="badge bg-danger">Rejected</span>
                                        <?php else: ?>
                                            <?php if ($user['is_verified']): ?>
                                                <form action="<?= base_url('sys/graApproval/' . $user['UserId']) ?>" method="post">
                                                    <button name="status" value="accepted" class="btn btn-success btn-sm" type="submit">Accept</button>
                                                    <button name="status" value="rejected" class="btn btn-danger btn-sm" type="submit">Reject</button>
                                                </form>
                                            <?php else: ?>
                                                User not verified yet
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php
                                        $currentDate = new DateTime();
                                        $expiryDate = !empty($user['licenseExpiry']) ? new DateTime($user['licenseExpiry']) : null;

                                        if ($user['UserType'] == 'e-Waste Generator') {
                                            echo '<span class="badge bg-success">Exempted</span>';
                                        } elseif ($expiryDate && $expiryDate >= $currentDate) {
                                            echo '<span class="badge bg-success">Active</span>';
                                        } else {
                                            echo '<span class="badge bg-danger">Expired</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if (in_array($user['UserType'], ['gov-agency', 'admin'])): ?>
                                            <span class="badge bg-success">These are admin level accounts</span>
                                        <?php elseif (!$user['is_verified']): ?>
                                            User not verified yet
                                        <?php elseif (!$user['is_admin_verified']): ?>
                                            Admin not yet verified

                                        <?php elseif ($user['gra_approval'] == 'Activate this'): ?>

                                            <form action="<?= base_url('sys/GraAction/' . $user['UserId']) ?>" method="post">
                                                <?php if ($user['account_status'] == 'Active'): ?>
                                                    <button name="action" value="deactivate" class="btn btn-secondary btn-sm" type="submit">Deactivate</button>
                                                    <button name="action" value="suspend" class="btn btn-warning btn-sm" type="submit">Suspend</button>
                                                    <button name="action" value="reset_password" class="btn btn-info btn-sm" type="submit">Reset Password</button>
                                                <?php else: ?>
                                                    <button name="action" value="activate" class="btn btn-success btn-sm" type="submit">Activate</button>
                                                    <button name="action" value="reset_password" class="btn btn-info btn-sm" type="submit">Reset Password</button>
                                                <?php endif; ?>
                                            </form>
                                        <?php elseif ($user['gra_approval'] == 'rejected'): ?>
                                            GraAction/
                                        <?php else: ?>
                                            <?php if ($user['is_verified']): ?> 
                                                User pending GRA approval
                                            <?php else: ?>  
                                                User not verified yet
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>

                                    <td><span class="badge bg-warning"><?= $user['account_status'] ?></span></td>




                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
