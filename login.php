


<?php
// Start session
session_start();

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Create database connection
    $servername = "localhost:3306";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "users";

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the username exists in the database
    $sql = "SELECT * FROM details WHERE username='$username'";
    $result = $conn->query($sql);
    $retval=mysqli_query($conn, $sql);  

    if (mysqli_num_rows($retval) ==0) {
        $conn->close();
        echo '<script type="text/javascript">
            alert("Invalid username first register");
        </script>';
        
        exit();
    }
    // Verify the password
    $row = mysqli_fetch_assoc($retval);
    if (!($password== $row['password'])) {
        $conn->close();
//        echo "$username $password";
        echo "Invalid password!";
        exit();
    }

    // Set the session variables
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;

    // Redirect to the booking page
    header("Location: bookTicket.html");
    exit();

    $conn->close();
}
?>
