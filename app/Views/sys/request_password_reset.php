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

                                <!-- View: sys/request_password_reset.php -->
                                <form action="<?= base_url('/sys/handlePasswordResetRequest') ?>" method="post">
                                    <label for="email">Email Address:</label>
                                    <input type="email" id="email" name="email" required>
                                    <button type="submit">Ask Password Reset</button>
                                </form>

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