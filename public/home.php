<?php
$pagetitle = "ABC | Home";
session_start();
require_once 'includes/autoload.php';
include 'includes/security.php';
include 'includes/header.php';
use classes\business\UserManager;
use classes\business\SubscribeManager;


$UM = new UserManager();
$existuser=$UM->getUserByEmail($_SESSION["email"]);
$firstName=$existuser->firstName;
$lastName=$existuser->lastName;
$email=$existuser->email;
$countrycode=$existuser->country;
$country = $UM->getCountry($countrycode);

$SM = new SubscribeManager();

//echo $_SESSION['email'];
//var_dump ($_SESSION);

$role="";
if ($_SESSION["role"] == "admin"){
    $role="(Admin)";
}


?>

<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
<!--<link rel="stylesheet" type="text/css" href="bootstrap/css/layout.css">-->
<link rel="stylesheet" type="text/css" href="bootstrap/css/design.css">

<div class="container">
	</br>
    <div class="row" style="display: flex; justify-content: center;">
        <img src="images/default.png" class="img-responsive img-circle" alt="Profile Picture">
    </div>
    <div class="row" style="text-align: center;">
        <h3><b><?=$firstName.' '.$lastName."</br>".$role;?></h3>
    </div></br></br>


    <div class="row">
      <div class="col-lg-12">
        <div class="row" style="border-bottom: 1px solid #ccc; padding-top: 30px">
          <div class="col-lg-9">
            <p style="font-weight: 700; font-size: 20px">Your Public Profile</p>
          </div>
        </div>

        <form class="form-horizontal" method="post">
          <div class="form-group" style="padding: 30px 0 0 0">
            <label class="control-label col-lg-3" style="text-align: left; font-size: 18px">Email Address</label>
            <div class="col-lg-9">
              <input type="text" name="email" value="<?=$email?>" size="50" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$" placeholder="e.g example@domain.com" title="Please enter a valid email" class="form-control input-fields" readonly>
            </div>
          </div>

          <div class="form-group" style="padding: 30px 0 0 0">
            <label class="control-label col-lg-3" style="text-align: left; font-size: 18px">First Name</label>
            <div class="col-lg-9">
              <input type="text" name="firstName" value="<?=$firstName?>" size="50" pattern="[a-zA-Z]{3,20}" placeholder="e.g Jack" title="First name should be between 3-20 characters" class="form-control input-fields" readonly>
            </div>
          </div>

          <div class="form-group" style="padding: 30px 0 0 0">
            <label class="control-label col-lg-3" style="text-align: left; font-size: 18px; color: #000">Last Name</label></a>
            <div class="col-lg-9">
              <input type="text" name="lastName" value="<?=$lastName?>" size="50" pattern="[a-zA-Z ]{3,20}" placeholder="e.g Smith" title="Last name should be between 3-20 characters" class="form-control input-fields" readonly>
            </div>
          </div>

          <div class="form-group" style="padding: 30px 0 0 0">
            <label class="control-label col-lg-3" style="text-align: left; font-size: 18px">Country</label>
            <div class="col-lg-9">
                <input type="text" name="country" value="<?=$country?>" size="50" class="form-control input-fields"readonly>
            </div>
          </div>

          <div class="form-group" style="padding: 30px 0 0 0">
            <label class="control-label col-lg-3" style="text-align: left; font-size: 18px">Mail List<br/>Subscription</label>
            <div class="col-lg-9">
              <div class="checkbox">
                <?php 
                $subscribeduser = $SM -> getUserByEmail($_SESSION["email"]);
                if($subscribeduser != NULL) {
                  echo '<label style="color: #4BB543;"><input type="checkbox" checked disabled="checked"><b>Subscribed</label>';
                } else {
                    echo '<label style="color: #cc0000;"><input type="checkbox" disabled="disabled"><b>Not Subscribed</label>';
                }?>
              </div>
            </div>
          </div></br>

          <div class="form-group" style="text-align: right; padding-bottom: 30px">
            <a href="modules/user/updateprofile.php" class="btn btn-lg btn-warning" role="button">To Update Profile Page</a>
          </div>
        </form>
      </div>
    </div>

</div>




<!-- !PAGE CONTENT! -->


<?php
include 'includes/footer.php';
?>
