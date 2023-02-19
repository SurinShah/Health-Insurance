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
$pqr=$_SESSION["idcomp"];

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $phone = mysqli_real_escape_string($link, $_POST['phone']);
    $prange=$_POST['prange'];
    $disease = $_POST['disease'];
    $id=$_SESSION['sid'];
    $email=$_POST['email'];

    $image= $_FILES['file']['name'];
    $target = "image/".$image;

    $image2= $_FILES['file1']['name'];
    $target2 = "idproof/".$image2;

    if($error != ""){
        $error = "<p>There were error(s) in your form! </p>".$error;
    }
    else{
              

    $query = "INSERT INTO postidea (startupid,name,email,phone,prange,disease,image,idproof) VALUES ('$id','$name','$email','$phone','$prange','$disease','$image','$image2')";

            if(mysqli_query($link, $query)){
                    
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

    if (move_uploaded_file($_FILES['file1']['tmp_name'], $target2)) {
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

        <div class="alert alert-success alert-dismissible fade show">
            <strong>Basic Coverage Includes the following:</strong><br>
            <strong>1. Outpatient Care</strong><br>
            <strong>2. Drug Prescriptions</strong><br>
            <strong>3. Hospitalization</strong><br>
        </div>
        
        <h3 class="text-primary f-w-100">User Profile</h3>
        <div class="postidea">
            
            <!-- newideabtn  -->
            
            <a class="btn btn-info" href="userhome.php?post=new" >Post Insurance Price range</a>
            <a class="btn btn-info" href="userhome.php?get=det" >View Details</a><br><br>


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

                    <label for="ideatextbox" class="col-form-label col-12"> Enter Your price range</label>

                    <div class="col-12 col-md-5 ">
                                <input type="number" class="form-control" id="firstname" name="prange" placeholder="Enter your Price Range" required>
                            </div>
                    <label for="ideatextbox" class="col-form-label col-12">Do you have any diseases?</label>
                    <div class="col-12 col-md-5 ">
                                <input type="text" class="form-control" id="firstname" name="disease" placeholder="Enter diseases if any" required>
                            </div>
                    
                    <div>
                    <label for="ideatextbox" class="col-form-label col-12">Govt. ID Proof</label>
                    <input type="file" name="file1" multiple>
                    <label for="ideatextbox" class="col-form-label col-12">Medical Doc</label>
                    <input type="file" name="file" multiple>
                    </div>
        
                </div>
 
                   
             
                
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
                                        echo "<th>ID Proof</th>";
                                        echo "<th>Status</th>";
                                        echo "<th>Company</th>";
                                        
    
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
                                        echo "<td>" . "<img src=idproof/".$row['idproof']." height=100 width=150 />" . "</td>";                         
                                        echo "<td>" . $row['status'] . "</td>";
                                        echo "<td>" . $row['company'] . "</td>";
                                        echo "<td>";
                                            
                                        
                                        // echo "</td>";
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
         <div class="investorlist" >

            <h2 class="text-primary f-w-100">List of Companies</h2>
            <p>
        
            </p>
            <?php
            if(1){
            // Attempt select query execution
                    $sql = "SELECT * FROM investor WHERE verified='1'";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            
                            while($row = mysqli_fetch_array($result)){
                                echo "<div class='col-md-12' style='border-radius: 15px 50px 30px'>";
                                echo "<div class='card' style='border-radius: 15px 50px 30px'>";
                                echo "<h3 class='card-header text-white' style='background-color: #556EE6; border-radius: 15px 50px 30px'>". $row['cname']."</h3>";
                                echo "<div class='card-body'style='background-color: #e6f2ff; border-radius: 15px 50px 30px'>";
                                    echo "<div class='card-body'>";
                                    echo "<dl class='row'>";
                                    echo "<dt class='col-6'>Investor<dt>";
                                    echo "<dd class='col-6'>" . $row['cname'] . "</dd>";
                                    echo "<dt class='col-6'>Email<dt>";
                                    echo "<dd class='col-6'>" . $row['mail'] . "</dd>";
                                    echo "<dt class='col-6'>Phone<dt>";
                                    echo "<dd class='col-6'>" . $row['phone'] . "</dd>";
                                    echo "<dt class='col-6'>Location<dt>";
                                    echo "<dd class='col-6'>" . $row['location'] . "</dd>";
                                    
                                    echo "</dl>";                            
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "<div class='col-12'><br></div>";
                            }
                        // Free result set
                        mysqli_free_result($result);
                    }
                        
                        
                        else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }


                }
            ?>
        </div> 

<!-- END of container class -->
    
<?php }
            else
            {
                echo '<div class="alert alert-warning alert-dismissible fade show">
                <strong>Alert!</strong> You have not verified your email ID, please verify it by using link send to your mail!
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>';
            }
            }
            else{
                echo '<div class="alert alert-warning alert-dismissible fade show">
                <strong>Alert!</strong> Please Login as User To Continue!!!
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>';
                echo '<a href="user.php?reg=login" class="btn btn-warning">Log In</a><br><br>';
            }}
            else{
                echo '<div class="alert alert-warning alert-dismissible fade show">
                <strong>Alert!</strong> Please Login as User To Continue!!!
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>';
                echo '<a href="user.php?reg=login" class="btn btn-warning">Log In</a><br><br>';
            }
            ?>
            
    <div class="row">
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    </div>  
    </div>

       
    <?php require('footer.php'); 
?>
