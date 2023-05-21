<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
// Check if the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Retrieve the form data
            $username = $_POST['username'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $email = $_POST['email'];

            // Validate the form data
            if ($password !== $confirm_password) {
                echo "Passwords do not match!";
                exit();
            }

            // Hash the password
//            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Create database connection
            $servername = "localhost:3306";
            $dbusername = "root";
            $dbpassword = "";
            $dbname = "users";

            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
 
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Check if the username is already taken
            $sql = "SELECT * FROM details WHERE username='$username'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $conn->close();
                echo "Username already taken!";
                exit();
            }

            // Insert the user's data into the database
            $sql = "INSERT INTO details (username, password, email) VALUES ('$username', '$password', '$email')";

            if ($conn->query($sql) === TRUE) {
                echo "Sign up successful!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        }
        ?>


    </body>
</html>
