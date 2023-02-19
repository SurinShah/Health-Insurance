<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "venture";

// Create connection
$link = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$link) {
  die("Connection failed: " . mysqli_connect_error());
}
//echo "Database Connected!!!";


if (isset($_GET['token'])) 
{
    $token = $_GET['token'];
    $id=$_GET['userid'];
    if($_GET['user']=='startup')
    {
        $sql = "SELECT * FROM startupusers WHERE token='$token' LIMIT 1";
        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            $query = "UPDATE startupusers SET verified=1 WHERE token='$token' AND id='$id'";

            if (mysqli_query($link, $query)) {
                $_SESSION['sid'] = $user['id'];
                $_SESSION['s_is_auth']=true;
                $_SESSION['verified'] = 1;
                header('location: userhome.php');
                exit(0);
            }
            else echo "error in db".mysqli_error($link);
        } 
        else
        {
            echo "User not found! error is ==".mysqli_error($link);
        }

    }

    if($_GET['user']=='investor')
    {
        $sql = "SELECT * FROM investor WHERE token='$token' LIMIT 1";
        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            $query = "UPDATE investor SET verified=1 WHERE token='$token' AND id='$id'";

            if (mysqli_query($link, $query)) {
                $_SESSION['cid'] = $user['id'];
                $_SESSION['investor_is_auth']=true;
                $_SESSION['verified'] = 1;
                header('location: companyhome.php');
                exit(0);
            }
        } 
        else
        {
            echo "User not found! error is ==".mysqli_error($link);
        }

    }
    if($_GET['user']=='customer')
    {
        $sql = "SELECT * FROM customeruser WHERE token='$token' LIMIT 1";
        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            $query = "UPDATE customeruser SET verified=1 WHERE token='$token' AND uid='$id'";

            if (mysqli_query($link, $query)) {
                $_SESSION['uid']=$row['uid'];
                $_SESSION['u_is_auth']=true;
                $_SESSION['verified'] = 1;
                header('location: userhome.php');
                exit(0);
            }
            else echo "error in db".mysqli_error($link);
        } 
        else
        {
            echo "User not found! error is ==".mysqli_error($link);
        }

    }
    
} 
else 
{
    echo "No token provided!";
}
?>