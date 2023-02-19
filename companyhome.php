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

error_reporting(0);
$error = "";
$msg = "";
$email=$_SESSION['idcomp'];
$cname=$_SESSION['cname'];

?>


<?php require('header2.php'); 
?>
<?php
    if(isset($_SESSION['investor_is_auth'])){
    if($_SESSION['investor_is_auth']){
        if($_SESSION['verified']){?>

        <div class="alert alert-success alert-dismissible fade show">
            <strong>Success!!!</strong> You are logged In!
            <a class="btn btn-info" style="float:right;" href="logout.php" >Log Out</a><br><br>
        </div>
        
        <?php
            if(isset($_GET['post'])){
                if($_GET['post']=="app"){
                
                $sql3 = "SELECT * FROM investor WHERE verified='1'";
                $result3 = mysqli_query($link, $sql3);
                $row3 = mysqli_fetch_array($result3);
                $xyz=$_SESSION["id"];
                $pqr=$_SESSION["idcomp"];
                
                //$pqr=$row['cname'];
                $query="UPDATE postidea set status='Approved' where email='$xyz'";
                $q2 = "UPDATE postidea set company='$cname' where email='$xyz'";
                
                $res=mysqli_query($link,$query);
                $res1=mysqli_query($link,$q2);
                
                if($res){
                      echo '<div class="alert alert-success alert-dismissible fade show">
                <strong>Approval Successful</strong> You have successfully selected the User
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>';
                //header("Location: userhome1.php");
            }
                    
                }
            
            }

            if(isset($_GET['post'])){
                if($_GET['post']=="rej"){
                
                $sql3 = "SELECT * FROM investor WHERE verified='1'";
                $result3 = mysqli_query($link, $sql3);
                $row3 = mysqli_fetch_array($result3);
                $xyz=$_SESSION["id"];
                $cname=$_SESSION['cname'];
                //$pqr=$_SESSION["idcomp"];
                //$pqr=$row['cname'];
                $query="UPDATE postidea set status='Pending' where email='$xyz'";
                $q2 = "UPDATE postidea set company='$cname' where email='$xyz'";
                
                $res=mysqli_query($link,$query);
                $res1=mysqli_query($link,$q2);
                
                if($res){
                      echo '<div class="alert alert-success alert-dismissible fade show">
                <strong>Approval Successful</strong> You have successfully rejected the User
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>';
                //header("Location: userhome1.php");
            }
                    
                }
            
            }
            
            ?>

        <h3 class="text-primary f-w-100">User Profiles Available</h3>
        <hr style="color:purple;">
        <div class="invest">
            
        
        <br>
        <div class="row">
            <?php
           
            // Attempt select query execution
                    $sql = "SELECT * FROM postidea where status='Pending'";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            
                            while($row = mysqli_fetch_array($result)){
                                echo "<div class='col-md-12'>";
                                echo "<div class='card'>";
                                echo "<h3 class='card-header text-white' style='background-color: #556EE6;'>". $row['name']."</h3>";
                                echo "<div class='card-body'style='background-color: #e6f2ff;'>";
                                    echo "<div class='card-body'>";
                                    echo "<dl class='row'>";
                                    echo "<dt class='col-6'>Name<dt>";
                                    echo "<dd class='col-6'>" . $row['name'] . "</dd>";
                                    echo "<dt class='col-6'>Number<dt>";
                                    echo "<dd class='col-6'>" . $row['phone'] . "</dd>";
                                    echo "<dt class='col-6'>Price Range<dt>";
                                    echo "<dd class='col-6'>" . $row['prange'] . "</dd>";
                                    echo "<dt class='col-6'>Disease<dt>";
                                    echo "<dd class='col-6'>" . $row['disease'] . "</dd>";
                                    echo "<dt class='col-6'>Medical Docs<dt>";
                                    echo "<dd class='col-6'>" . "<img src=image/".$row['image']." height=100 width=150 />" . "</dd>";
                                    echo "<a class='btn btn-info' href='companyhome.php?post=app'>Approve</a>";
                                    echo "<a class='btn btn-info' href='companyhome.php?post=rej'>Reject</a>";
                                    
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
                    ?>
                    <div class="row">   
                    <?php

                    echo "<br><br><h3 class='text-primary f-w-100'>User Profiles Taken</h3>";
                    echo "<hr style='color:purple;'>";
                    echo "<div class='invest'>";

                    $sql = "SELECT * FROM postidea where status='Approved'";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            
                            while($row = mysqli_fetch_array($result)){
                                echo "<div class='col-md-12'>";
                                echo "<div class='card'>";
                                echo "<h3 class='card-header text-white' style='background-color: #0059b3; border-radius: 15px 50px 30px'>". $row['name']."</h3>";
                                echo "<div class='card-body'style='background-color: #e6f2ff; border-radius: 15px 50px 30px'>";
                                    echo "<div class='card-body'>";
                                    echo "<dl class='row'>";
                                    echo "<dt class='col-6'>Name<dt>";
                                    echo "<dd class='col-6'>" . $row['name'] . "</dd>";
                                    echo "<dt class='col-6'>Number<dt>";
                                    echo "<dd class='col-6'>" . $row['phone'] . "</dd>";
                                    echo "<dt class='col-6'>Price Range<dt>";
                                    echo "<dd class='col-6'>" . $row['prange'] . "</dd>";
                                    echo "<dt class='col-6'>Disease<dt>";
                                    echo "<dd class='col-6'>" . $row['disease'] . "</dd>";
                                    echo "<dt class='col-6'>Company<dt>";
                                    echo "<dd class='col-6'>" . $row['company'] . "</dd>";
                                    echo "<dt class='col-6'>Medical Docs<dt>";
                                    echo "<dd class='col-6'>" . "<img src=image/".$row['image']." height=100 width=150 />" . "</dd>";
                                    //echo "<a class='btn btn-info' href='companyhome.php?post=app'>Approve</a>";
                                    //echo "<a class='btn btn-info' href='companyhome.php?post=rej'>Reject</a>";
                                    
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


                
            ?>
        </div>
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
                <strong>Alert!</strong> Please Login To Continue!!!
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>';
                echo '<a href="company.php?reg=login" class="btn btn-warning">Log In</a><br><br>';
            }}
            else{
                echo '<div class="alert alert-warning alert-dismissible fade show">
                <strong>Alert!</strong> Please Login To Continue!!!
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>';
                echo '<a href="company.php?reg=login" class="btn btn-warning">Log In</a><br><br>';
            }
        ?>
    
    <div class="row">
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</div>  
</div>   

       
<?php require('footer.php'); 
?>
