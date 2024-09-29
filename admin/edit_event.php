<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once "../config.php";

$title = $description = $event_date = $event_time = "";
$title_err = $description_err = $event_date_err = $event_time_err = "";

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = trim($_GET["id"]);

    $sql = "SELECT * FROM events WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $id;

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                $title = $row["title"];
                $description = $row["description"];
                $event_date = $row["event_date"];
                $event_time = $row["event_time"];
            } else {
                echo "inn";
                // header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    mysqli_stmt_close($stmt);
} else {
    echo "out";
    // header("location: error.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];

    if (empty(trim($_POST["title"]))) {
        $title_err = "Please enter a title.";
    } else {
        $title = trim($_POST["title"]);
    }

    if (empty(trim($_POST["description"]))) {
        $description_err = "Please enter a description.";
    } else {
        $description = trim($_POST["description"]);
    }

    if (empty(trim($_POST["event_date"]))) {
        $event_date_err = "Please enter a date.";
    } else {
        $event_date = trim($_POST["event_date"]);
    }

    if (empty(trim($_POST["event_time"]))) {
        $event_time_err = "Please enter a time.";
    } else {
        $event_time = trim($_POST["event_time"]);
    }
    if (empty($title_err) && empty($description_err) && empty($event_date_err) && empty($event_time_err)) {
        $sql = "UPDATE events SET title=?, description=?, event_date=?, event_time=? WHERE id=?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssssi", $param_title, $param_description, $param_event_date, $param_event_time, $param_id);

            $param_title = $title;
            $param_description = $description;
            $param_event_date = $event_date;
            $param_event_time = $event_time;
            $param_id = $id;

            if (mysqli_stmt_execute($stmt)) {
                header("location: dashboard.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-7 mx-auto">


                <h2>Edit Event</h2>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?php echo $_GET['id'] ?>" method="post">
                    <div class="form-group mb-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                        <span class="invalid-feedback"><?php echo $title_err; ?></span>
                    </div>
                    <div class="form-group mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>"><?php echo $description; ?></textarea>
                        <span class="invalid-feedback"><?php echo $description_err; ?></span>
                    </div>
                    <div class="form-group mb-3">
                        <label>Date</label>
                        <input type="date" name="event_date" class="form-control <?php echo (!empty($event_date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $event_date; ?>">
                        <span class="invalid-feedback"><?php echo $event_date_err; ?></span>
                    </div>
                    <div class="form-group mb-3">
                        <label>Time</label>
                        <input type="time" name="event_time" class="form-control <?php echo (!empty($event_time_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $event_time; ?>">
                        <span class="invalid-feedback"><?php echo $event_time_err; ?></span>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                    <div class="form-group mb-3">
                        <input type="submit" class="btn btn-primary" value="Update Event">
                        <a href="dashboard.php" class="btn btn-secondary ml-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>