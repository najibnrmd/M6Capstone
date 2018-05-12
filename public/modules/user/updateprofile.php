<?php
$pagetitle = "ABC | Update Profile";
session_start();
require_once '../../includes/autoload.php';
require_once "../../includes/phpmailer/PHPMailerAutoload.php";

use classes\business\UserManager;
use classes\business\SubscribeManager;
use classes\entity\User;

ob_start();
include '../../includes/security.php';
include '../../includes/header.php';
include '../../includes/password.php';
?>

<?php

$formerror="";
$firstName="";
$lastName="";
$email="";
$password="";
$country="";


$SM=new SubscribeManager();


if(!isset($_POST["submitted"])){
  $UM=new UserManager();
  $existuser=$UM->getUserByEmail($_SESSION["email"]);
  $firstName=$existuser->firstName;
  $lastName=$existuser->lastName;
  $email=$existuser->email;
  $country=$existuser->country;
  $password=$existuser->password;

}else{
  $firstName=$_POST["firstName"];
  $lastName=$_POST["lastName"];
  $email=$_POST["email"];
  $country=$_POST["country"];
  $password=$_POST["password"];
  $password=password_hash($password, PASSWORD_DEFAULT);

  if($firstName!='' && $email!='' && $country!='' && $password!=''){
    $update=true;
    $UM=new UserManager();
    if($email!=$_SESSION["email"]){
      $existuser=$UM->getUserByEmail($email);
      if(is_null($existuser)==false){
        $formerror="User Email already in use, unable to update email";
        $update=false;
      }
    }
    if($update){
      $existuser=$UM->getUserByEmail($_SESSION["email"]);
      $existuser->firstName=$firstName;
      $existuser->lastName=$lastName;
      $existuser->email=$email;
      $existuser->country=$country;
      $existuser->password=$password;
      $UM->saveUser($existuser);
      $_SESSION["email"]=$email;

      $subscribeduser = $SM -> getUserByEmail($_SESSION["email"]);
      if($subscribeduser != NULL) {
        if (!isset($_POST['subscription'])){
          $UM=new UserManager();
          $existuser=$UM->getUserByEmail($_SESSION["email"]);
          $id=$existuser->id;
          $hashkey = md5($id);
          $SM=new SubscribeManager();
          $SM->unsubscribe($id, $hashkey);

          //PHPMailer

          $mail = new PHPMailer;
          //Enable SMTP debugging.
          //$mail->SMTPDebug = 3;
          //Set PHPMailer to use SMTP.
          $mail->isSMTP();
          //Set SMTP host name
          $mail->Host = "in-v3.mailjet.com";
          //Set this to true if SMTP host requires authentication
          $mail->SMTPAuth = true;
          $mail->SMTPKeepAlive = true;
          //$mail->SMTPSecure = 'ssl';
          //Provide username and password
          $mail->Username = "";
          $mail->Password = "";
          //If SMTP requires TLS encryption then set it
          $mail->SMTPSecure = "tls";
          //Set TCP port to connect to
          //$mail->Port = 587;
          $mail->Port = 25;
          $mail->From = "";
          $mail->FromName = "Administrator";
          
          //$hashkey = $SM -> getUserByEmail($email) -> hashkey;
          //$id = $SM -> getUserByEmail($email) -> id;
          $firstname = $existuser -> firstName;
          $lastname = $existuser -> lastName;
          //$link = "localhost/capstone/public/modules/user/unsubscribe.php";
          $mail->addBCC($email);
          $mail->isHTML(true);
          $mail->Subject = "ABC DevOps Mailing List - Unsubscribe Successful";
          $mail->Body = "<p>Dear ".$firstname." ".$lastname.",</p><p>You are have successfully unsubscribed from our mailing list.";
          $mail->AltBody = "This is the plain text version of the email content";
          if(!$mail->send())
          {
              echo "Mailer Error: " . $mail->ErrorInfo;
          }
          else
          {
              echo "Message has been sent successfully";
              $mail->clearAllRecipients();
          }

        }
      } else {
        if (isset($_POST['subscription'])){
          $UM=new UserManager();
          $existuser=$UM->getUserByEmail($_SESSION["email"]);
          $id=$existuser->id;
          $SM=new SubscribeManager();
          $SM->subscribe($id, $email);

          //PHPMailer

          $mail = new PHPMailer;
          //Enable SMTP debugging.
          //$mail->SMTPDebug = 3;
          //Set PHPMailer to use SMTP.
          $mail->isSMTP();
          //Set SMTP host name
          $mail->Host = "in-v3.mailjet.com";
          //Set this to true if SMTP host requires authentication
          $mail->SMTPAuth = true;
          $mail->SMTPKeepAlive = true;
          //$mail->SMTPSecure = 'ssl';
          //Provide username and password
          $mail->Username = "";
          $mail->Password = "";
          //If SMTP requires TLS encryption then set it
          $mail->SMTPSecure = "tls";
          //Set TCP port to connect to
          //$mail->Port = 587;
          $mail->Port = 25;
          $mail->From = "";
          $mail->FromName = "Administrator";
          
          $hashkey = $SM -> getUserByEmail($email) -> hashkey;
          //$id = $SM -> getUserByEmail($email) -> id;
          $firstname = $existuser -> firstName;
          $lastname = $existuser -> lastName;
          $link = "localhost/capstone/public/modules/user/unsubscribe.php";
          $mail->addBCC($email);
          $mail->isHTML(true);
          $mail->Subject = "ABC DevOps Mailing List - Unsubscribe Successful";
          $mail->Body = "<p>Dear ".$firstname." ".$lastname.",</p><p>You are now subscribed to our mailing list! Thank You!</p><p>Click on the link below if you want to unsubscribe from our mailing list.</p><p><a href = {$link}?id={$id}&hashkey={$hashkey}>Unsubscribe</a></p>";
          $mail->AltBody = "This is the plain text version of the email content";
          if(!$mail->send())
          {
              echo "Mailer Error: " . $mail->ErrorInfo;
          }
          else
          {
              echo "Message has been sent successfully";
              $mail->clearAllRecipients();
          }

        }
      }
      header("Location:../../home.php");
    } 
  }else{
      $formerror="Please provide required values";
  }
}
?>
<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../../bootstrap/css/design.css">


  <div class="container">

    <div class="row">
      <div class="col-lg-12" style="text-align: center; padding-top: 30px;">
        <h2 style="font-size: 36px"><b>ABC Developer Community</b></h2>
      </div>  
    </div>

    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="row" style="border-bottom: 1px solid #ccc; padding-top: 30px">
          <div class="col-lg-9">
            <p style="font-weight: 700; font-size: 20px">Update Profile</p>
          </div>
        </div>

        <form class="form-horizontal" method="post">
          <div class="form-group" style="padding: 30px 0 0 0">
            <label class="control-label col-lg-3" style="text-align: left; font-size: 18px">Email Address *</label>
            <div class="col-lg-9">
              <input type="text" name="email" value="<?=$email?>" size="50" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$" placeholder="e.g example@domain.com" title="Please enter a valid email" class="form-control input-fields" required>
            </div>
          </div>

          <div class="form-group" style="padding: 30px 0 0 0">
            <label class="control-label col-lg-3" style="text-align: left; font-size: 18px">First Name *</label>
            <div class="col-lg-9">
              <input type="text" name="firstName" value="<?=$firstName?>" size="50" pattern="[a-zA-Z]{3,20}" placeholder="e.g Jack" title="First name should be between 3-20 characters" class="form-control input-fields" required>
            </div>
          </div>

          <div class="form-group" style="padding: 30px 0 0 0">
          <a href="#" data-toggle="tooltip" data-placement="left" title="Optional. Alternatively, you can use your surname or father's name as your last name."><label class="control-label col-lg-3" style="text-align: left; font-size: 18px; color: #000">Last Name: <span class="glyphicon glyphicon-question-sign"></span></label></a>
            <div class="col-lg-9">
              <input type="text" name="lastName" value="<?=$lastName?>" size="50" pattern="[a-zA-Z ]{3,20}" placeholder="e.g Smith" title="Last name should be between 3-20 characters" class="form-control input-fields">
            </div>
          </div>

          <div class="form-group" style="padding: 30px 0 0 0">
            <label class="control-label col-lg-3" style="text-align: left; font-size: 18px">Country *</label>
            <div class="col-lg-9">
              <select class="form-control input-fields" name="country">
                <?php 
                $UM = new UserManager;
                $countries = $UM-> getCountries();
                echo $countries; 
                ?>
              </select>
            </div>
          </div>

          <div class="form-group" style="padding: 30px 0 0 0">
            <label class="control-label col-lg-3" style="text-align: left; font-size: 18px">Password *</label>
            <div class="col-lg-9">
              <input type="password" name="password" value="" size="20" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Must have at least 8 characters" title="Password must consist of at least 8 characters with at least one uppercase letter, one lowercase letter and one digit" class="form-control input-fields" required>
            </div>
          </div>

          <div class="form-group" style="padding: 30px 0 0 0">
            <label class="control-label col-lg-3" style="text-align: left; font-size: 18px"`>Confirm<br/>Password *</label>
            <div class="col-lg-9">
              <input type="password" name="cpassword" value="" size="20" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Re-enter password" title="Password does not match" class="form-control input-fields" required>
            </div>
          </div>

          <div class="form-group" style="padding: 30px 0 0 0">
            <label class="control-label col-lg-3" style="text-align: left; font-size: 18px">Mail List<br/>Subscription</label>
            <div class="col-lg-9">
              <div class="checkbox">
                <label><input type="checkbox" name="subscription" value="Subscribe"
                <?php 
                $subscribeduser = $SM -> getUserByEmail($_SESSION["email"]);
                if($subscribeduser != NULL) {
                  echo 'checked="checked"';
                }?>>Subscribe</label>
              </div>
            </div>
          </div>

          <div class="form-group" style="text-align: right; padding-bottom: 30px">
            <button type="reset" name="reset" value="Reset" class="btn btn-default btn-lg" style="padding-left: 30px; padding-right: 30px; margin-right: 20px">Reset</button>
            <button type="submit" name="submitted" value="Submit" class="btn btn-warning btn-lg">Update</button>
            
          </div>
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="../../bootstrap/js/bootstrap.min.js"></script>

  <script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
  </script>

<?php
include '../../includes/footer.php';
?>