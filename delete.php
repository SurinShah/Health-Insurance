<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "venture3";

// Create connection
$link = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$link) {
  die("Connection failed: " . mysqli_connect_error());
}
//echo "Database Connected!!!";

$error = "";
$msg = "";


?>

<?php require('header.php'); 
?>



<?php

$sql = "DELETE FROM postidea WHERE startupid='" . $_GET["startupid"] . "'";
if(mysqli_query($link,$sql)){
    $msg .= "Record Deleted Successfully !!!";
}
//header("Location:read.php");
?>


    <!-- To Display Error(s) in HTML ,if generated -->
<?php if ($error != "" || $msg != "") { ?>
 <div id="error" class="p-3 mb-2 bg-danger text-white">
    
        <?php 
        echo "$error";
        echo '<div class="alert alert-info alert-dismissible fade show">
                    <strong>Success!</strong> Idea deleted successfully!
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>'; 
        ?>

     
    </div>   
<?php } else { ?>
    <div id="error">
    
        <?php 
        echo "$error"; 
        ?>

    
    </div>    
<?php } ?>

<button onclick="location.href = 'adminhome.php';" id="myButton" class="btn btn-info">View Updated Records</button>



<!-- END of container class -->
    </div>
       
<?php require('footer.php'); 
?>