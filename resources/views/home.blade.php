<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Home - SafeZone</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="front/assets/img/favicon.png" rel="icon">
    <link href="front/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="front/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="front/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="front/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="front/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="front/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="front/assets/css/main.css" rel="stylesheet">

</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-xl-0">
                <h1 class="sitename">{{ config('app.name') }}</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <!-- button trigger track modal -->
            <a class="btn-getstarted" data-bs-toggle="modal" data-bs-target="#trackCaseModal">
                Track a Case
            </a>
            <!-- Button trigger modal -->
            <a class="btn-getstarted" data-bs-toggle="modal" data-bs-target="#reportCaseModal">
                Report a Case
            </a>

        </div>
    </header>

    <!-- Track Case Modal -->
    <div class="modal fade" id="trackCaseModal" tabindex="-1" aria-labelledby="trackCaseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="trackCaseModalLabel">Track Your Case</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="trackCaseForm" action="{{ route('case.track') }}" method="POST">
                        @csrf
                        <!-- Case ID -->
                        <div class="mb-3">
                            <label for="caseNumber" class="form-label">Case ID</label>
                            <input type="text" class="form-control" id="caseNumber" name="case_number" placeholder="Enter your Case ID (e.g. SZC-2025-001)" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="trackCaseForm" class="btn btn-primary">Track Case</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Report Case Modal -->
    <div class="modal fade" id="reportCaseModal" tabindex="-1" aria-labelledby="reportCaseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="reportCaseModalLabel">Report a Case</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="reportCaseForm" action="{{ route('user.reportCases.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Your Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>

                        <!-- Name of Survivor -->
                        <div class="mb-3">
                            <label for="survivorName" class="form-label">Name of Survivor</label>
                            <input type="text" class="form-control" id="survivorName" name="survivor_name" placeholder="Enter name of survivor" required>
                        </div>

                        <!-- phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required>
                        </div>

                        <!-- Type of GBV -->
                        <div class="mb-3">
                            <label for="type" class="form-label">Type of GBV</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="" selected disabled>Select type</option>
                                <option value="physical">Physical</option>
                                <option value="sexual">Sexual</option>
                                <option value="psychological">Psychological</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description of Incident</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>

                        <!-- Location -->
                        <div class="mb-3">
                            <label for="location" class="form-label">Location (Optional)</label>
                            <input type="text" class="form-control" id="location" name="location" placeholder="Enter location">
                        </div>

                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="reportCaseForm" class="btn btn-primary">Submit Case</button>
                </div>
            </div>
        </div>
    </div>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row align-items-center">
                    <!-- Left Content -->
                    <div class="col-lg-6">
                        <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
                            <div class="company-badge mb-4">
                                <i class="bi bi-shield-lock-fill me-2"></i>
                                Safe, Confidential & Timely GBV Reporting
                            </div>

                            <h1 class="mb-4">
                                Report. Track. <br>
                                Get Support. <br>
                                <span class="accent-text">SafeZone Rwanda</span>
                            </h1>

                            <p class="mb-4 mb-md-5">
                                SafeZone is a secure platform that empowers survivors and witnesses
                                to report Gender-Based Violence cases anonymously and confidentially.
                                RIB Agents and Medical Staff ensure timely response and survivor support.
                            </p>

                            <div class="hero-buttons">
                                <a href="#reportCase" data-bs-toggle="modal" data-bs-target="#reportCaseModal" class="btn btn-primary me-0 me-sm-2 mx-1">
                                    Report a Case
                                </a>
                                <a href="#trackCase" data-bs-toggle="modal" data-bs-target="#trackCaseModal" class="btn btn-outline-primary mt-2 mt-sm-0">
                                    <i class="bi bi-search me-1"></i>
                                    Track Your Case
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right Image -->
                    <div class="col-lg-6">
                        <div class="hero-image" data-aos="zoom-out" data-aos-delay="300">
                            <img src="assets/img/safezone-hero.png" alt="SafeZone Reporting" class="img-fluid rounded shadow">

                            <div class="customers-badge">
                                <div class="customer-avatars">
                                    <img src="assets/img/avatar-1.webp" alt="Agent" class="avatar">
                                    <img src="assets/img/avatar-2.webp" alt="Medical Staff" class="avatar">
                                    <img src="assets/img/avatar-3.webp" alt="Survivor" class="avatar">
                                    <span class="avatar more">+RIB</span>
                                </div>
                                <p class="mb-0 mt-2">Trusted by survivors, supported by RIB & medical teams.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="row stats-row gy-4 mt-5" data-aos="fade-up" data-aos-delay="500">
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-item">
                            <div class="stat-icon"><i class="bi bi-shield-fill-check"></i></div>
                            <div class="stat-content">
                                <h4>100% Confidential</h4>
                                <p class="mb-0">Your privacy is protected</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-item">
                            <div class="stat-icon"><i class="bi bi-alarm"></i></div>
                            <div class="stat-content">
                                <h4>Real-Time Alerts</h4>
                                <p class="mb-0">Instant RIB notifications</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-item">
                            <div class="stat-icon"><i class="bi bi-people"></i></div>
                            <div class="stat-content">
                                <h4>Multi-Stakeholder</h4>
                                <p class="mb-0">RIB, Medical & Community</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-item">
                            <div class="stat-icon"><i class="bi bi-file-earmark-text"></i></div>
                            <div class="stat-content">
                                <h4>Case Tracking</h4>
                                <p class="mb-0">Follow your case anytime</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section>
        <!-- /Hero Section -->


        <!-- Features Section -->
        <section id="features" class="features section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Platform Features</h2>
                <p>A secure and supportive platform to report, track, and manage Gender-Based Violence (GBV) cases.</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="d-flex justify-content-center">

                    <ul class="nav nav-tabs" data-aos="fade-up" data-aos-delay="100">

                        <li class="nav-item">
                            <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#features-tab-1">
                                <h4>Report Cases</h4>
                            </a>
                        </li><!-- End tab nav item -->

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-2">
                                <h4>Track Progress</h4>
                            </a>
                        </li><!-- End tab nav item -->

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-3">
                                <h4>Evidence & Notifications</h4>
                            </a>
                        </li><!-- End tab nav item -->

                    </ul>

                </div>

                <div class="tab-content" data-aos="fade-up" data-aos-delay="200">

                    <!-- Report Cases -->
                    <div class="tab-pane fade active show" id="features-tab-1">
                        <div class="row">
                            <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0 d-flex flex-column justify-content-center">
                                <h3>Submit a Case Safely</h3>
                                <p class="fst-italic">
                                    Survivors or witnesses can securely submit GBV cases online with all necessary details.
                                </p>
                                <ul>
                                    <li><i class="bi bi-check2-all"></i> <span>Report cases of physical, sexual, or psychological violence.</span></li>
                                    <li><i class="bi bi-check2-all"></i> <span>Provide location, description, and supporting notes.</span></li>
                                    <li><i class="bi bi-check2-all"></i> <span>Upload optional evidence files (images, videos, PDFs).</span></li>
                                    <li><i class="bi bi-check2-all"></i> <span>Receive a unique Case ID for tracking.</span></li>
                                </ul>
                            </div>
                            <div class="col-lg-6 order-1 order-lg-2 text-center">
                                <img src="assets/img/report-case.webp" alt="Report Case" class="img-fluid">
                            </div>
                        </div>
                    </div><!-- End tab content item -->

                    <!-- Track Progress -->
                    <div class="tab-pane fade" id="features-tab-2">
                        <div class="row">
                            <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0 d-flex flex-column justify-content-center">
                                <h3>Track Your Case in Real Time</h3>
                                <p class="fst-italic">
                                    Survivors and witnesses can follow up on their cases with transparency.
                                </p>
                                <ul>
                                    <li><i class="bi bi-check2-all"></i> <span>Enter your Case ID to check the current status.</span></li>
                                    <li><i class="bi bi-check2-all"></i> <span>View progress updates from RIB agents or medical staff.</span></li>
                                    <li><i class="bi bi-check2-all"></i> <span>Access case history and activity logs.</span></li>
                                    <li><i class="bi bi-check2-all"></i> <span>Download a Case Report PDF anytime.</span></li>
                                </ul>
                            </div>
                            <div class="col-lg-6 order-1 order-lg-2 text-center">
                                <img src="assets/img/track-case.webp" alt="Track Case" class="img-fluid">
                            </div>
                        </div>
                    </div><!-- End tab content item -->

                    <!-- Evidence & Notifications -->
                    <div class="tab-pane fade" id="features-tab-3">
                        <div class="row">
                            <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0 d-flex flex-column justify-content-center">
                                <h3>Evidence Management & Alerts</h3>
                                <ul>
                                    <li><i class="bi bi-check2-all"></i> <span>Submit additional evidence after reporting.</span></li>
                                    <li><i class="bi bi-check2-all"></i> <span>RIB agents are notified instantly of new evidence.</span></li>
                                    <li><i class="bi bi-check2-all"></i> <span>Survivors receive notifications when evidence is reviewed or accepted.</span></li>
                                    <li><i class="bi bi-check2-all"></i> <span>Stay informed with updates directly on your dashboard.</span></li>
                                </ul>
                                <p class="fst-italic">
                                    A trusted channel to ensure cases are followed up with integrity and speed.
                                </p>
                            </div>
                            <div class="col-lg-6 order-1 order-lg-2 text-center">
                                <img src="assets/img/evidence-notify.webp" alt="Evidence and Notifications" class="img-fluid">
                            </div>
                        </div>
                    </div><!-- End tab content item -->

                </div>

            </div>

        </section><!-- /Features Section -->


        <!-- Contact Section -->
        <section id="contact" class="contact section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Contact Us</h2>
                <p>We’d love to hear from you. Reach out with any questions, feedback, or partnership opportunities.</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row g-4 g-lg-5">
                    <!-- Contact Info -->
                    <div class="col-lg-5">
                        <div class="info-box" data-aos="fade-up" data-aos-delay="200">
                            <h3>Contact Info</h3>
                            <p>Our team is here to support you. Get in touch through any of the options below.</p>

                            <div class="info-item" data-aos="fade-up" data-aos-delay="300">
                                <div class="icon-box">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div class="content">
                                    <h4>Our Location</h4>
                                    <p>Kigali, Rwanda</p>
                                </div>
                            </div>

                            <div class="info-item" data-aos="fade-up" data-aos-delay="400">
                                <div class="icon-box">
                                    <i class="bi bi-telephone"></i>
                                </div>
                                <div class="content">
                                    <h4>Phone Number</h4>
                                    <p>+250 788 123 456</p>
                                </div>
                            </div>

                            <div class="info-item" data-aos="fade-up" data-aos-delay="500">
                                <div class="icon-box">
                                    <i class="bi bi-envelope"></i>
                                </div>
                                <div class="content">
                                    <h4>Email Address</h4>
                                    <p>support@safezone.com</p>
                                    <p>info@safezone.com</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="col-lg-7">
                        <div class="contact-form" data-aos="fade-up" data-aos-delay="300">
                            <h3>Get In Touch</h3>
                            <p>Fill out the form below and our team will get back to you shortly.</p>

                            <form action="#" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
                                @csrf
                                <div class="row gy-4">

                                    <div class="col-md-6">
                                        <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                                    </div>

                                    <div class="col-md-6">
                                        <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                                    </div>

                                    <div class="col-12">
                                        <input type="text" class="form-control" name="subject" placeholder="Subject" required>
                                    </div>

                                    <div class="col-12">
                                        <textarea class="form-control" name="message" rows="6" placeholder="Message" required></textarea>
                                    </div>

                                    <div class="col-12 text-center">
                                        <div class="loading">Loading</div>
                                        <div class="error-message"></div>
                                        <div class="sent-message">Your message has been sent. Thank you!</div>

                                        <button type="submit" class="btn btn-primary">Send Message</button>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>

                </div>

            </div>

        </section><!-- /Contact Section -->


    </main>

    <footer id="footer" class="footer">

        <div class="container footer-top">
            <div class="row gy-4">

                <!-- About -->
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                        <span class="sitename">{{ config('app.name') }}</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Kigali, Rwanda</p>
                        <p class="mt-3"><strong>Helpline:</strong> <span>+250 788 123 456</span></p>
                        <p><strong>Email:</strong> <span>support@safezone.rw</span></p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href="#"><i class="bi bi-twitter-x"></i></a>
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <!-- Useful Links -->
                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Report a Case</a></li>
                        <li><a href="#">Awareness Resources</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Support Services</h4>
                    <ul>
                        <li><a href="#">Case Tracking</a></li>
                        <li><a href="#">Evidence Management</a></li>
                        <li><a href="#">Staff Training</a></li>
                        <li><a href="#">Feedback</a></li>
                        <li><a href="#">Secure Messaging</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>{{ date('Y') }}</span> <strong class="px-1 sitename">{{ config('app.name') }}</strong>
                <span> | Empowering Survivors, Strengthening Justice</span>
            </p>
        </div>

    </footer>


    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="front/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="front/assets/vendor/php-email-form/validate.js"></script>
    <script src="front/assets/vendor/aos/aos.js"></script>
    <script src="front/assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="front/assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="front/assets/vendor/purecounter/purecounter_vanilla.js"></script>

    <!-- Main JS File -->
    <script src="front/assets/js/main.js"></script>

</body>

</html>