



<?php

session_start();
$username = $_POST['username'];
/*
  if (!($username == $_SESSION['username'])) {
  header("Location: login.html");
  exit();
  } */
if (!($username == $_SESSION['username'])) {
    echo '<script type="text/javascript">
        alert("First login to your account");
        </script>';
    //header("Location: login.html");
    exit();
}
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $source = $_POST['source'];
    $destination = $_POST['destination'];
    $date = $_POST['date'];
    $username = $_SESSION['username'];

    // Create database connection
    $servername = "localhost:3306";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "users";

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM booking WHERE username='$username' AND date='$date'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $conn->close();
        echo "You have already booked a ticket for that date.";
    } else {
        // Book the ticket
        $min = 1000000000;
        $max = 9999999999;
        $pnr = rand($min, $max);

        $sql = "INSERT INTO booking (username, source, destination, date,pnr) VALUES ('$username','$source','$destination','$date','$pnr')";
        $conn->query($sql);
        $conn->close();

        echo "Ticket booked successfully! and your pnr is $pnr";
    }
}
?>
