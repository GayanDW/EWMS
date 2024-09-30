<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>EWMS-Login</title>  

        <!-- Vendor CSS Files -->
        <link href="<?= base_url('public/assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('public/assets/vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">
        <link href="<?= base_url('public/assets/vendor/boxicons/css/boxicons.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('public/assets/vendor/quill/quill.snow.css') ?>" rel="stylesheet">
        <link href="<?= base_url('public/assets/vendor/quill/quill.bubble.css') ?>" rel="stylesheet">
        <link href="<?= base_url('public/assets/vendor/remixicon/remixicon.css') ?>" rel="stylesheet">
        <link href="<?= base_url('public/assets/vendor/simple-datatables/style.css') ?>" rel="stylesheet">

        <!-- Template Main CSS File -->
        <link href="<?= base_url('public/assets/css/style.css') ?>" rel="stylesheet">

    </head>

    <body class="bg-info-light">

        <main>
            <div class="container">

                <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                                <div class="d-flex justify-content-center py-4">
                                    <a href="index.html" class="logo d-flex align-items-center w-auto">
                                        <img src="<?= base_url('public/assets/img/logo.png') ?>" alt="">
                                        <span class="d-none d-lg-block">EWMS</span>
                                    </a>
                                </div><!-- End Logo -->

                                <div class="card mb-3">
                                    <div class="card-body bg-light">
                                        <div class="pt-4 pb-2">
                                            <h5 class="card-title text-center pb-0 fs-4">Reset Your Password</h5>
                                            <p class="text-center small">Enter your email to reset password</p>
                                        </div>

                                        <!-- Error Message Display -->
                                        <?php if (isset($error)): ?>
                                            <div class="alert alert-danger">
                                                <p><?= $error ?></p>
                                            </div>
                                        <?php endif; ?>

                                        <?= form_open('user/sendResetLink', array("class" => "row", "novalidate" => "novalidate")) ?>
                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Enter Email Address</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input type="text" name="email" class="form-control" id="email" value="<?= set_value('username') ?>" >

                                            </div>
                                            <span class="text-danger"><?= service('validation')->getError('email') ?></span>
                                        </div>


                                        

                                        <div class="col-12">
                                            <button class="btn btn-danger w-100" type="submit">Reset</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Wish to have further support? <a href="<?php echo base_url('web#registration'); ?>">Contact support</a></p>
                                        </div>




                                        <?= form_close(); ?>



                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                </section>

            </div>
        </main><!-- End #main -->

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <!-- Vendor JS Files -->
        <script src="<?= base_url('public/assets/vendor/apexcharts/apexcharts.min.js') ?>"></script>
        <script src="<?= base_url('public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
        <script src="<?= base_url('public/assets/vendor/chart.js/chart.umd.js') ?>"></script>
        <script src="<?= base_url('public/assets/vendor/echarts/echarts.min.js') ?>"></script>
        <script src="<?= base_url('public/assets/vendor/quill/quill.min.js') ?>"></script>
        <script src="<?= base_url('public/assets/vendor/simple-datatables/simple-datatables.js') ?>"></script>
        <script src="<?= base_url('public/assets/vendor/tinymce/tinymce.min.js') ?>"></script>


        <!-- Template Main JS File -->
        <script src="<?= base_url('public/assets/js/main.js') ?>"></script>

    </body>

</html>0