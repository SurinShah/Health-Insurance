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

<!-- UPDATE operation of CRUD -->

<?php

if(count($_POST)>0) {
    $sql = "UPDATE postidea set prange='" . $_POST["prange"] . "' WHERE startupid='" . $_POST["startupid"] . "'";
    mysqli_query($link,$sql);
    echo '<div class="alert alert-info alert-dismissible fade show">
                    <strong>Success!</strong> Idea updated successfully!
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>';
}



?>



<!-- To Display Error(s) in HTML ,if generated -->

    
        <?php 
        echo "$error";
        
        ?>

    


<form method="POST" id="ideaform">

                <div class="form-group">
                    <label for="startupid" class="col-form-label "><h6>User ID</h6></label>
                    <input type="text" class="form-control" id="startupid" name="startupid" value='<?php echo $_GET['startupid'];?>' readonly>
                           <br> 

                    <label for="exampleFormControlTextarea1"><h6> Edit your Price Range</h6></label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="prange"></textarea>
                </div>

                <input type="submit" class="btn btn-info" name="submit" value="Update Details">
              
</form>
<button onclick="location.href = 'adminhome.php?get=userdet';" id="myButton" class="btn btn-info">View Updated Details</button>
<div class="row">
    <br><br><br><br>
</div>


<!-- END of container class -->
    </div>
 
       
    <?php require('footer.php'); 
?>
