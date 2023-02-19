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


<?php require('header2.php'); 
?>
<?php
    if(isset($_SESSION['investor_is_auth'])){
    if($_SESSION['investor_is_auth']){?>

        <div class="alert alert-success alert-dismissible fade show">
            <strong>Success!!!</strong> You are logged In!
            <a class="btn btn-info" style="float:right;" href="logout.php" >Log Out</a><br><br>
        </div>
        
                
        <a class="btn btn-info" href="adminhome.php?get=userdet" >View User Details</a>
        <a class="btn btn-info" href="adminhome.php?get=compdet" >View Company Details</a>

        
        <?php

        if(isset($_GET['get'])){

            if($_GET['get']=="userdet"){
                // Attempt select query execution
                ?>
                <br><br><br><h3 class="text-primary f-w-100">User Profiles</h3>
                <hr style="color:purple;">
                <div class="invest">
                <?php
                $sql = "SELECT * FROM postidea";
                // $result1 = mysqli_query($link, "SELECT * FROM images");
                if($result = mysqli_query($link, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        echo "<table class='table table-bordered table-striped'>";
                            echo "<thead>";
                                echo "<tr>";
                                    echo "<th>Idea ID</th>";
                                    echo "<th>Name</th>";
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
                                    echo "<td>" . $row['phone'] . "</td>";
                                    echo "<td>" . $row['prange'] . "</td>";
                                    echo "<td>" . $row['disease'] . "</td>";
                                    echo "<td>" . "<img src=image/".$row['image']." height=100 width=150 />" . "</td>";                         

                                    echo "<td>";
                                        
                                    //echo "<a href='edit.php?startupid=". $row['startupid'] ."' title='Update Record' data-toggle='tooltip' class='btn btn-primary'>Edit</a>";
                                    echo "<a href='delete.php?startupid=". $row['startupid'] ."' title='Delete Record' data-toggle='tooltip' class='btn btn-danger''>Delete</a>";
                        

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
    
    <?php
    if(isset($_GET['get'])){

        if($_GET['get']=="compdet"){?>
            
            <br><br><br><h3 class="text-primary f-w-100">Company Profiles</h3>
            <hr style="color:purple;">
            <div class="invest">
            <?php
            $sql = "SELECT * FROM investor";
            
            if($result = mysqli_query($link, $sql)){
                if(mysqli_num_rows($result) > 0){
                    echo "<table class='table table-bordered table-striped'>";
                        echo "<thead>";
                            echo "<tr>";
                                echo "<th>Company Name</th>";
                                echo "<th>Email ID</th>";
                                echo "<th>Number</th>";
                                echo "<th>Location</th>";
                                          

                            echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";

                        while($row = mysqli_fetch_array($result)){
                            echo "<tr>";
                                echo "<td>" . $row['cname'] . "</td>";
                                echo "<td>" . $row['mail'] . "</td>";
                                echo "<td>" . $row['phone'] . "</td>";
                                echo "<td>" . $row['location'] . "</td>";
                                
                                echo "<td>";
                                    
                                echo "<a href='editcomp.php?cname=". $row['cname'] ."' title='Update Record' data-toggle='tooltip' class='btn btn-primary'>Edit</a>";
                                echo "<a href='deletecomp.php?cname=". $row['cname'] ."' title='Delete Record' data-toggle='tooltip' class='btn btn-danger''>Delete</a>";
                    

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


        </div>    </div> 
        <?php } ?>
       




<!-- END of container class -->
</div>


        <?php }}
            else{
                echo '<div class="alert alert-warning alert-dismissible fade show">
                <strong>Alert!</strong> Please Login as an Admin To Continue!!!
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>';
                echo '<a href="admin.php?reg=login" class="btn btn-warning">Log In</a><br><br>';
            }
        ?>
    
    <div class="row">
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</div>  
</div>   
<br><br><br><br><br><br><br><br><br><br><br><br><br>
       
<?php require('footer.php'); 
?>