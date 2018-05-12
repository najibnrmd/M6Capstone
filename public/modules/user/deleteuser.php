<?php
$pagetitle = "ABC | Delete User";
session_start();
require_once '../../includes/autoload.php';

use classes\business\UserManager;
use classes\entity\User;

ob_start();
include '../../includes/security.php';
include '../../includes/header.php';
?>

<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../../bootstrap/css/layout.css">
<link rel="stylesheet" type="text/css" href="../../bootstrap/css/design.css">

<div class="container">

<?php

$formerror="";
$firstName="";
$lastName="";
$email="";
$password="";
$deleteflag=false;


if(isset($_GET["id"])){
  $UM=new UserManager();
  $existuser=$UM->getUserById($_GET["id"]);
  $role=$existuser->role;
  if ($role == "admin"){?>

  <div>
  </br>
    <h3 style="color: #cc0000"><b>Request Denied</b></h3></br>
    <div class="well well-lg">
      <h4>Unable to delete administrator.</br></br>Please contact Database Administrator if necessary.</h4>
    </div>
  </div>

  <?php } else {?>

  <div>
  </br>
    <h3 style=""><b>Delete User</b></h3></br>
    <div class="well well-lg">
      <h4>Are you sure you want to delete the following record?</h4></br>
      <h4><?php
      $UM=new UserManager();
      $existuser=$UM->getUserById($_GET["id"])->email; 
      echo $existuser;
      ?></h4>
    </div>
  </div>

  <form name="deleteUser" class="form-horizontal" method="post">
    <div class="form-group" style="text-align: right; padding-bottom: 30px">
      <button type="submit" name="cancelled" value="Cancel" class="btn btn-default btn-lg" style="margin-right: 20px">Cancel</button>
      <button type="submit" name="submitted" value="Delete" class="btn btn-warning btn-lg" style="margin-right: 15px">Delete</button>
    </div>
  </form>
</div>
<?php
  }
if(isset($_POST["submitted"])){
  $existuser=$UM->deleteAccount($_GET["id"]);
  $deleteflag=true;
  header("Location:../../modules/user/userlistadmin.php");
}else if(isset($_POST["cancelled"])){
	header("Location:../../home.php");
}else{
	if(isset($_GET["id"]))
	{
	  $UM=new UserManager();
	  $existuser=$UM->getUserById($_GET["id"]);
	  $firstName=$existuser->firstName;
	  $lastName=$existuser->lastName;
	  $email=$existuser->email;
	  $password=$existuser->password;
	}
}
}
?>


<?php
include '../../includes/footer.php';
?>