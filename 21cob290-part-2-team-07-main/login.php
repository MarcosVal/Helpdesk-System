<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Make-It-All Login</title>

        <style type="text/css">
            p{
                background-color: #686868;
                text-align: left:
                margin: 200px;
            }
            body{
                background-color: #686868;
                text-align: center;
                font-family: sans-serif;
            }
            form{
                display: inline-block;
                margin: 200px auto;
                position: absolute;
                transform: translate(-50%, -50%);
            }
            div{
                width: 150px;
                padding-bottom: 20px;
            }
            h1{
                color: #e6f371;
                font-size: 80px;
            }
            label{
                font-size: 45px;
                display: block;
                color: #6AB0DE;

            }
            input{
                border: 2px solid #6AB0DE;
                border-radius: 3px;
                width: 300px;
                font-size: 30px;
                margin: auto;
                display: block;
            }
            button{
                margin: 20px auto;
                width: 300px;
                background-color: #6AB0DE;
                color: white;
                font-size: 30px;
                font-weight: bold;
                cursor: pointer;
            }
        </style>

	</head>
	<body>
		<h1>Welcome to Make-It-All</h1>
        <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "invalidInput") {
                    echo "<h1>Entered details are invalid</h1>";
                }
            }
        ?>
        <form action="../21cob290-part-2-team-07-main/login.php" method="post">    <!--change this to login page-->
            <div>
                <label for="username">Username</label>
                <input type="text" name="username" placeholder="Username" required>
            </div>
			<div>
                <label for="password">Password</label>
                <input type="password" name="password" required>
            </div>
            <div>
                <label for="2FAcode">2FAcode</label>
                <input type="2FAcode" name="secretCode" required>
            </div>

            <span id="error"></span>

			<button type="submit" name="onLogin" >Login</button>
		</form>



	</body>
</html>












<?php

require_once(__DIR__ . '/vendor/autoload.php');
$google2fa = new PragmaRX\Google2FA\Google2FA();


$servername = "localhost";
$username = "team007";
$password = "team007";
$dbname = "testdatabase";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());}

function grabInfo($username) {
    global $conn;
    $sql = "SELECT * FROM logins WHERE username = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      echo "error";
    }
    
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
  
    $resultData = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($resultData);
    return $row;
    mysqli_stmt_close();
}




function checkInputs($username, $password, $secretCode) {
	global $conn;
    global $google2fa;
    $sql = "SELECT * FROM logins WHERE username = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: login.php");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($resultData)) {
        $valid = $google2fa->verifyKey($row["secretKey"], $secretCode); 
        if(password_verify($password, $row["password"]) && $valid) {
            $data = grabInfo($username);
            session_start();
            $_SESSION["empID"] = $data["EmpID"];
            $_SESSION["Job"] = $data["Job"];
            header("location: cases.php");
            exit();
        }
        else {
            header("location: login.php?error=invalidInput");
            exit();
        }
    }
    else {
        header("location: login.php?error=invalidInput");
        exit();
    }

    mysqli_stmt_close($stmt);
}





if (isset($_REQUEST['onLogin'])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $secretCode = $_POST["secretCode"];
    checkInputs($username, $password, $secretCode);
    exit();
}






?>
