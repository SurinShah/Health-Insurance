<?php

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

$error = "";
if(array_key_exists("lsubmit", $_POST)){
//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = "";
    if(isset($_POST['lsubmit'])){
    if(!$_POST['lmail'] && !$_POST['lpassword'])
    {
    echo '<div class="alert alert-danger alert-dismissible fade show">
      <strong>Warning!</strong> Please enter an email and a password.
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>';
    }
    else if(!$_POST['lmail'] )
    {
    echo '<div class="alert alert-danger alert-dismissible fade show">
      <strong>Warning!</strong> Please enter an email.
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>';
    }
    else if(!$_POST['lpassword'])
    {
        echo '<div class="alert alert-warning alert-dismissible fade show">
      <strong>Warning!</strong> Please enter password
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>';
    }
    else{
 
            $email = mysqli_real_escape_string($link, $_POST['lmail']);
            $password = $_POST['lpassword'] ;
            
            $sql = "SELECT * from admin WHERE mail = '$email'";
            echo $sql;
        $result=mysqli_query($link,$sql);
        
        if($result){
        if(mysqli_num_rows($result)==1)
        {
            $row =mysqli_fetch_array($result);
            if($row['password']==$password)
            {
                session_start();
                $_SESSION['cid']=$row['id'];
                $_SESSION['investor_is_auth']=1;
                header("Location: adminhome.php");

            }
            else
            {
                echo '<div class="alert alert-warning alert-dismissible fade show">
                <strong>Warning!</strong> Password is incorrect!
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>';
            } 
        }
           
        }
    }
}

}


?>

<!-- To Display Error(s) in HTML ,if generated -->

<?php if ($error != "") { ?>
 <div id="error" class="p-3 mb-2 bg-danger text-white">
    
        <?php 
        echo "$error"; 
        ?>

    
    </div>   
<?php } else { ?>
    <div id="error">
    
        <?php 
        echo "$error"; 
        ?>

    
    </div>    
<?php } ?>



<?php require('header.php'); 
?>

<?php 
    if(isset($_GET['reg'])){ 
        if($_GET['reg']=='login'){?>
        <div class="row">
            <div class="col-12 ">
                <form id="mysform" method="POST" style="margin-top: 1em;">
                    
                    <h3 style="text-align: center;">Admin Log In</h3>
                    <hr style="border-top: 1px solid #9900cc;">
                    <br>
                    <h5>Enter Admin Credentials</h5>
                    <hr style="border-top: 1px solid #9900cc;">
                    <div class="form-group row ">
                        
                            <label for="firstname" class="col-form-label col-12 col-md-1 ">Email</label>
                            <div class="col-12 col-md-5 ">
                                <input type="text" class="form-control" id="lmail" name="lmail" placeholder="Enter Email">
                            </div>
                        
                            <label for="firstname" class="col-form-label col-12 col-md-1 ">Password</label>
                            <div class="col-12 col-md-5 ">
                                <input type="password" class="form-control" id="lpassword" name="lpassword" placeholder="Enter Password">
                            </div>
                        
                    </div>
                    <br>
                    <div class="form-group row">
                        <div class="offset-1 offset-md-6">
                            <button type='submit' name="lsubmit" value="login" class="btn btn-primary" style="background-color: #9900cc;">Log In</button>
                        </div>
                    </div>
                    
                    
                </form>
                
            </div>
        </div>
        

    <?php }}?>
    </div>
    </div>

</div>
       
