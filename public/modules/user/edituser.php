<?php
$pagetitle = "ABC | Edit User";
session_start();
require_once '../../includes/autoload.php';

use classes\business\UserManager;
use classes\business\SubscribeManager;
use classes\entity\User;

ob_start();
include '../../includes/security.php';
include '../../includes/header.php';
include '../../includes/password.php';
?>

<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../../bootstrap/css/design.css">

<div class="container">

<?php

$formerror="";
$firstName="";
$lastName="";
$email="";
$password="";

$UM=new UserManager();
$SM=new SubscribeManager();

if(!isset($_POST["submitted"])){
  $UM=new UserManager();
  $existuser=$UM->getUserById($_GET["id"]);
  $firstName=$existuser->firstName;
  $lastName=$existuser->lastName;
  $email=$existuser->email;
  $country=$existuser->country;
  $password=$existuser->password;
}
else
{
  $firstName=$_POST["firstName"];
  $lastName=$_POST["lastName"];
  $email=$_POST["email"];
  $country=$_POST["country"];
  $password=$_POST["password"];
  $password=password_hash($password, PASSWORD_DEFAULT);

  if($firstName!='' && $email!='' && $country!='' && $password!=''){
       $update=true;
       $UM=new UserManager();
       // if($email!=$_SESSION["email"]){
       //     $existuser=$UM->getUserById($email);
       //     if(is_null($existuser)==false){
       //         $formerror="User Email already in use, unable to update email";
       //         $update=false;
       //     }
       // }
       if($update){
           $existuser=$UM->getUserById($_GET["id"]);
           $existuser->firstName=$firstName;
           $existuser->lastName=$lastName;
           $existuser->email=$email;
           $existuser->country=$country;
           $existuser->password=$password;
           $UM->saveUser($existuser);
           //$_SESSION["email"]=$email;

           $subscribeduser = $SM -> getUserById($_GET["id"]);
           if($subscribeduser != NULL) {
            if (!isset($_POST['subscription'])){
              //$UM=new UserManager();
              //$existuser=$UM->getUserById($_GET["id"]);
              $id=$_GET["id"];
              $hashkey = md5($id);
              $SM=new SubscribeManager();
              $SM->unsubscribe($id, $hashkey);
            }
           } else {
            if (isset($_POST['subscription'])){
              //$UM=new UserManager();
              //$existuser=$UM->getUserById($_GET["id"]);
              $id=$_GET["id"];
              $SM=new SubscribeManager();
              $SM->subscribe($id, $email);
            }
           }
          header("Location:userlistadmin.php");
       }
  }else{
      $formerror="Please provide required values";
  }
}


if(isset($_GET["id"])){
  $existuser=$UM->getUserById($_GET["id"]);
  $role=$existuser->role;
  if ($role == "admin"){?>

<link rel="stylesheet" type="text/css" href="../../bootstrap/css/layout.css">
  <div>
  </br>
    <h3 style="color: #cc0000"><b>Request Denied</b></h3></br>
    <div class="well well-lg">
      <h4>Unable to edit administrator.</br></br>Please contact Database Administrator if necessary.</h4>
    </div>
  </div>

  <?php } else {?>

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
            <label class="control-label col-lg-3" style="text-align: left; font-size: 18px; color: #000">Last Name:</label></a>
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
              <input type="password" name="password" value="<?=$password?>" size="20" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Must have at least 8 characters" title="Password must consist of at least 8 characters with at least one uppercase letter, one lowercase letter and one digit" class="form-control input-fields" required>
            </div>
          </div>

          <div class="form-group" style="padding: 30px 0 0 0">
            <label class="control-label col-lg-3" style="text-align: left; font-size: 18px"`>Confirm<br/>Password *</label>
            <div class="col-lg-9">
              <input type="password" name="cpassword" value="<?=$password?>" size="20" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Re-enter password" title="Password does not match" class="form-control input-fields" required>
            </div>
          </div>

          <div class="form-group" style="padding: 30px 0 0 0">
            <label class="control-label col-lg-3" style="text-align: left; font-size: 18px">Mail List<br/>Subscription</label>
            <div class="col-lg-9">
              <div class="checkbox">
                <label><input type="checkbox" name="subscription" value="Subscribe"
                <?php 
                $subscribeduser = $SM -> getUserById($_GET["id"]);
                if($subscribeduser != NULL) {
                  echo 'checked="checked"';
                }?>>Subscribe</label>
              </div>
            </div>
          </div>

          <div class="form-group" style="text-align: right; padding-bottom: 30px">
            <button type="reset" name="reset" value="Reset" class="btn btn-default btn-lg" style="padding-left: 30px; padding-right: 30px; margin-right: 20px">Reset</button>
            <button type="submit" name="submitted" value="Submit" class="btn btn-primary btn-lg" style="background-color: #FF9933; border-color: #FF9933 !important">Update</button>
            
          </div>
        </form>
      </div>

<?php
}

}
?>

</div>
</div>

<?php
include '../../includes/footer.php';
?>