<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="IE=edge" http-equiv="X-UA-Compatible">
  <meta content="width=device-width,initial-scale=1" name="viewport">
  <meta content="description" name="description">
  <meta name="google" content="notranslate" />
  <meta content="Mashup templates have been developped by Orson.io team" name="author">

  <!-- Disable tap highlight on IE -->
  <meta name="msapplication-tap-highlight" content="no">

  <link href="./assets/apple-touch-icon.png" rel="apple-touch-icon">
  <link href="./assets/favicon.ico" rel="icon">
  <link href="css/main.a3f694c0.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap-grid.min.css"
    integrity="sha512-i1b/nzkVo97VN5WbEtaPebBG8REvjWeqNclJ6AItj7msdVcaveKrlIIByDpvjk5nwHjXkIqGZscVxOrTb9tsMA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />


  <title>W.P. Enterprise</title>
  <style>
    .event-card {
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
      margin-bottom: 30px;
      transition: transform 0.3s ease;
      cursor: pointer;
    }

    .event-card:hover {
      transform: translateY(-5px);
    }

    .event-date {
      background: #0000ff;
      color: white;
      text-align: center;
      padding: 10px;
      font-weight: bold;
      border-radius: 15px 0 0 15px;
      height: 100%
    }

    .event-info {
      padding: 20px;
    }

    .event-title {
      /* font-size: 1.25rem; */
      font-weight: bold;
      margin-bottom: 10px;
    }

    .event-description {
      /* font-size: 0.9rem; */
      color: #555;
      margin-bottom: 10px;
    }

    .event-time {
      /* font-size: 0.8rem; */
      color: #777;
    }

    .fs-2 {
      font-size: 2.5rem;
    }

    @media (max-width: 767px) {
      .event-date {
        border-radius: 15px 15px 0 0;
      }
    }
  </style>
</head>

<body>

  <!-- Add your content of header -->
  <?php include_once "includes/header.php"; ?>

  <main>
    <h1 class="text-center mb-5">Upcoming Events</h1>
    <div class="row">
      <div class="col-md-8 mx-auto">
        <div class="event-card">
          <div class="row g-0">
            <div class="col-md-3 col-sm-4">
              <div class="event-date d-flex align-items-center justify-content-center h-100">
                <div>
                  <div class="fs-2 ">15</div>
                  <div class="fs-2" >MAY</div>
                </div>
              </div>
            </div>
            <div class="col-md-9 col-sm-8">
              <div class="event-info">
                <h2 class="event-title">Tech Conference 2024</h2>
                <p class="event-description">Join us for the biggest tech conference of the year, featuring renowned
                  speakers and cutting-edge demonstrations.</p>
                <p class="event-time"><i class="bi bi-clock"></i> 9:00 AM - 5:00 PM</p>
              </div>
            </div>
          </div>
        </div>

        <div class="event-card">
          <div class="row g-0">
            <div class="col-md-3 col-sm-4">
              <div class="event-date d-flex align-items-center justify-content-center h-100">
                <div>
                  <div class="fs-2">22</div>
                  <div class="fs-2">JUN</div>
                </div>
              </div>
            </div>
            <div class="col-md-9 col-sm-8">
              <div class="event-info">
                <h2 class="event-title">Summer Music Festival</h2>
                <p class="event-description">Experience a day filled with live performances from top artists across
                  various genres.</p>
                <p class="event-time"><i class="bi bi-clock"></i> 2:00 PM - 11:00 PM</p>
              </div>
            </div>
          </div>
        </div>

        <div class="event-card">
          <div class="row g-0">
            <div class="col-md-3 col-sm-4">
              <div class="event-date d-flex align-items-center justify-content-center h-100">
                <div>
                  <div class="fs-2">10</div>
                  <div class="fs-2">JUL</div>
                </div>
              </div>
            </div>
            <div class="col-md-9 col-sm-8">
              <div class="event-info">
                <h2 class="event-title">Art Exhibition Opening</h2>
                <p class="event-description">Be among the first to view a stunning collection of contemporary art from
                  local and international artists.</p>
                <p class="event-time"><i class="bi bi-clock"></i> 7:00 PM - 10:00 PM</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php include_once "includes/footer.php"; ?>

  <script>
    document.addEventListener("DOMContentLoaded", function (event) {
      navActivePage();
    });

  </script>

  <!-- Google Analytics: change UA-XXXXX-X to be your site's ID 

<script>
  (function (i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {
      (i[r].q = i[r].q || []).push(arguments)
    }, i[r].l = 1 * new Date(); a = s.createElement(o),
      m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
  })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
  ga('create', 'UA-XXXXX-X', 'auto');
  ga('send', 'pageview');
</script>

-->

  <script type="text/javascript" src="js/main.41beeca9.js"></script>
</body>

</html>