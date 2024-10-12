<?php
include_once("config.php");
?>

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
  <link href="css/custom.css" rel="stylesheet">
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

  <?php


  // Fetch upcoming events including today's
  $sql = "SELECT * FROM `events` WHERE `event_date` >= CURDATE() ORDER BY `event_date` ASC";
  $result = mysqli_query($conn, $sql);
  ?>

  <?php

  // Fetch upcoming events including today's
  $sql = "SELECT * FROM `events` WHERE `event_date` >= CURDATE() ORDER BY `event_date` ASC";
  $result = mysqli_query($conn, $sql);
  ?>

  <main>
    <h1 class="text-center mb-5">Upcoming Events</h1>
    <div class="row">
      <div class="col-md-8 mx-auto">
        <?php
        if (mysqli_num_rows($result) > 0) {
          // Loop through the events
          while ($event = mysqli_fetch_assoc($result)) {
            $eventDate = strtotime($event['event_date']);
            $day = date('d', $eventDate);
            $month = strtoupper(date('M', $eventDate));

            // Convert the event_time to 12-hour format with am/pm
            $eventTime = date('g:i A', strtotime($event['event_time']));
        ?>
            <div class="event-card">
              <div class="row g-0">
                <div class="col-md-3 col-sm-4">
                  <div class="event-date d-flex align-items-center justify-content-center h-100">
                    <div>
                      <div class="fs-2"><?= $day; ?></div>
                      <div class="fs-2"><?= $month; ?></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-9 col-sm-8">
                  <div class="event-info">
                    <h2 class="event-title"><?= htmlspecialchars($event['title']); ?></h2>
                    <p class="event-description"><?= htmlspecialchars($event['description']); ?></p>
                    <p class="event-time"><i class="bi bi-clock"></i> <?= $eventTime; ?></p>
                  </div>
                </div>
              </div>
            </div>
        <?php
          }
        } else {
          echo "<p class='text-center'>No upcoming events found.</p>";
        }
        // Close the connection
        mysqli_close($conn);
        ?>
      </div>
    </div>
  </main>


  <?php include_once "includes/footer.php"; ?>

  <script>
    document.addEventListener("DOMContentLoaded", function(event) {
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