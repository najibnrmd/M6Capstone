<?php
$pagetitle = "ABC | View Users";
session_start();
require_once '../../includes/autoload.php';

use classes\business\UserManager;
use classes\entity\User;

ob_start();
include '../../includes/security.php';
include '../../includes/header.php';

?>

<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../../bootstrap/css/design.css">

<!-- Search Bars -->
<div class="container">
  </br>
  <div class="row form-group" style="text-align: center;">
    <form action="" method="GET">

    <div class="col-lg-3">
      <input type="search" class="form-control input-fields" placeholder="Search First Name" name="fname">
    </div>

    <div class="col-lg-3">
      <input type="search" class="form-control input-fields" placeholder="Search Last Name" name="lname">
    </div>

    <div class="col-lg-3">
      <input type="search" class="form-control input-fields" placeholder="Search Email" name="email">
    </div>

    <div class="col-lg-3">
      <button type="submit" class="btn btn-lg btn-warning" style="float: right">Submit</button>
    </div>

    </form>
  </div>

<?php

$UM=new UserManager();

// Search First Name
if(isset($_GET['fname'])){
  $fname = $_GET['fname'];
  if($_GET['fname'] != NULL)
  {
      $existuser=$UM->searchUserFirstName($fname);
  } 
}
// Search Last Name
if(isset($_GET['lname'])){
  $lname = $_GET['lname'];
  if($_GET['lname'] != NULL)
  {
      $existuser=$UM->searchUserLastName($lname);
  }
}
// Search Email
if(isset($_GET['email'])){
  $email = $_GET['email'];
  if($_GET['email'] != NULL)
  {
      $existuser=$UM->searchUserEmail($email);
  }
}
// IF Search User Exists in DB
if(isset($existuser)){ 
  if(count($existuser) <= 1){?>
<!-- Search Results Table -->
  </br>
  <div class="row">  
    <h4>Search Results: <span class="badge"><?php echo (count($existuser) - 1); ?></span></h4></br>
    <p style="color: #DC143C;"><b>No results found.</p>
    <p>Tips to get the most out of search:</b>
    <ul>
      <li>Please make sure your keywords are spelled correctly</li>
      <li>Try different keywords for firstnames, lastnames, or emails</li>
      <li>Try fewer and less specific keywords</li>
    </ul>
    </p>

<?php
  } else {
?>
  </br>
  <div class="row">  
    <h4>Search Results: <span class="badge"><?php echo (count($existuser) - 1); ?></span></h4></br>
    <table class="table table-bordered">
      <tr>
        <thead style="background-color: #999">
          <th><b>ID</th>
          <th><b>First Name</th>
          <th><b>Last Name</th>
          <th><b>Email</th>
        </thead>
      </tr>
<?php 
  // Display Search Results
  foreach ($existuser as $user){
    if($user!=null){
?>
      <tr>
        <td><?=$user->id?></td>
        <td><?=$user->firstName?></td>
        <td><?=$user->lastName?></td>
        <td><?=$user->email?></td>
      </tr>
<?php
    }
  }   
}
}
?>
    </table>
  </div>
</div>

<?php

$UM = new UserManager();
$users=$UM->getAllUsers();

// IF User Exists in DB
if(isset($users)){
?>

<!-- User List Table -->
<div class="container">
  <br/>
  <div class="row">
    <h4>Below is the list of Developers registered in community portal: <span class="badge"><?php echo (count($users) - 1); ?></span></h4>
    <br/>
    <table class="table table-bordered">
      <tr>
        <thead style="background-color: #999">
          <th><b>ID</b></th>
          <th><b>First Name</b></th>
          <th><b>Last Name</b></th>
          <th><b>Email</b></th>
        </thead>
      </tr>    
<?php 
  // Display Users
  foreach ($users as $user){
    if($user!=null){
?>
    <tr>
      <td><?=$user->id?></td>
      <td><?=$user->firstName?></td>
      <td><?=$user->lastName?></td>
      <td><?=$user->email?></td>
    </tr>
<?php 
    }
  }
?>
    </table><br/><br/>
<?php 
}
?>
  </div>
</div>

<?php
include '../../includes/footer.php';
?>