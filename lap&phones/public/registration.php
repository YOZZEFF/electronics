<?php
ob_start(); 

require('../includes/layouts/__header.php');
require('../includes/connectdb.php');


?>

<?php
 
if(isset($_POST['submit'])){

$name=$_POST['name'];
$phone=$_POST['phone'];
$email=$_POST['email'];
$password=$_POST['password'];
$hashpassword=password_hash($password,PASSWORD_DEFAULT);


$errors= array();

if(empty($name) OR empty($email) OR empty($password) OR empty($phone)){
  array_push($errors, "All fields are required");
  
  
}
 else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
  array_push($errors,"email is not valid");
}
else if(strlen($password)<8){
  array_push($errors,"password must be at least 8 charchtes long");
}


$sql="SELECT * FROM users WHERE `email`='$email'";
$resault=mysqli_query($connection,$sql);
$rowCount=mysqli_num_rows($resault);
//  to make sure this email is already exists or not 
if($rowCount>0){

  array_push($errors,"email already exists");
}
  if(count($errors)>0){
    foreach($errors as $error){
      echo "<div class='btn btn-danger' style='width:100%;height:40px;margin-top:100px;'>$error</div>";

    }
  }
else{

$sql="INSERT INTO users(name,email,password,phone) VALUES (?,?,?,?)";
$stmt= mysqli_stmt_init($connection);
$prepareStmt= mysqli_stmt_prepare($stmt,$sql);
if($prepareStmt){
  mysqli_stmt_bind_param($stmt,'ssss',$name,$email,$hashpassword,$phone);
  mysqli_stmt_execute($stmt);
  header('location: login.php');


}else{
  die('something wrong');
}

}
}
ob_end_flush();
?>
   <div class="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>Registration</h2>
                    </div>
                    <form class="main_form" action="registration.php" method="POST">
                        <div class="row">

                        <div class=" col-md-12">
                                <input class="form-control" placeholder="Name" type="text" name="name">
                            </div>
                        <div class=" col-md-12">
                                <input class="form-control" placeholder="Phone" type="text" name="phone">
                            </div>
                           
                            <div class=" col-md-12">
                                <input class="form-control" placeholder="Email" type="email" name="email">
                            </div>
                            
                            <div class=" col-md-12">
                                <input class="form-control" placeholder="Password" type="password" name="password">
                            </div>
                            
                            <div class=" col-md-12">
                                <button class="send" name="submit" value="submit">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





<?php
require('../includes/layouts/__footer.php');
?> 
