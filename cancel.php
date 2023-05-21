<?php
session_start();
$username = $_POST['username'];
//$x='username';
//echo "$username";
//echo "$_SESSION[$x]";
    
if (!($username == $_SESSION['username'])) {
    echo '<script type="text/javascript">
        alert("First login to your account");
        </script>';
    //header("Location: login.html");
    exit();
}
if (!isset($_SESSION['username'])) {
	header("Location: login.php");
	exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$pnr = $_POST['pnr'];
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

	// Check if booking ID is valid
	$sql = "SELECT * FROM booking WHERE pnr='$pnr' AND username='$username'";
	$result = $conn->query($sql);

	if ($result->num_rows == 0) {
		$conn->close();
		echo "Invalid booking ID.";
	} else {
		// Delete the booking record
		$sql = "DELETE FROM booking WHERE pnr='$pnr'";
		$conn->query($sql);
                echo "ticket cancelled successfuly";
		$conn->close();
	}
}
?>

