<?php
ob_start(); 

require('../includes/layouts/__header.php');
require('../includes/connectdb.php');
?>

<?php


  if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE `email`='$email' ";
    $resault = mysqli_query($connection, $sql);
    $user = mysqli_fetch_assoc($resault);
     $errors =array();



    
    if ($user) {
        if (password_verify($password, $user['password'])) {
          $_SESSION['user'] = 'yes';
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['name'] = $user['name'];
          header('Location: index.php');
          // die();

        
         
         
        
        } else {
          array_push($errors,'password does not match');

        }
      
    } else {
      array_push($errors,'email does not match');

    }


    if( count($errors)>0){
      foreach($errors as $error)
      echo "<div class='btn btn-danger' style='width:100%;height:40px;margin-top:100px;'>$error</div>";
    }
  }
  ?>
 

    <div class="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>Login</h2>
                    </div>
                    <form class="main_form" action="login.php" method="POST">
                        <div class="row">
                           
                           
                            <div class=" col-md-12">
                                <input class="form-control" placeholder="email" type="email" name="email">
                            </div>
                            
                            <div class=" col-md-12">
                                <input class="form-control" placeholder="password" type="password" name="password">
                            </div>
                            
                            <div class=" col-md-12">
                                <button class="send" name="login" value="login">Login</button>
                                <p style="padding-top:20px ;">if you're not registerd go to <a href="registration.php" style="text-decoration:none;color:black;font-weight:bold;"> Register</a></p>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
require('../includes/layouts/__footer.php');
ob_end_flush();

?> 
