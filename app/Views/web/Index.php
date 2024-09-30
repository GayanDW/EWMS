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
                        <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                        //<li><a class="nav-link scrollto" href="#about">About</a></li>



                        <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
                        <li><a class="nav-link scrollto" href="#">Gallery</a></li>
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

        <main id="main">

            <!-- ======= Hero Section ======= -->
            <section id="hero" class="d-flex align-items-center">

                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                            <h1>The E-Waste Management Solution for Sri Lanka</h1>
                            <h2>Our web-based platform simplifies e-waste management, providing a user-friendly and secure way to dispose of and recycle electronic waste for everyone in Sri Lanka.</h2>
                            <div class="d-flex justify-content-center justify-content-lg-start">
                                <a href="#about" class="btn-get-started scrollto">Get Started</a>
                                <!-- Replaced the YouTube link with the local video -->
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





            <!-- ======= About Us Section ======= -->
            <section id="about" class="about">
                <div class="container" data-aos="fade-up">

                    <div class="section-title">
                        <h2>About Us</h2>
                        <p>Dedicated to Revolutionizing E-Waste Management in Sri Lanka</p>
                    </div>

                    <div class="row content">
                        <div class="col-lg-6">
                            <p>
                                We are at the forefront of addressing the growing challenge of electronic waste in Sri Lanka. Our mission is to provide a comprehensive solution for e-waste management that is both environmentally responsible and user-friendly.
                            </p>
                            <ul>
                                <li><i class="bi bi-check-circle"></i> Easy and secure registration for all users.</li>
                                <li><i class="bi bi-check-circle"></i> Seamless connection between e-waste generators, collectors, and recyclers.</li>
                                <li><i class="bi bi-check-circle"></i> Smart tools for analyze e-waste management.</li>
                            </ul>
                        </div>
                        <div class="col-lg-6 pt-4 pt-lg-0">
                            <p>
                                Our platform caters to a wide range of users, from individuals looking to dispose of their electronic waste responsibly, to businesses and government agencies seeking efficient recycling and compliance solutions. We are committed to making e-waste management accessible, transparent, and sustainable.
                            </p>
                            <a href="#" class="btn-learn-more">Learn More</a>
                        </div>
                    </div>




                </div>
            </section><!-- End About Us Section -->





            <!-- ======= Features Section ======= -->
            <section id="features" class="features">
                <div class="container" data-aos="fade-up">
                    <div class="row">
                        <div class="col-lg-6 d-flex align-items-center" data-aos="fade-right" data-aos-delay="100">
                            <!-- Replace with a relevant image to e-waste management -->
                            <img src="<?= base_url('public/assets_web/img/ewms2.png') ?>" class="img-fluid" alt="E-Waste Management" style="width: 100%; height: auto;">
                        </div>
                        <div class="col-lg-6 pt-4 pt-lg-0 content" data-aos="fade-left" data-aos-delay="100">
                            <h3>Features of Our E-Waste Management System</h3>
                            <p class="fst-italic">
                                Our platform offers a comprehensive set of features designed to optimize e-waste management for various stakeholders.
                            </p>

                            <div class="skills-content">
                                <div class="feature">
                                    <i class="bi bi-arrow-up-right-square feature-icon"></i>
                                    <h4>E-Waste Listing/Selling</h4>
                                    <p>Enables generators to list and sell e-waste, providing a platform for efficient and responsible disposal.</p>
                                </div>

                                <div class="feature">
                                    <i class="bi bi-cart4 feature-icon"></i>
                                    <h4>E-Waste Purchasing</h4>
                                    <p>Facilitates collectors and recyclers in purchasing e-waste, streamlining the acquisition process.</p>
                                </div>

                                <div class="feature">
                                    <i class="bi bi-bag-check feature-icon"></i>
                                    <h4>E-Waste Buying</h4>
                                    <p>Offers a marketplace for buyers to acquire e-waste for recycling and repurposing, promoting a circular economy.</p>
                                </div>

                                <div class="feature">
                                    <i class="bi bi-shield-check feature-icon"></i>
                                    <h4>Environmental Regulation Compliance</h4>
                                    <p>Assists in adhering to environmental regulations, ensuring that e-waste management adheres to legal standards.</p>
                                </div>

                                <div class="feature">
                                    <i class="bi bi-megaphone feature-icon"></i>
                                    <h4>Promoting Awareness</h4>
                                    <p>Raises public awareness about the importance of e-waste management and sustainable practices.</p>
                                </div>

                                <div class="feature">
                                    <i class="bi bi-leaf feature-icon"></i>
                                    <h4>Supporting Eco-Friendly E-Waste Management</h4>
                                    <p>Encourages eco-friendly practices in e-waste management, contributing to environmental protection.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!-- End Features Section -->



            <!-- ======= Registration Section ======= -->
            <section id="registration" class="registration section-bg">
                <div class="container" data-aos="fade-up">

                    <div class="section-title">
                        <h2>Registration</h2>
                        <p>Join our E-Waste Management System to contribute to a sustainable and environmentally friendly e-waste management process. Select your role to get started.</p>
                    </div>

                    <div class="row">
                        <div class="col-xl-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-user"></i></div>
                                <h4><a href="">E-Waste Generator</a></h4>
                                <p>Register to responsibly dispose of e-waste, manage listings and bids, and access educational resources. Ideal for individuals and organizations looking to contribute to eco-friendly practices.</p>
                                <a class="btn btn-primary" href="<?= site_url('web/register_ewastegenerator') ?>">Register as Generator</a>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-archive"></i></div> <!-- Changed icon for visibility -->
                                <h4><a href="">E-Waste Collector</a></h4>
                                <p>As a collector, play a crucial role in the e-waste management process by efficiently collecting and transporting e-waste for recycling or proper disposal.</p>
                                <a class="btn btn-primary" href="<?= site_url('web/register_ewastecollector') ?>">Register as Collector</a>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in" data-aos-delay="300">
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-recycle"></i></div>
                                <h4><a href="">E-Waste Recycler</a></h4>
                                <p>Contribute to the circular economy by recycling e-waste. Transform waste into valuable resources, reducing environmental impact.</p>
                                <a class="btn btn-primary" href="<?= site_url('web/register_ewasterecycler') ?>">Register as Recycler</a>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in" data-aos-delay="400">
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-building-house"></i></div>
                                <h4><a href="">Government Agency</a></h4>
                                <p>Enable effective regulation and oversight of e-waste management practices. Ensure compliance and promote sustainable initiatives.</p>
                                <a class="btn btn-primary" href="<?= site_url('web/register_govagency') ?>">Register as Agency</a>
                            </div>
                        </div>

                    </div>

                </div>
            </section><!-- End Registration Section -->







            <!-- ======= Contact Section ======= -->
            <section id="contact" class="contact">
                <div class="container aos-init aos-animate" data-aos="fade-up">

                    <div class="section-title">
                        <h2>Contact</h2>
                        <p>Contact the Central Environmental Authority of Sri Lanka for inquiries related to environmental regulations, licensing, and e-waste management. The CEA is committed to integrating environmental considerations into the development process of the country and ensuring compliance with environmental standards.</p>
                    </div>

                    <div class="row">


                        </section>


                        </main><!-- End #main -->

                        <!-- ======= Footer ======= -->
                        <!-- ======= Footer ======= -->
                        <footer id="footer">

                            <div class="footer-newsletter">
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-6">
                                            <h4></h4>
                                            <p></p>

                                        </div>
                                    </div>
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
                        <script src="<?= base_url('public/assets_web/vendor/php-email-form/validate.js') ?>"></script>

                        <!-- Template Main JS File -->
                        <script src="<?= base_url('public/assets_web/js/main.js') ?>"></script>

                        </body>

                        </html>