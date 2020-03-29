<?php
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

if(empty($username) || empty($password) || empty($email))
    {
        echo "All fields are Mandatory ...";
        die();
    }

$hostname = "localhost";
$dbUser = "root";
$dbPass = "hellgames";
$dbName = "Demo";

$conn = new mysqli($hostname, $dbUser, $dbPass, $dbName);

if(mysqli_connect_error())
    {
        die('Connect Error('.mysqli_connect_errorno.')'.mysqli_connect_error);
    }
else
    {
        $SELECT = "SELECT email FROM Users WHERE email = ? LIMIT 1";
        $INSERT = "INSERT INTO Users(username, email, password) VALUES(?, ?, ?)";

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;
        
        if($rnum == 0)
        {
            $stmt->close();
            $stmt = $conn.prepare($INSERT);
            $stmt->bind_param("sss", $username, $email, $password);
            $stmt.execute();
            echo"New User Inserted ...";
        }
        else    
        {
            echo"User Already Exists ...";    
        }

        $stmt->close();
    }
    $conn->close();
?>