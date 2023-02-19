<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "venture3";

$link = mysqli_connect($servername, $username, $password, $database);

if (!$link) {
  die("Connection failed: " . mysqli_connect_error());
}

?>
<?php

require 'vendor/autoload.php';
use Mailgun\Mailgun;
?>

<?php require('header.php'); 
?>  

<?php

if(isset($_POST['id']) && isset($_POST['user']) && isset($_POST['submit']))
{
    $id=$_POST['id'];
    $user=$_POST['user'];
    $pid=$_POST['pid'];
    $pkey=$_POST['pkey'];
    $errors=array('password'=>'');
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
        
        $sql1 = "SELECT * from resetpassword WHERE pid = '$pid'";
        $result=mysqli_query($link,$sql1);

        if($result)
        {
           
            if(mysqli_num_rows($result)==1)
            {
                
                $row =mysqli_fetch_array($result);
                if($row['pkey']==$pkey)
                {
                    $sql2 = "DELETE FROM resetpassword WHERE pid= '$pid'";
                    if(mysqli_query($link,$sql2)){
                        //echo
                    }
                        if($user=='startup')
                        {
                            $sql = "UPDATE startupusers set password='" . $_POST["password"] . "' WHERE id='" . $id . "'";
                            
                            if(mysqli_query($link, $sql)){
                                echo '<div class="alert alert-success alert-dismissible fade show">
                                <strong>Success!</strong> Password updated Successfully!
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>';
                            } 
                            else{
                                echo '<div class="alert alert-warning alert-dismissible fade show">
                                <strong>Error!</strong> Password Updation Failed!
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>';
                            }
                        }
                        if($user=='investor')
                        {
                            $sql = "UPDATE investor set password='" . $_POST["password"] . "' WHERE id='" . $id . "'";
                            
                            if(mysqli_query($link, $sql)){
                                echo '<div class="alert alert-success alert-dismissible fade show">
                                <strong>Success!</strong> Password updated Successfully!
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>';
                            } 
                            else{
                                echo '<div class="alert alert-warning alert-dismissible fade show">
                                <strong>Warning!</strong> Password Updation Failed!
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>';
                            }
                        }
                        if($user=='customer')
                        {
                            $sql = "UPDATE customeruser set password='" . $_POST["password"] . "' WHERE uid='" . $id . "'";
                            
                            if(mysqli_query($link, $sql)){
                                echo '<div class="alert alert-success alert-dismissible fade show">
                                <strong>Success!</strong> Password updated Successfully!
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>';
                            } 
                            else{
                                echo '<div class="alert alert-warning alert-dismissible fade show">
                                <strong>Warning!</strong> Password Updation Failed!
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>';
                            }
                        }

                }
                else
                {
                    echo '<div class="alert alert-warning alert-dismissible fade show">
                    <strong>Warning!</strong> Password activation key is incorrect!
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>';
                } 

            }
        }    
    }
}


?>

 

<div class="row">
            <div class="col-12 ">
                <form id="mysform" method="POST" style="margin-top: 1em;">
                    
                    <h3 style="text-align: center;">Reset Password</h3>
                    <hr style="border-top: 1px solid #9900cc;">
                    <br>
                    <h5>Your Detail</h5>
                    
                    <hr style="border-top: 1px solid #9900cc;">
                    <div class="form-group row ">
                        
                            <label for="firstname" class="col-form-label col-12 col-md-1 ">User</label>
                            <div class="col-12 col-md-5 ">
                                <input type="text" class="form-control" id="firstname" name="user" value='<?php echo $_GET['user'];?>' readonly>
                            </div>

                            <label for="firstname" class="col-form-label col-12 col-md-1 ">Id</label>
                            <div class="col-12 col-md-5 ">
                                <input type="text" class="form-control" id="firstname" name="id" value='<?php echo $_GET['id'];?>' readonly>        
                            </div>

                          
                            <div class="col-12 col-md-5 ">
                                <input type="hidden" class="form-control" id="firstname" name="pid" value='<?php echo $_GET['pid'];?>' readonly>        
                            </div>

                           
                            <div class="col-12 col-md-5 ">
                                <input type="hidden" class="form-control" id="firstname" name="pkey" value='<?php echo $_GET['pkey'];?>' readonly>        
                            </div>
                        
                    </div>
                    <h5>Confirm New Password</h5>
                    
                    <hr style="border-top: 1px solid #9900cc;">
                    <div class="form-group row ">
                        
                            <label for="password" class="col-form-label col-12 col-md-1 ">Enter New Password</label>
                            <div class="col-12 col-md-5 ">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" minlength = "8" maxlength = "16">
                                <span id="result" style="color:red;"><?php if(isset($errors['password'])){echo $errors['password'];}?></span>
                            </div>
                    </div>
                    <div class="form-group row ">    
                            <label for="confirmpassword" class="col-form-label col-12 col-md-1 ">Confirm Password</label>
                            <div class="col-12 col-md-5 ">
                                <input type="password" class="form-control" id="confirmpassword" minlength = "8" maxlength = "16"
                                name="confirmpassword" placeholder="Confirm Password">
                                <span id="confirmpasswordresult" style="color:red;"></span>
                            </div>
                        
                    </div>
                    <div class="form-group row">
                        <div class="offset-6">
                            <input type="submit" class="btn btn-primary" name="submit" value="Confirm">
                        </div>
                        </div>
                    </div>
                    
                    
                </form>
                
            </div>
        </div>
        
</div>



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
</script>
 
       
<?php require('footer.php'); 
?>