<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Gonzales Aguilar Children's Clinic</title>
  <link href="assets/img/favicon.ico" rel="icon" />

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet" />
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Lottie script -->
  <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
  <link href="assets/vendor/aos/aos.css" rel="stylesheet" />
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet" />

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
  <style>
    .break-day {
      background-color: #d4d4d4 !important;
      color: #e74a3b !important;
    }

    .break-day-reason {
      font-size: 0.8em;
      padding: 2px;
      font-weight: bold !important;
      /* display: none; */
    }

    .fc-day-number {
      color: #009c95;
      font-weight: bold;
    }

    .available-slots {
      font-weight: bold !important;
      color: #383838;
    }

    @media (min-width: 320px) and (max-width: 575.98px) {
      .topbar-name {
        font-size: 8px !important;
      }

      .current-date {
        display: none !important;
      }
    }
  </style>

</head>

<body class="index-page">
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
      <a href="index.php" class="logo d-flex align-items-center me-auto">
        <img src="assets/img/Clinic logo.png" alt="Clinic Logo" />
        <h1 class="sitename">Children's Clinic</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php#hero" class="active">Home</a></li>
          <li><a href="index.php#view_calendar">Calendar</a></li>
          <li><a href="index.php#features">Features</a></li>
          <li><a href="index.php#services">Services</a></li>
          <li><a href="index.php#contact">Address</a></li>
        </ul>

        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <!-- <button class="btn-getstarted border-0" data-bs-toggle="modal" data-bs-target="#signinModal">Sign
        in</button> -->
      <a href="includes/login.php" class="btn-getstarted border-0">Sign in</a>

    </div>
  </header>

  <main class="main">
    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <div class="hero-bg">
        <img src="assets/img/hero-bg-light.webp" alt="" />
      </div>
      <div class="container">
        <div class="d-flex justify-content-center align-items-center">
          <div class="row justify-content-center align-items-center">
            <div class="col-md-7">
              <h1>
                Welcome to <span>Gonzales Aguilar Children's Clinic</span>
              </h1>
              <p>
                Get started, and make an appointment for vaccination or check
                up of your child!<br />
              </p>
              <div class="d-flex">
                <a href="includes/login.php" class="btn-get-started btn-with-sparkle border-0">Get
                  Started
                  <!-- <div class="sparkle1">
                    <dotlottie-player src="https://lottie.host/a3c6d782-cb73-4ca4-99b4-a8719209e097/T4dNKgcBQk.json"
                      background="transparent" speed="1" loop autoplay></dotlottie-player>
                  </div>
                  <div class="sparkle2">
                    <dotlottie-player src="https://lottie.host/a3c6d782-cb73-4ca4-99b4-a8719209e097/T4dNKgcBQk.json"
                      background="transparent" speed="1" loop autoplay></dotlottie-player>
                  </div> -->
                </a>
              </div>
            </div>
            <div class="col-md-5">
              <?php include 'assets/img/hero.svg'; ?>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /Hero Section -->

    <section id="view_calendar" class="hero section">
      <div class="container">
        <div class="col-md-12">
          <div id='calendar'></div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="services section">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Features</h2>
      </div>
      <!-- End Section Title -->

      <div class="container">
        <div class="row g-5">

          <div class="col-lg-6 mb-3" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item item-orange">
              <!-- <i class="bi bi-syringe icon"></i> -->
              <i class="bi bi-chat text-main icon"></i>
              <div>
                <h3>Chat</h3>
                <p>
                  Instantly connect with a pediatrician for immediate consultation and advice regarding your child's
                  health and vaccination needs through our website.
                </p>
                <!-- <a href="#" class="read-more stretched-link">Learn More <i class="bi bi-arrow-right"></i></a> -->
              </div>
            </div>
          </div>
          <!-- End Service Item -->

          <div class="col-lg-6 mb-3" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item item-cyan">
              <i class="bi bi-activity icon"></i>
              <div>
                <h3>Digitalized Record</h3>
                <p>
                  Access easily your child's vaccination history and checkup details online, ensuring their health
                  information is always at your fingertips.
                </p>
                <!-- <a href="#" class="read-more stretched-link">Learn More <i class="bi bi-arrow-right"></i></a> -->
              </div>
            </div>
          </div>
          <!-- End Service Item -->

          <div class="col-lg-6 mb-3" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item item-indigo">
              <i class="bi bi-calendar4-week icon"></i>
              <div>
                <h3>Request Appointment Online</h3>
                <p>
                  Easily schedule vaccination and checkup appointments for your child with our streamlined online
                  booking system, tailored for your convenience.
                </p>
                <!-- <a href="#" class="read-more stretched-link">Learn More <i class="bi bi-arrow-right"></i></a> -->
              </div>
            </div>
          </div>
          <!-- End Service Item -->

          <div class="col-lg-6 mb-3" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item item-indigo">
              <i class="bi bi-bell icon"></i>
              <div>
                <h3>SMS and Email Notification</h3>
                <p>
                  Receive timely reminders and updates about your child's upcoming appointments and vaccination
                  schedules via SMS and email.
                </p>
                <!-- <a href="#" class="read-more stretched-link">Learn More <i class="bi bi-arrow-right"></i></a> -->
              </div>
            </div>
          </div>
          <!-- End Service Item -->

        </div>
      </div>
    </section>
    <!-- /Features Section -->

    <!-- Services Section -->
    <section id="services" class="services section light-background">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Services</h2>
        <p>
          Here are the services that Gonzales Aguilar Children's Clinic offers.
        </p>
      </div>
      <!-- End Section Title -->

      <div class="container">
        <div class="row g-5">

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item item-orange position-relative">
              <!-- <i class="bi bi-syringe icon"></i> -->
              <i class="fas fa-syringe text-main icon"></i>
              <div>
                <h3>Child Vaccination</h3>
                <p>
                  Ensure your child's health and protection against various diseases with comprehensive vaccination
                  services, administered by experienced pediatricians in a safe and caring environment.
                </p>
                <!-- <a href="#" class="read-more stretched-link">Learn More <i class="bi bi-arrow-right"></i></a> -->
              </div>
            </div>
          </div>
          <!-- End Service Item -->

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item item-cyan position-relative">
              <i class="bi bi-activity icon"></i>
              <div>
                <h3>Child Check-up</h3>
                <p>
                  Keep track of your child's growth and development with regular checkups. Health
                  assessments like physical examinations, developmental screenings, and personalized healthcare
                  advice.
                </p>
                <!-- <a href="#" class="read-more stretched-link">Learn More <i class="bi bi-arrow-right"></i></a> -->
              </div>
            </div>
          </div>
          <!-- End Service Item -->

        </div>
      </div>
    </section>
    <!-- /Services Section -->

    <!-- Address Section -->
    <section id="contact" class="contact section">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Address</h2>
      </div>
      <!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <div class="col-lg-12">
            <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up"
              data-aos-delay="200">
              <i class="bi bi-geo-alt"></i>
              <p class="mb-3"></p>
              <p>8WR4+RH9, Jaen, Nueva Ecija</p>
            </div>
          </div>
          <!-- End Info Item -->

          <!-- <div class="col-lg-3 col-md-6">
            <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up"
              data-aos-delay="300">
              <i class="bi bi-telephone"></i>
              <h3>Call Us</h3>
              <p>+1 5589 55488 55</p>
            </div>
          </div> -->
          <!-- End Info Item -->

          <!-- <div class="col-lg-3 col-md-6">
            <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up"
              data-aos-delay="400">
              <i class="bi bi-envelope"></i>
              <h3>Email Us</h3>
              <p>info@example.com</p>
            </div>
          </div> -->
          <!-- End Info Item -->
        </div>

        <div class="row gy-4 mt-1">
          <div class="col-lg-12" data-aos="fade-up" data-aos-delay="300">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3847.6353507778!2d120.9039166!3d15.3420395!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33972114e910a08f%3A0xb9e5a39bae870434!2sGonzales-Aguilar%20Children&#39;s%20Clinic!5e0!3m2!1sen!2sph!4v1724247112863!5m2!1sen!2sph"
              width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
          <!-- End Google Maps -->

          <!-- <div class="col-lg-6">
            <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up"
              data-aos-delay="400">
              <div class="row gy-4">
                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required="" />
                </div>

                <div class="col-md-6">
                  <input type="email" class="form-control" name="email" placeholder="Your Email" required="" />
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Subject" required="" />
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">
                    Your message has been sent. Thank you!
                  </div>

                  <button type="submit">Send Message</button>
                </div>
              </div>
            </form>
          </div> -->
          <!-- End Contact Form -->
        </div>
      </div>
    </section>
    <!-- /Contact Section -->
  </main>

  <footer id="footer" class="footer position-relative light-background">
    <!-- <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">QuickStart</span>
          </a>
          <div class="footer-contact pt-3">
            <p>A108 Adam Street</p>
            <p>New York, NY 535022</p>
            <p class="mt-3">
              <strong>Phone:</strong> <span>+1 5589 55488 55</span>
            </p>
            <p><strong>Email:</strong> <span>info@example.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Terms of service</a></li>
            <li><a href="#">Privacy policy</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Our Services</h4>
          <ul>
            <li><a href="#">Web Design</a></li>
            <li><a href="#">Web Development</a></li>
            <li><a href="#">Product Management</a></li>
            <li><a href="#">Marketing</a></li>
            <li><a href="#">Graphic Design</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12 footer-newsletter">
          <h4>Our Newsletter</h4>
          <p>
            Subscribe to our newsletter and receive the latest news about our
            products and services!
          </p>
          <form action="forms/newsletter.php" method="post" class="php-email-form">
            <div class="newsletter-form">
              <input type="email" name="email" /><input type="submit" value="Subscribe" />
            </div>
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">
              Your subscription request has been sent. Thank you!
            </div>
          </form>
        </div>
      </div>
    </div> -->

    <div class="container copyright text-center mt-4">
      <p>
        <span>Copyright &copy; <strong> Gonzalez Aguilar Children's Clinic</strong> 2024</span>
      </p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
      </div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <!-- <div id="preloader"></div> -->

  <?php include 'assets/modals/choose_user_modal.php'; ?>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

  <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
  <script>
    $(document).ready(function () {
      console.log("Initializing calendar...");

      $.ajax({
        url: 'includes/get_breaks_and_slots.php', // Updated to a new PHP file
        method: 'GET',
        dataType: 'json',
        success: function (data) {
          console.log("Fetched data: ", data); // Log the fetched data

          // Initialize FullCalendar after fetching breaks and slots
          $('#calendar').fullCalendar({
            dayRender: function (date, cell) {
              console.log("Rendering date: ", date.format('YYYY-MM-DD'));
              var today = moment().format('YYYY-MM-DD');

              // Check if the date is a Sunday
              if (date.day() === 0) { // 0 is Sunday in moment.js
                cell.css("background-color", "#d4d4d4");
                cell.css("color", "white");
              }

              // Check for breaks
              data.breaks.forEach(function (breakData) {
                var breakDate = breakData.break_date;
                var reason = breakData.reason;

                if (date.format('YYYY-MM-DD') === breakDate) {
                  console.log("Break found for date: ", breakDate, " Reason: ", reason);
                  cell.addClass('break-day');
                  cell.append('<div class="break-day-reason small text-center mt-4 font-weight-bold">' + reason + '</div>');
                }
              });

              // Display available slots
              var availableSlots = data.availableSlots[date.format('YYYY-MM-DD')];
              if (date.format('YYYY-MM-DD') !== today && availableSlots !== undefined) {
                cell.append(
                  '<div class="available-slots text-center small font-weight-bold mt-4">' + availableSlots + '<br>Slot</div>'
                );
              }
            }
          });

          console.log("Calendar initialized.");
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error("AJAX call failed: ", textStatus, errorThrown);
        }
      });

    });
  </script>

</body>

</html>