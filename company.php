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
if(array_key_exists("investsubmit", $_POST)){
//if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $error = "";

    $errors=array('email'=>'','password'=>'','compname'=>'','location'=>'','phone'=>'');


    if(empty($_POST['email'])){
      $errors['email']='Email is required <br />';
    }else{
      $email= $_POST['email'];
      if(!preg_match('/^[a-zA-Z0-9]([a-zA-Z0-9][\.\+\-\_\!\#\$\%\&\'\*\+\-\/\=\?\^\_\`\{\|]{0,1}){0,62}([a-zA-Z0-9][\@])([\a-zA-Z0-9\-]{1,6}[\.]){1,3}([a-zA-Z]){2,4}$/',$email))
      {
        $errors['email']='Email must be the valid email address <br />';
      }
    }

    if(empty($_POST['phone'])){
        $errors['phone']='Phone number is required <br />';
      }else{
        $phone= $_POST['phone'];
        if(!preg_match('/^(\+91)?[6|7|8|9]{1}[0-9]{9}$/',$phone)){
          $errors['phone']='Please type proper phone number';
        }
      }
  
      if(empty($_POST['compname'])){
          $errors['compname']='Company name is required <br />';
        }else{
          $compname=$_POST['compname'];
          if(!preg_match('/^[a-zA-Z\s]+$/',$compname)){
            $errors['compname']= 'Name must be letters and spaces only <br/>';
          }
        }

    if(empty($_POST['location'])){
        $errors['location']='Location is required <br />';
      }else{
        $location=$_POST['location'];
        if(!preg_match('/^[a-zA-Z\s]+$/',$location)){
          $errors['location']= 'Enter valid location <br/>';
        }
      }


    if(empty($_POST['password'])){
        $errors['password']= "A Password is Required <br/>";
    }

    else if(empty($_POST['confirmpassword'])){
        $errors['password']= "Confirm your Password <br>";
    }

    else if($_POST['confirmpassword']!= $_POST['password'])
    {
        $errors['password']="Passwords do not match <br>";
    }
    else{
        $password=$_POST['password'];
    }

    if(array_filter($errors)){
      echo '<div class="alert alert-warning alert-dismissible fade show">
      <strong>Warning!</strong> Please enter a valid value in all the required fields before proceeding.
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>';
    }
    else{

        $token = bin2hex(random_bytes(50)); // generate unique token
        $user='investor';
        
        
            $compname = $_POST['compname'];
            $email = mysqli_real_escape_string($link, $_POST['email']);
            $phone = $_POST['phone'];
            $location = $_POST['location'];
            $password = mysqli_real_escape_string($link, $_POST['password']);

            $query = "INSERT INTO investor (cname,mail,phone,location,password,token) VALUES
            ('$compname','$email','$phone','$location','$password','$token')";

          
            if(mysqli_query($link, $query)){
                    //echo "Records added successfully.";
                    session_start();
                            $userid =  mysqli_insert_id($link);
                            $_SESSION['cid'] = $userid;
                            $_SESSION['investor_is_auth']=false;
                            $_SESSION['verified'] = false;
                            sendVerificationEmail($email, $token,$user,$userid);
                            echo '<div class="alert alert-success alert-dismissible fade show">
                            <strong>Success!</strong> Email has been sent to your email id for verification. Please verify to continue and then login!
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>';
                    //header("Location: companyhome.php");
                } 
            else{
                echo "ERROR: Could not able to execute <br>$query. <br>" . mysqli_error($link);
            }
    
    }

}

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
            
            $sql = "SELECT * from investor WHERE mail = '$email'";
            echo $sql;
        $result=mysqli_query($link,$sql);
        
        if($result){
        if(mysqli_num_rows($result)==1)
        {
            $row =mysqli_fetch_array($result);
            if($row['password']==$password)
            {
                
                session_start();
                $cname= $row['cname'];
                $_SESSION["cname"] = $cname;
                $email = $_POST['lmail'];
                $_SESSION["idcomp"] = $email;
                $_SESSION['verified']=$row['verified'];
                $_SESSION['cid']=$row['id'];
                $_SESSION['investor_is_auth']=1;
                header("Location: companyhome.php");

            }
            else
            {
                echo '<div class="alert alert-warning alert-dismissible fade show">
                <strong>Warning!</strong> Password is incorrect!
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>';
            } 
        }
            else{
                echo "ERROR: Could not able to execute <br>$query. <br>" . mysqli_error($link);
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
    if($_GET['reg']=='signup'){?>
        <div class="row">
            <div class="col-12 ">
                <form method="POST" id="mysform" style="margin-top: 1em;">
                    
                    <h3 style="text-align: center;">Company Registration</h3>
                    <hr style="border-top: 1px solid #9900cc;">
                    <br>
                    <h5>Basic Details</h5>
                    <hr style="border-top: 1px solid #9900cc;">
                    <div class="form-group row ">
                        
                            <label for="firstname" class="col-form-label col-12 col-md-1 ">Company Name</label>
                            <div class="col-12 col-md-5 ">
                                <input type="text" class="form-control" id="firstname" name="compname" placeholder="Enter Company name">
                                <span class="errorresult" style="color:red;"><?php if(isset($errors['compname'])){echo $errors['compname'];}?></span>
                            </div>
                        
                            <label for="firstname" class="col-form-label col-12 col-md-1 ">Email</label>
                            <div class="col-12 col-md-5 ">
                                <input type="text" class="form-control" id="firstname" name="email" placeholder="Enter your Email">
                                <span class="errorresult" style="color:red;"><?php if(isset($errors['email'])){echo $errors['email'];}?></span>
                            </div>
                        
                    </div>
                    
                    <div class="form-group row ">

                            <label for="firstname" class="col-form-label col-12 col-md-1 ">Phone</label>
                            <div class="col-4 col-md-2 ">
                                <select class="form-control " id="dept" name="dept">
                                    <option>+91</option>
                                    <option>+92</option>
                                </select>
                            </div>
                            <div class="col-8 col-md-3 ">
                                <input type="text" class="form-control" id="name" name="phone" placeholder="Contact number">
                                <span class="errorresult" style="color:red;"><?php if(isset($errors['phone'])){echo $errors['phone'];}?></span>
                            </div>
                            
                        
                            <label for="firstname" class="col-form-label col-12 col-md-1 ">Location</label>
                            <div class="col-12 col-md-5 ">
                                <input type="text" class="form-control" id="location" name="location" placeholder="Location">
                                <span class="errorresult" style="color:red;"><?php if(isset($errors['location'])){echo $errors['location'];}?></span>
                            </div>
                    </div>
                    <br>
                    <h5>Create Password</h5>
                    <hr style="border-top: 1px solid #9900cc;">
                    <div class="form-group row ">
                        
                            <label for="firstname" class="col-form-label col-12 col-md-1 ">Enter Password</label>
                            <div class="col-12 col-md-5 ">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                                <span id="result" style="color:red;"><?php if(isset($errors['password'])){echo $errors['password'];}?></span>
                            </div>
                        
                            <label for="firstname" class="col-form-label col-12 col-md-1 ">Confirm Password</label>
                            <div class="col-12 col-md-5 ">
                                <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password">
                            </div>
                        
                    </div>
                    <br>
                    <div class="form-group row">
                        <div class="offset-1 offset-md-6">
                        <input type="submit" class="btn btn-primary" name="investsubmit" value="Sign Up">
                        </div>
                        
                    </div>
                    
                    
                </form>
                
            </div>
        </div>
        <div class="row">
        <div class="offset-md-4">
            <h4><a href="company.php?reg=login">Already have an account? Login Here</a></h4>
        </div>
        </div>
    <?php } else{?>
        <div class="row">
            <h2></h2>
            
        </div>
        <div class="row">
            <div class="col-12 ">
                <form id="mysform" method="POST" style="margin-top: 1em;">
                    
                    <h3 style="text-align: center;">Company Log In</h3>
                    <hr style="border-top: 1px solid #9900cc;">
                    <br>
                    <h5>Enter Credentials</h5>
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
        <div class="row">
        <div class="offset-md-4">
            <h5 align="center"><a href="company.php?reg=signup">Dont have an account? You can signup here!</a></h5>
            
            <br><br><br><br><br>
        </div>
        </div>

    <?php }} ?>
    </div>
    </div>

</div>
       
<?php require('footer.php'); 
?>
