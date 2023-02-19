<?php
session_start();
require_once 'sendEmails.php';
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

error_reporting(0);
$error = "";
$msg = "";
$xyz=$_SESSION["id"];

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $phone = mysqli_real_escape_string($link, $_POST['phone']);
    $prange=$_POST['prange'];
    $disease = $_POST['disease'];
    $id=$_SESSION['sid'];
    $email=$_POST['email'];

    $image= $_FILES['file']['name'];
    
    $target = "image/".$image;

    if($error != ""){
        $error = "<p>There were error(s) in your form! </p>".$error;
    }
    else{
              

    $query = "INSERT INTO postidea (startupid,name,email,phone,prange,disease,image) VALUES ('$id','$name','$email','$phone','$prange','$disease','$image')";

            if(mysqli_query($link, $query)){
                    //echo "Idea Posted successfully.";
                $msg = "Details Posted successfully.";
                } 
            else{
                echo "ERROR: Could not able to execute <br>$query. <br>" . mysqli_error($link);
            }
    }

    
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
        $msg = "Image uploaded successfully";
    }else{
        $msg = "Failed to upload image";
    }
    }


?>


<?php require('header2.php'); 
?>

<?php
    if(isset($_SESSION['s_is_auth'])){
        if($_SESSION['s_is_auth']){
            if($_SESSION['verified']){?>
    
        <div class="alert alert-success alert-dismissible fade show">
            <strong>Success!!!</strong> You are logged In!
            <a class="btn btn-info" style="float:right;" href="logout.php" >Log Out</a><br><br>
        </div>
        
        <h3 class="text-primary f-w-100">User Profile</h3>
        <div class="postidea">
            
            <!-- newideabtn  -->
            
            <a class="btn btn-info" href="userhome1.php?post=new" >Post Insurance Price range</a>
            <a class="btn btn-info" href="userhome1.php?get=det" >View Details</a><br><br>


    <?php

    if(isset($_GET['post'])){

        if($_GET['post']=="new"){?>
            <div id="">
                <form method="POST" id="ideaform" enctype="multipart/form-data">


                <div class="form-group">

                    <label for="firstname" class="col-form-label col-12 col-md-1 ">Name</label>
                        <div class="col-12 col-md-5 ">
                            <input type="text" class="form-control" id="firstname" name="name" placeholder="Name" required>
                        </div>

                    <label for="firstname" class="col-form-label col-12 col-md-1 ">Email</label>
                        <div class="col-12 col-md-5 ">
                            <input type="email" class="form-control" id="firstname" name="email" placeholder="Email" required>
                        </div>

                    <label for="firstname" class="col-form-label col-12 col-md-1 ">Number</label>
                            <div class="col-12 col-md-5 ">
                                <input type="number" class="form-control" id="firstname" name="phone" placeholder="Enter your Phone Number" required>
                            </div>

                    <label for="ideatextbox" class="col-form-label col-12"> Enter Your Maximum Price</label>
                    <div class="col-12 col-md-5 ">
                                <input type="number" class="form-control" id="firstname" name="prange" placeholder="Enter your Price Range" required>
                            </div>
                    <label for="ideatextbox" class="col-form-label col-12">Do you have any diseases?</label>
                    <div class="col-12 col-md-5 ">
                                <input type="text" class="form-control" id="firstname" name="disease" placeholder="Enter diseases if any" required>
                            </div>
                    
                    <div>
                    <input type="file" name="file" multiple>
                    </div>
                                    
                  

                </div>
<!-- 
                   
             
                Post Idea Button -->
                <input type="submit" class="btn btn-info" id="postideabtn" name="submit" value="Post Idea">
              
            </form>

            </div>
            <?php } else { ?>
                

            


            <?php }} ?>


            <?php
            

            if(isset($_GET['get'])){
    
                if($_GET['get']=="det"){
                    // Attempt select query execution
                   
                    $xyz=$_SESSION["id"];
                    $sql = "SELECT * FROM postidea where email='$xyz'";
                    
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Idea ID</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Email</th>";
                                        echo "<th>Number</th>";
                                        echo "<th>Price Range</th>";
                                        echo "<th>Diseases (If any)</th>";
                                        echo "<th>Image</th>";
                                        
    
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
    
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['startupid'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['email'] . "</td>";
                                        echo "<td>" . $row['phone'] . "</td>";
                                        echo "<td>" . $row['prange'] . "</td>";
                                        echo "<td>" . $row['disease'] . "</td>";
                                        echo "<td>" . "<img src=image/".$row['image']." height=100 width=150 />" . "</td>";                         
    
                                        echo "<td>";
                                        
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
                }}
    
    
            ?>
    
    
            <!-- To Display Error(s) in HTML ,if generated -->
            <?php if ($error != "" || $msg != "") { ?>
            <div id="error" class="p-3 mb-2 bg-danger text-white">
                
                    <?php 
                    echo "$error";
                    echo "$msg"; 
                    ?>
    
                
                </div>   
            <?php } else { ?>
                <div id="error">
                
                    <?php 
                    echo "$error"; 
                    ?>
    
                
                </div>    
            <?php } ?>
    
    <!-- END of container class -->
        </div>

<!-- To Display Error(s) in HTML ,if generated -->


 
        
 

</div>


            
<!-- END of container class -->
    
<?php }
           
            else{
                echo '<div class="alert alert-warning alert-dismissible fade show">
                <strong>Alert!</strong> Please Login as User To Continue!!!
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>';
                echo '<a href="user.php?reg=login" class="btn btn-warning">Log In</a><br><br>';
            }}}
            ?>
            
    <div class="row">
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    </div>  
    </div>

       
    <?php require('footer.php'); 
?>