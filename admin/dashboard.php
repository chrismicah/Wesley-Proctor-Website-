<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once "../config.php";

// Fetch events
$sql = "SELECT * FROM events ORDER BY event_date DESC";
$result = mysqli_query($conn, $sql);
$events = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Event Management</a>
            <div>
                <a href="logout.php" class="btn btn-danger">Sign Out</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h2>
        <a href="create_event.php" class="btn btn-primary mb-3">Create New Event</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?php echo $event['id']; ?></td>
                        <td><?php echo $event['title']; ?></td>
                        <td><?php echo $event['description']; ?></td>
                        <td><?php echo $event['event_date']; ?></td>
                        <td><?php echo $event['event_time']; ?></td>
                        <td>
                            <a href="edit_event.php?id=<?php echo $event['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="delete_event.php?id=<?php echo $event['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>