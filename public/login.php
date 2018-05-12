<?php
$pagetitle = "ABC | Login";
session_start();
use classes\business\UserManager;
use classes\business\Validation;

require_once 'includes/autoload.php';
include 'includes/header.php';
include 'includes/password.php';
$formerror="";

$email="";
$password="";
$error_auth="";
$error_name="";
$error_passwd="";
$error_email="";
$validate=new Validation();

if(isset($_POST["submitted"])){

    //Google Recaptcha
    $response = $_POST["g-recaptcha-response"];
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
            'secret' => "",
            'response' => $_POST["g-recaptcha-response"]
          );
    $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($data)
              )
          );
    $context = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captcha_success = json_decode($verify);
    if ($captcha_success->success==false) {
      //echo "<p>You are a bot! Go away!</p>";
      ?>
      <div class="alert alert-danger">
        <strong>Fail!</strong> Please enter the reCaptcha if you have not done so.
      </div>
      <?php
    } else if($captcha_success->success==true) {
      //echo "<p>You are not a bot!</p>";
      ?>
      <div class="alert alert-success">
        <strong>Success!</strong> You are not a bot!
      </div>
      <?php
    }

    // Retrieve User's Input
    $email=$_POST["email"];
    $password=$_POST["password"];

  // Password's RegEx Validation
	//if($validate->check_password($password, $error_passwd))
	//{
		$UM=new UserManager();

		//$existuser=$UM->getUserByEmailPassword($email, $password);
    $existuser=$UM->getUserByEmail($email);
    $hashedpwdDB=$existuser->password;

    // Verify user's (password) input with hashed password from DB
    if(isset($existuser) && password_verify($password, $hashedpwdDB) && $captcha_success->success==true){
		//if(isset($existuser)){

			$_SESSION['email']=$email;
      //changes made here
      $_SESSION['role']=$existuser->role;
			$_SESSION['id']=$existuser->id;
			echo '<meta http-equiv="Refresh" content="1; url=home.php">';
		}else{
			$formerror="Invalid User Name or Password";
		}
	//}
}

?>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="bootstrap/css/design.css">
<script src='https://www.google.com/recaptcha/api.js'></script>

  <div class="container">

    <div class="row">
      <div class="col-lg-12" style="text-align: center; padding-top: 30px;">
        <h2 style="font-size: 36px"><b>ABC Developer Community</b></h2>
      </div>  
    </div>

    <div class="row">
      <div class="col-lg-8 col-lg-offset-2" style="background-color: #F2F2F2; border: 1px solid #ccc; margin-top: 40px; margin-bottom: 60px; padding: 0 20px">
        <div class="row" style="border-bottom: 1px solid #ccc; padding-top: 30px">
          <div class="col-lg-9">
            <p style="font-weight: 700; font-size: 20px">Log In</p>
          </div>
          <div class="col-lg-3">
            <a href="modules/user/register.php" style="color: #169BD5; font-size: 16px;"><p style="text-align: right">New User?</p></a>
          </div>
        </div>

        <form method="post" class="form-horizontal">
          <div class="form-group" style="padding: 30px 0 0 0">
            <label class="control-label col-lg-3" style="text-align: left; font-size: 18px">Email Address:</label>
            <div class="col-lg-8 input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
              <input type="email" name="email" value="<?=$email?>" size="30" placeholder="Enter email address" title="Field cannot be empty" class="form-control input-fields" required>
            </div>
          </div>

          <div class="form-group" style="padding: 30px 0 0 0">
            <label class="control-label col-lg-3" style="text-align: left; font-size: 18px">Password:</label>
            <div class="col-lg-8 input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
              <input type="password" name="password" value="<?=$password?>" size="30" placeholder="Enter password" title="Field cannot be empty" class="form-control input-fields" required>
            </div>
          </div>

          <div class="form-group" style="padding: 30px 0 0 0">
            <div class="col-lg-9 col-lg-offset-3">
              <div class="captcha_wrapper">
                <div class="g-recaptcha" data-sitekey=""></div>
              </div>
            </div>
          </div>

          <div class="form-group" style="padding-bottom: 30px">
            <div class="col-lg-6" style=" margin-top: 30px">
              <a href="forgetpassword.php" style="color: #169BD5; font-size: 16px;">Forgot your password?</a>
            </div>
            <div class="col-lg-6" style="text-align: right; margin-top: 20px">
              <button type="submit" class="btn btn-default btn-lg" style="margin-right: 20px">Clear</button>
              <button type="submit" name="submitted" class="btn btn-warning btn-lg">Log In</button>
            </div>
            <div><?php echo $formerror?></div>
          </div>
        </form>
      </div>
    </div>
  </div></br></br></br></br>

<?php
include 'includes/footer.php';
?>