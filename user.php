<?php

require_once 'sendEmails.php';
$servername = "localhost";
$username = "root";
$password = "";
$database = "venture3";

$link = mysqli_connect($servername, $username, $password, $database);

if (!$link) {
  die("Connection failed: " . mysqli_connect_error());
}
?>

<?php require('header.php'); 
?>

<?php
//login page

if(array_key_exists("l-submit", $_POST))
{
    $error = "";
    if(!$_POST['email'] && !$_POST['password'])
    {
    echo '<div class="alert alert-danger alert-dismissible fade show">
      <strong>Warning!</strong> Please enter an email and a password.
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>';
    }
    else if(!$_POST['email'] )
    {
    echo '<div class="alert alert-danger alert-dismissible fade show">
      <strong>Warning!</strong> Please enter an email.
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>';
    }
    else if(!$_POST['password'])
    {
        echo '<div class="alert alert-warning alert-dismissible fade show">
      <strong>Warning!</strong> Please enter password
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>';
    }
    else
    {
        $email=$_POST['email'];
        $password=$_POST['password'];

        $email = stripcslashes($email);  
        $password = stripcslashes($password);  
        $email = mysqli_real_escape_string($link, $email);  
        $password = mysqli_real_escape_string($link, $password);

        $sql = "SELECT * from startupusers WHERE email = '$email'";
        $result=mysqli_query($link,$sql);
        if(mysqli_num_rows($result)==1)
        {
            $row =mysqli_fetch_array($result);
            if($row['password']==$password)
            {
                //not done yet
                session_start();
                $email = $_POST['email'];
                $_SESSION["id"] = $email;
                $_SESSION['sid']=$row['id'];
                $_SESSION['s_is_auth']=true;
                $_SESSION['verified']=$row['verified'];
                header("Location: userhome.php");

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


$error = "";
if(array_key_exists("submit", $_POST)){
 
    $errors=array('email'=>'','name'=>'','phone'=>'','startupname'=>'','startuptype'=>'','location'=>'','sdescription'=>'','password'=>'');
    if(isset($_POST['submit'])){

    if(empty($_POST['email'])){
      $errors['email']='Email is required <br />';
    }else{
      $email= $_POST['email'];
      if(!preg_match('/^[a-zA-Z0-9]([a-zA-Z0-9][\.\+\-\_\!\#\$\%\&\'\*\+\-\/\=\?\^\_\`\{\|]{0,1}){0,62}([a-zA-Z0-9][\@])([\a-zA-Z0-9\-]{1,6}[\.]){1,3}([a-zA-Z]){2,4}$/',$email))
      {
        $errors['email']='Email must be the valid email address <br />';
      }
    }

    if(empty($_POST['name'])){
      $errors['name']='Name is required <br />';
    }else{
      $name=$_POST['name'];
      if(!preg_match('/^[a-zA-Z\s]+$/',$name)){
        $errors['name']= 'Name must be letters and spaces only <br/>';
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
        $error = "";
        
        $name=$_POST['name'];
        $email=$_POST['email'];
        $phone = $_POST['phone'];
        $password=$_POST['password'];
        $token = bin2hex(random_bytes(50)); // generate unique token
        $user='startup';
        

            //header("Location: home.php");
                $name = $_POST['name'];
                $email = mysqli_real_escape_string($link, $_POST['email']);
                $phone = $_POST['phone'];
                $password = mysqli_real_escape_string($link, $_POST['password']);


                $sql = "SELECT * FROM startupusers WHERE email='$email' LIMIT 1";
                $result = mysqli_query($link, $sql);
                if (mysqli_num_rows($result) > 0) {
                    //echo "Email already exists";
                    $error .= "Email already exists. Log In to your account";
                }
                else
                {

                    $query = "INSERT INTO startupusers (name,email,phone,password,token) VALUES
                    ('$name','$email','$phone','$password','$token')";

                
                    if(mysqli_query($link, $query)){
                            session_start();
                            $userid =  mysqli_insert_id($link);
                            $_SESSION['sid'] = $userid;
                            $_SESSION['s_is_auth']=false;
                            $_SESSION['verified'] = false;
                            sendVerificationEmail($email, $token,$user,$userid);
                            echo '<div class="alert alert-success alert-dismissible fade show">
                            <strong>Success!</strong> Email has been sent to your email id for verification. Please verify to continue and then login!
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>';
                            
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



   <!--  <div id="error" class="p-3 mb-2 bg-danger text-white">
    
        <?php 
        //echo "$error"; 
        ?>

    
    </div>     -->





<?php
    if(isset($_GET['reg'])){
    if($_GET['reg']=='signup'){?>
    <div class="row" id="signupdiv">
            <div class="col-12 ">
                <form id="mysform" method="POST" style="margin-top: 1em;">
                    
                    <h3 style="text-align: center;">User Registration</h3>
                    <hr style="border-top: 1px solid #9900cc;">
                    
                    <br>
                    <h5>Basic Details</h5>
                    <hr style="border-top: 1px solid #9900cc;">
                    <div class="form-group row ">
<!-- NAME -->                       
                            <label for="firstname" class="col-form-label col-12 col-md-1 ">Name</label>
                            <div class="col-12 col-md-5 ">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
                                <span class="errorresult" style="color:red;"><?php if(isset($errors['name'])){echo $errors['name'];}?></span>
                            </div>
<!-- EMAIL -->                      
                            <label for="firstname" class="col-form-label col-12 col-md-1 ">Email</label>
                            <div class="col-12 col-md-5 ">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter your Email">
                                <span class="errorresult" style="color:red;"><?php if(isset($errors['email'])){echo $errors['email'];}?></span>
                            </div>
                        
                    </div>
                    
                    <div class="form-group row ">
<!-- PHONE -->
                            <label for="firstname" class="col-form-label col-12 col-md-1 ">Phone</label>
                            
                            <div class="col-8 col-md-3 ">
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Contact number">
                                <span class="errorresult" style="color:red;"><?php if(isset($errors['phone'])){echo $errors['phone'];}?></span>
                                
                            </div>
                        
                           
                    </div>
                    <br>
                                       
                    <br>
                    <h5>Create Password</h5>
                    <hr style="border-top: 1px solid #9900cc;">
                    <div class="form-group row ">
                        
                            <label for="password" class="col-form-label col-12 col-md-1 ">Enter Password</label>
                            <div class="col-12 col-md-5 ">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" minlength = "8" maxlength = "16">
                                <span id="result" style="color:red;"><?php if(isset($errors['password'])){echo $errors['password'];}?></span>
                            </div>
                        
                            <label for="confirmpassword" class="col-form-label col-12 col-md-1 ">Confirm Password</label>
                            <div class="col-12 col-md-5 ">
                                <input type="password" class="form-control" id="confirmpassword" minlength = "8" maxlength = "16"
                                name="confirmpassword" placeholder="Confirm Password">
                                <span id="confirmpasswordresult" style="color:red;"></span>
                            </div>
                        
                    </div>
                    <br>
                    <div class="form-group row">
                        <div class="offset-1 offset-md-2">
                            <input type="submit" class="btn btn-primary" name="submit" value="Sign Up">
                        </div>

                        
                    </div>
                    
                    
                </form>
                
            </div>
            
        </div>
        <div class="row">
        <div class="offset-md-4">
            <h4><a href="user.php?reg=login">Already have an account? Login Here</a></h4>
        </div>
        </div>


    </div>
    </div>
    </div>

</div>


<?php } else { ?>
<!-- LOGIN division -->

        <div class="row">
            <h2></h2>
            
        </div>
        <div class="row">
            <div class="col-12 ">
                <form method="POST" id="mysform" style="margin-top: 1em;">
                    
                    <h3 style="text-align: center;">User Log In</h3>
                    <hr style="border-top: 1px solid #9900cc;">
                    <br>
                    <h5>Enter Credentials</h5>
                    <hr style="border-top: 1px solid #9900cc;">
                    <div class="form-group row ">
                        
                            <label for="email" class="col-form-label col-12 col-md-1 ">Email</label>
                            <div class="col-12 col-md-5 ">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email">
                            </div>
                        
                            <label for="password" class="col-form-label col-12 col-md-1 ">Password</label>
                            <div class="col-12 col-md-5 ">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                            </div>
                        
                    </div>
                    <br>
                    <div class="form-group row">
                        <div class="offset-1 offset-md-6">
                            <button type="submit" class="btn btn-primary" name="l-submit" style="background-color: #9900cc;">Log In</button>
                        </div>
                        
                    </div>
                    
                    
                </form>
                
            </div>
        </div>
        <div class="row">
        <div class="offset-md-4">
            <h5 align="center"><a href="user.php?reg=signup">Dont have an account? You can SignUp Here!</a></h5>
            <h5 align="center"><a href="test.php?reg=startup">    Forgot password</a></h5>
            <br><br><br><br><br>
        </div>
        </div>
        </div>
<?php }} ?>

    <script type="text/javascript">
        


$(document).ready(function() {
        $('#password').keyup(function() {
            $('#result').html(checkStrength($('#password').val()))
            })
            var regexpwtooweak = /^(((?=.*[a-z])|(?=.*[0-9])|(?=.*[A-Z]))([a-z0-9A-Z]{8,16}))$/;
            var regexpweak = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{8,16}$/; 
            var regexpwmod = /^((?=.*[a-z])|(?=.*[A-Z])|(?=.*[0-9]))(?=.*[-@.+_!#$%&'\/=?^`{|])([a-zA-Z0-9-.+_!#$%&'@*\/=?^`{|]{8,16})$/;
            var regexpwstrong = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[-@.+_!#$%&'\/=?^`{|])([a-zA-Z0-9-.+_!#$%&'@*\/=?^`{|]{8,16})$/;
            var regexpwtoostrong = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[-@.+_!#$%&'\/=?^`{|].*[-@.+_!#$%&'\/=?^`{|].*[-@.+_!#$%&'\/=?^`{|].*[-@.+_!#$%&'\/=?^`{|].*)([a-zA-Z0-9-.+_!#$%&'@*\/=?^`{|]{8,16})$/;
            function checkStrength(password) {
                

            if(regexpwtoostrong.test(password)) {
                $('#result').removeClass()
                $('#result').css("color","#003300");
                return 'Your password is Too Strong'
            }
            else if (regexpwstrong.test(password)) {
                $('#result').removeClass()
                $('#result').css("color","green");
                return 'Your password is Strong'
            }
            else if (regexpwmod.test(password)) {
                $('#result').removeClass()
                $('#result').css("color","orange");
                return 'Your password is Moderate'
            }
            else if (regexpweak.test(password)) {
                $('#result').removeClass()
                $('#result').css("color","red");
                return 'Your password is Weak'
            }
            else{
                $('#result').removeClass()
                $('#result').css('color','maroon');
                return 'Your password is Too weak'
            }
        }
    });

function reset()
{
    nameresult.innerHTML="";
    startupnameresult.innerHTML ="";
    startuptyperesult.innerHTML ="";
    locationresult.innerHTML="";
    sdescriptionresult.innerHTML ="";
    phoneresult.innerHTML ="";
    emailresult.innerHTML ="";
    result.innerHTML ="Your Password is Too weak";
    confirmpasswordresult.innerHTML ="";

}

function validateform() {
 reset();
  var regexphone = /^(\+91)?[6|7|8|9]{1}[0-9]{9}$/;
  var regexemail = /^[a-zA-Z0-9]([a-zA-Z0-9][\.\+\-\_\!\#\$\%\&\'\*\+\-\/\=\?\^\_\`\{\|]{0,1}){0,62}([a-zA-Z0-9][\@])([\a-zA-Z0-9\-]{1,6}[\.]){1,3}([a-zA-Z]){2,4}$/;

  

  var regname = /^[a-zA-Z\s]{2,40}$/;

  //const phone = $("#phone").val();
var phone = document.getElementById("phone").value;
var email = document.getElementById("email").value;
var password = document.getElementById("password").value;

var confirmpassword = document.getElementById("confirmpassword").value; 
var name = document.getElementById("name").value;
var startupname = document.getElementById("startupname").value;
var startuptype = document.getElementById("startuptype").value;
var location = document.getElementById("location").value;
var sdescription = document.getElementById("sdescription").value;

var emailresult = document.getElementById("emailresult");
var phoneresult = document.getElementById("phoneresult");
var nameresult = document.getElementById("nameresult");
var passwordresult = document.getElementById("result");
var startupnameresult = document.getElementById("startupnameresult");
var startuptyperesult = document.getElementById("startuptyperesult");
var locationresult = document.getElementById("locationresult");
var sdescriptionresult = document.getElementById("sdescriptionresult");

var flag=true;

/* EMPTY FIELD Validation  */
/*NAME Validation*/

    if(name.length == 0){
        nameresult.innerHTML = "NAME is Required";
        nameresult.style.color = "red";
        flag=false;
    }

    if(!regname.test(name)) {
        nameresult.innerHTML = "Please enter proper NAME format";
        nameresult.style.color = "red";
        flag=false;
    }


/*PHONE Validation*/
    if(phone.length == 0){
        phoneresult.innerHTML = "PHONE NUMBER is Required";
        phoneresult.style.color = "red";
        flag=false;
    }
    else if(regexphone.test(phone)){
        console.log("This is a VALID Phone Number");
        phoneresult.innerHTML = "Your Phone Number is Valid";
        phoneresult.style.color = "green";
       
    }
    else{
        console.log("This is NOT a VALID Phone Number");
        phoneresult.innerHTML = "This is NOT a VALID Phone Number";
        phoneresult.style.color = "red";
        flag=false;
    }

/*EMAIL Validation*/
    if(email.length == 0){
        emailresult.innerHTML = "EMAIL is Required";
        emailresult.style.color = "red";
        flag=false;
    }
    else if(regexemail.test(email)){
        console.log("This is a VALID EMAIL Address");
        emailresult.innerHTML = "Your Email Address is Valid";
        emailresult.style.color = "green"; 
    }
    else{
        console.log("This is NOT a VALID EMAIL Address");
        emailresult.innerHTML = "This is NOT a VALID EMAIL Address";
        emailresult.style.color = "red";
        flag=false;
    }

/*PASSWORD Validation*/
    if(password.length == 0){
        passwordresult.innerHTML = "PASSWORD is Required";
        passwordresult.style.color = "red";
        flag=false;
    }
    else if(password.length < 8){
        passwordresult.innerHTML = "PASSWORD should be of min. 8 characters";
        result.style.color = "red";
        flag=false;
    }
    else if(password != confirmpassword)
    {
        confirmpasswordresult.innerHTML = "PASSWORDs do not match";
        confirmpasswordresult.style.color = "red";
        flag=false;
    }
    else
    {
        passwordresult.innerHTML = "PASSWORD validation done";
        passwordresult.style.color = "green";

    }

    if(flag==true)
    {
        alert("Validation successfull!");
        
        return true;
        
    }
    else{
        alert("Validation failed!");
        return false;
    }
  

  
}


 //validate('+918989898989');



    </script>

       
<?php require('footer.php'); 
?>
