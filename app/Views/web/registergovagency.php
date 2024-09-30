<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>E-Waste Management System</title>
        <meta content="" name="description">
        <meta content="" name="keywords">

        <!-- Favicons -->
        <link href="<?= base_url('public/assets_web/img/favicon.png') ?>" rel="icon">
        <link href="<?= base_url('public/assets_web/img/apple-touch-icon.png') ?>" rel="apple-touch-icon">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="<?= base_url('public/assets_web/vendor/aos/aos.css" rel="stylesheet') ?>">
        <link href="<?= base_url('public/assets_web/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('public/assets_web/vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">
        <link href="<?= base_url('public/assets_web/vendor/boxicons/css/boxicons.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('public/assets_web/vendor/glightbox/css/glightbox.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('public/assets_web/vendor/remixicon/remixicon.css') ?>" rel="stylesheet">
        <link href="<?= base_url('public/assets_web/vendor/swiper/swiper-bundle.min.css') ?>" rel="stylesheet">

        <!-- Template Main CSS File -->
        <link href="<?= base_url('public/assets_web/css/style.css') ?>" rel="stylesheet">

        <!-- =======================================================
        * Template Name: Arsha
        * Updated: Aug 30 2023 with Bootstrap v5.3.1
        * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
        * Author: G.G.D.Wimalasena
        * License: https://bootstrapmade.com/license/
        ======================================================== -->
    </head>

    <body>

        <!-- ======= Header ======= -->
        <header id="header" class="fixed-top ">
            <div class="container d-flex align-items-center">

                <h1 class="logo me-auto"><a href="index.html">E-Waste Management System</a></h1>
                <!-- Uncomment below if you prefer to use an image logo -->
                <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

                <nav id="navbar" class="navbar">
                    <ul>
                        <li><a class="nav-link scrollto active" href="/ewms/web/">Home</a></li>
                       
                        <li class="dropdown"><a href="#registration"><span>Registration</span> <i class="bi bi-chevron-down"></i></a>
                            <ul>
                                <li><a href="<?= site_url('web/register_ewastegenerator') ?>">Register as e-Waste Generator</a></li>
                                <li><a href="<?= site_url('web/register_ewastecollector') ?>">Register as e-Waste Collector</a></li>
                                <li><a href="<?= site_url('web/register_ewasterecycler') ?>">Register as e-Waste Recycler</a></li>
                                <li><a href="<?= site_url('web/register_govagency') ?>">Register as Government Agency</a></li>
                            </ul>
                        </li>
                        <li><a class="getstarted scrollto" href="<?php echo base_url('/user/login'); ?>">Login</a></li>

                    </ul>
                    <i class="bi bi-list mobile-nav-toggle"></i>
                </nav><!-- .navbar -->

            </div>
        </header><!-- End Header -->

        <!-- ======= Hero Section ======= -->
        <section id="hero" class="d-flex align-items-center">

            <div class="container">
                <div class="row">
                    <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                        <h1>The E-Waste Management Solution for Sri Lanka</h1>
                        <h2>Our web-based platform simplifies e-waste management, providing a user-friendly and secure way to dispose of and recycle electronic waste for everyone in Sri Lanka.</h2>
                        <div class="d-flex justify-content-center justify-content-lg-start">
                            <a href="#about" class="btn-get-started scrollto">Get Started</a>
                            <!-- Replace the YouTube link with the local video -->
                            <a href="<?= base_url('public/assets_web/video/videoewms.mp4') ?>" class="glightbox btn-watch-video" data-aos="zoom-in" data-aos-delay="200">
                                <i class="bi bi-play-circle"></i><span>Watch Video</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2 hero-img1" data-aos="zoom-in" data-aos-delay="200">
                        <img src="<?= base_url('public/assets_web/img/hero-img1.jpg') ?>" class="img-fluid animated" alt="">
                    </div>
                </div>
            </div>


        </section><!-- End Hero -->



        <!-- Registration Form Section -->
        <section id="registration" class="contact">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Register</h2>
                    <p>Complete the form below to register.</p>
                </div>

                <div class="row">
                    <div class="col-lg-12 d-flex align-items-stretch">

                        <?= form_open_multipart('web/save_gov_agency', ['novalidate' => '', 'role' => 'form', 'class' => 'php-email-form']); ?>

                        <!-- Personal Details Section -->
                        <h3>Personal Details</h3>
                        <div class="form-group">
                            <label for="branchName">Branch Name</label>
                            <input type="text" name="branchName" class="form-control" id="branchName" value="<?= set_value('branchName') ?>" required>
                            <span class="text-danger"><?= service('validation')->getError('branchName') ?></span>
                        </div>
                        <div class="form-group">
                            <label for="branchCode">Branch Code</label>
                            <input type="text" name="branchCode" class="form-control" id="branchCode" value="<?= set_value('branchCode') ?>" required>
                            <span class="text-danger"><?= service('validation')->getError('branchCode') ?></span>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" name="email" id="email" value="<?= set_value('email') ?>" required>
                            <span class="text-danger"><?= service('validation')->getError('email') ?></span>
                        </div>
                        <div class="form-group">
                            <label for="contactNumber">Contact Number</label>
                            <input type="tel" class="form-control" name="contactNumber" id="contactNumber" value="<?= set_value('contactNumber') ?>" required>
                            <span class="text-danger"><?= service('validation')->getError('contactNumber') ?></span>
                        </div>

                        <!-- Address Details Section -->
                        <h3>Address Details</h3>
                        <div class="form-group">
                            <label for="streetAddress">Street Address</label>
                            <input type="text" class="form-control" name="streetAddress" id="streetAddress" value="<?= set_value('streetAddress') ?>" required>
                            <span class="text-danger"><?= service('validation')->getError('streetAddress') ?></span>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" name="city" id="city" value="<?= set_value('city') ?>" required>
                            <span class="text-danger"><?= service('validation')->getError('city') ?></span>
                        </div>
                        <div class="form-group">
                            <label for="District" class="form-label">District</label>
                            <select id="District" name="district" class="form-select" required>
                                <option value="">Select a District</option>
                                <?php foreach ($district_list as $district) { ?>
                                    <option value="<?= $district['DistrictName'] ?>" <?= set_select('district', $district['DistrictName']) ?>><?= $district['DistrictName'] ?></option>
                                <?php } ?>
                            </select>
                            <span class="text-danger"><?= service('validation')->getError('district') ?></span>
                        </div>

                        <!-- Account Details Section -->
                        <h3>Account Details</h3>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" id="username" value="<?= set_value('username') ?>" required>
                            <span class="text-danger"><?= service('validation')->getError('username') ?></span>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                            <span class="text-danger"><?= service('validation')->getError('password') ?></span>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center"><button type="submit">Register</button></div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </section>



        <!-- ======= Footer ======= -->
        <footer id="footer">

            <div class="footer-newsletter">
                <div class="container">
                    <!-- Alert Message for Accidental Navigation -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert alert-info text-center" role="alert">
                                If you're not looking to register or if you belong to another user type, you can easily go back to the <a href="/ewms/web/" class="alert-link">home page</a> and feel free to continue with the e-waste management system.
                            </div>
                        </div>
                    </div>
                    <!-- End Alert Message -->
                </div>
            </div>


            <div class="footer-top">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-3 col-md-6 footer-contact">
                            <h3>Arsha</h3>
                            <p>
                                A108 Adam Street <br>
                                New York, NY 535022<br>
                                United States <br><br>
                                <strong>Phone:</strong> +1 5589 55488 55<br>
                                <strong>Email:</strong> info@example.com<br>
                            </p>
                        </div>

                        <div class="col-lg-3 col-md-6 footer-links">
                            <h4>Useful Links</h4>
                            <ul>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
                            </ul>
                        </div>

                        <div class="col-lg-3 col-md-6 footer-links">
                            <h4>Our Services</h4>
                            <ul>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
                            </ul>
                        </div>

                        <div class="col-lg-3 col-md-6 footer-links">
                            <h4>Our Social Networks</h4>
                            <p>Cras fermentum odio eu feugiat lide par naso tierra videa magna derita valies</p>
                            <div class="social-links mt-3">
                                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                                <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="container footer-bottom clearfix">
                <div class="copyright">
                    &copy; Copyright <strong><span>Arsha</span></strong>. All Rights Reserved
                </div>
                <div class="credits">
                    <!-- All the links in the footer should remain intact. -->
                    <!-- You can delete the links only if you purchased the pro version. -->
                    <!-- Licensing information: https://bootstrapmade.com/license/ -->
                    <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/ -->
                    Designed by <a href="mailto:gayanyn@gmail.com">BootstrapMade</a>
                </div>
            </div>
        </footer><!-- End Footer -->

        <div id="preloader"></div>
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <!-- Vendor JS Files -->
        <script src="<?= base_url('public/assets_web/vendor/aos/aos.js') ?>"></script>
        <script src="<?= base_url('public/assets_web/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
        <script src="<?= base_url('public/assets_web/vendor/glightbox/js/glightbox.min.js') ?>"></script>
        <script src="<?= base_url('public/assets_web/vendor/isotope-layout/isotope.pkgd.min.js') ?>"></script>
        <script src="<?= base_url('public/assets_web/vendor/swiper/swiper-bundle.min.js') ?>"></script>
        <script src="<?= base_url('public/assets_web/vendor/waypoints/noframework.waypoints.js') ?>"></script>


        <!-- Template Main JS File -->
        <script src="<?= base_url('public/assets_web/js/main.js') ?>"></script>

    </body>

</html>