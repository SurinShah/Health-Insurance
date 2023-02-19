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
    $sql = "UPDATE investor set phone='" . $_POST["phone"] . "' WHERE cname='" . $_POST["cname"] . "'";
    $sql1 = "UPDATE investor set location='" . $_POST["location"] . "' WHERE cname='" . $_POST["cname"] . "'";
    mysqli_query($link,$sql);
    mysqli_query($link,$sql1);
    echo '<div class="alert alert-info alert-dismissible fade show">
                    <strong>Success!</strong> Details updated successfully!
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
                    <label for="cname" class="col-form-label "><h6>Details to be updated</h6></label>
                    <input type="text" class="form-control" id="cname" name="cname" value='<?php echo $_GET['cname'];?>' readonly>
                            

                    <label for="exampleFormControlTextarea1"><h6> Edit your Phone number</h6></label>
                    <input class="form-control" id="exampleFormControlTextarea1" name="phone">

                    <label for="exampleFormControlTextarea1"><h6> Edit your Location</h6></label>
                    <input class="form-control" id="exampleFormControlTextarea1" name="location">
                </div>

                <input type="submit" class="btn btn-info" name="submit" value="Update Details">
              
</form>
<button onclick="location.href = 'adminhome.php?get=compdet';" id="myButton" class="btn btn-info">View Updated Details</button>
<div class="row">
    <br><br><br><br>
</div>


<!-- END of container class -->
    </div>
 
       
    <?php require('footer.php'); 
?>