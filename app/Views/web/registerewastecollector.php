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

        <main id="main">

            <!-- ======= Clients Section ======= -->


            <!-- ======= About Us Section ======= -->





            <!-- ======= Contact Section ======= -->
            <section id="contact" class="contact">
                <div class="container" data-aos="fade-up">

                    <div class="section-title">
                        <h2>Register as E-waste Collector</h2>
                        <p>Follow the steps below to accurately fill out the E-waste Collector registration form. Ensure that all fields are completed to create a unique and secure profile.</p>
                    </div>

                    <div class="row">

                        <div class="col-lg-5 d-flex align-items-stretch">
                            <div class="info">
                                <div class="info" style="border: none;">
                                    <h4 style="border: none;">How to Register as an E-waste Collector</h4>
                                    <p>Follow the steps in the registration form to create your unique and secure profile. Make sure to fill in all the required fields, including your business, contact, and service details. Review the information carefully before submitting.</p>
                                </div>

                                <!-- Keep the image related code same -->
                                <img src="/ewms/public/assets_web/img/collector.jpg" alt="Collector Image" style="border:0; width: 100%; height: 290px;">

                            </div>
                        </div>

                        <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
                            <!-- Alert Messages -->
                            <?php if (isset($msg)): ?>
                                <div class="alert alert-success">
                                    <?= $msg; ?>
                                </div>
                            <?php endif; ?>
                            <!-- End of Alert Messages -->

                            <?php helper('form'); ?>
                            <?= form_open_multipart('web/save_ewaste_collector', ['novalidate' => '', 'role' => 'form', 'class' => 'php-email-form']); ?>

                            <!-- Business Details Section -->
                            <h3>Business Details Section</h3>
                            <div class="form-group">
                                <label for="businessName">Business Name</label>
                                <input type="text" name="businessName" class="form-control" id="businessName" value="<?= set_value('businessName') ?>" required>
                                <span class="text-danger"><?= service('validation')->getError('businessName') ?></span>
                            </div>

                            <div class="form-group">
                                <label for="contactNumber">Contact Number</label>
                                <input type="tel" class="form-control" name="contactNumber" id="contactNumber" pattern="[0-9]{10}" value="<?= set_value('contactNumber') ?>" required>
                                <span class="text-danger"><?= service('validation')->getError('contactNumber') ?></span>
                            </div>

                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" name="email" id="email" value="<?= set_value('email') ?>" required>
                                <span class="text-danger"><?= service('validation')->getError('email') ?></span>
                            </div>
                            <!-- Image Upload Section -->
                            <div class="form-group">
                                <label for="profile_image">Upload Image</label>
                                <input type="file" class="form-control" name="profile_image" id="profile_image" required>
                                <span class="text-danger"><?= service('validation')->getError('profile_image') ?></span>
                            </div>                

                            <h3>Licensing and Compliance</h3>

                            <div class="form-group">
                                <label for="licenseNumber">License Number</label>
                                <input type="text" class="form-control" name="licenseNumber" id="licenseNumber" value="<?= set_value('licenseNumber') ?>" required>
                                <span class="text-danger"><?= service('validation')->getError('licenseNumber') ?></span>
                            </div>

                            <div class="form-group">
                                <label for="licenseExpiry">License Expiry Date</label>
                                <input type="date" class="form-control" name="licenseExpiry" id="licenseExpiry" value="<?= set_value('licenseExpiry') ?>" required>
                                <span class="text-danger"><?= service('validation')->getError('licenseExpiry') ?></span>
                            </div>

                            <div class="form-group">
                                <label for="license_certificate">Upload License Certificate</label>
                                <input type="file" class="form-control" name="license_certificate" id="license_certificate" required>
                                <span class="text-danger"><?= service('validation')->getError('license_certificate') ?></span>
                            </div>



                            <!-- Bank Account Details Section -->
                            <h3>Bank Account Details</h3>
                            <div class="form-group">
                                <label for="AccountNumber">Account Number</label>
                                <input type="text" class="form-control" name="AccountNumber" id="AccountNumber" value="<?= set_value('AccountNumber') ?>" required>
                                <span class="text-danger"><?= service('validation')->getError('AccountNumber') ?></span>
                            </div>

                            <div class="form-group">
                                <label for="AccountName">Account Name</label>
                                <input type="text" class="form-control" name="AccountName" id="AccountName" value="<?= set_value('AccountName') ?>" required>
                                <span class="text-danger"><?= service('validation')->getError('AccountName') ?></span>
                            </div>

                            <div class="form-group">
                                <label for="BankName">Bank Name</label>
                                <input type="text" class="form-control" name="BankName" id="BankName" value="<?= set_value('BankName') ?>" required>
                                <span class="text-danger"><?= service('validation')->getError('BankName') ?></span>
                            </div>

                            <div class="form-group">
                                <label for="BranchName">Branch Name</label>
                                <input type="text" class="form-control" name="BranchName" id="BranchName" value="<?= set_value('BranchName') ?>" required>
                                <span class="text-danger"><?= service('validation')->getError('BranchName') ?></span>
                            </div>


                            <!-- Address Details Section -->
                            <h3>Address Details Section</h3>
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
                            <h3>Account Details Section</h3>
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
            </section><!-- End Contact Section -->



        </main><!-- End #main -->

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
                            <h3>E-Waste Management System</h3>
                            <p>
                                104, Denzil Kobbekaduwa Mawatha<br>
                                Battaramulla, Sri Lanka<br><br>
                                <strong>Phone:</strong> 011-2872419, 011-2872278<br>
                                <strong>Email:</strong> complaint@cea.lk<br>
                            </p>
                        </div>

                        <div class="col-lg-3 col-md-6 footer-links">
                            <h4>Useful Links</h4>
                            <ul>
                                <li><i class="bx bx-chevron-right"></i> <a href="#home">Home</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#about">About us</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#registration">Registration</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#terms">Terms of service</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#privacy">Privacy policy</a></li>
                            </ul>
                        </div>

                        <div class="col-lg-3 col-md-6 footer-links">
                            <h4>Our Services</h4>
                            <ul>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">E-Waste Listing/Selling</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">E-Waste Purchasing</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">E-Waste Buying</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">Environmental Regulation Compliance</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">Promoting Awareness</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">Supporting Eco-Friendly E-Waste Management</a></li>
                            </ul>
                        </div>

                        <div class="col-lg-3 col-md-6 footer-links">
                            <h4>Our Social Networks</h4>
                            <p>Connect with us on our social platforms for the latest updates and insights.</p>
                            <div class="social-links mt-3">
                                <a href="https://www.facebook.com/CEASriLanka" class="facebook"><i class="bx bxl-facebook"></i></a>
                                <a href="https://www.youtube.com/channel/UCAJe39mKx2LACmYIjpUs6XQ" class="youtube"><i class="bx bxl-youtube"></i></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="container footer-bottom clearfix">
                <div class="copyright">
                    &copy; Copyright <strong><span>E-Waste Management System</span></strong>. All Rights Reserved
                </div>
                <div class="credits">
                    Designed by <a href="mailto:gayanyn@gmail.com">Gayan@EWMS</a>
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