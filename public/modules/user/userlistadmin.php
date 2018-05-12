<?php
$pagetitle = "ABC | Administer Users";
session_start();
require_once '../../includes/autoload.php';
require_once "../../includes/phpmailer/PHPMailerAutoload.php";

use classes\business\UserManager;
use classes\business\SubscribeManager;
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
  <div class="row form-group">
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
      <button type="submit" class="btn btn-lg btn-warning" style="float: right;">Submit</button>
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

$UM=new UserManager();
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
    <form method="post">
    <table class="table table-bordered">
      <tr>
        <thead style="background-color: #999">
          <th><b>ID</b></th>
          <th><b>First Name</b></th>
          <th><b>Last Name</b></th>
          <th><b>Email</b></th>
          <th><b>Operation</b></th>
          <th><b>Mail</th>
        </thead>
      </tr>    
<?php 
  // Display Users
  foreach ($users as $user) {
    if($user!=null){
?>
      <tr>
        <td><?=$user->id?></td>
        <td><?=$user->firstName?></td>
        <td><?=$user->lastName?></td>
        <td><?=$user->email?></td>
        <td>
        <a href='edituser.php?id=<?php echo $user->id ?>' class="text-info"><b>Edit</a>
        <a href='deleteuser.php?id=<?php echo $user->id ?>' class="text-danger" style="margin-left:10px;"><b>Delete</a>
        </td>
        <td>
        <input type="checkbox" value="<?php echo $user->id; ?>" name="id[]" style="margin-left:30px;"

          <?php 
          // Disable Checkbox if User does not exist in tb_subscription
          $SM = new SubscribeManager();
          $subscribeduser = $SM -> getUserById($user->id);
          if($subscribeduser == NULL) {
            echo 'disabled="disabled"';
          }?>>
        </td>
      </tr>
<?php 
    }
  }
?>
    </table>
    </br>
      <button type="submit" name="submite" value="Submit" class="btn btn-lg btn-warning" style="float: right;">Submit</button>
    </form>
    <br/><br/>
<?php 
}
?>
  </div>
</div>

<!-- Mail List Form -->
<div class="container">
	<div class="row">
    <form name='mail' method="post">

<?php
$arrEmail = array();

// Submit User List Form
if (isset($_POST['submite'])){

  // Save selected users ID into $arrEmail array and display Mail List Form
  if (isset($_POST['id']) != 0) {
    foreach ($_POST['id'] as $id):
    $UM=new UserManager();
    $existuser=$UM->getUserById($id);
    $arrEmail[]=$existuser->email;
    endforeach;
?>
    <!-- Display Mail List Form -->
    <h4>Mail List Form</h4>
    <table class="table"> 
      <tr>
        <td style="padding-top: 20px;"><b>Recipients:</td>
        <td>
          <!-- Explode $arrEmail array into string and display them into 'Recipient' Input Field -->
          <input type="text" name='recipient' value='<?php echo implode(", ", $arrEmail);?>' class="form-control input-fields" size='100' readonly>
      </td>
      </tr>
      <tr>
        <td style="padding-top: 20px;"><b>Subject:</td>
        <td><input type="text" name="subject" placeholder="Subject" class="form-control input-fields"></td>
      </tr>
      <tr>
        <td style="padding-top: 20px;"><b>Message:</td>
        <td><textarea name="message" rows = "7" cols = "50" placeholder="Message" title="Field cannot be empty" class="form-control" required></textarea></td>
      </tr>
    </table></br>
      <button type="submit" name="mail" value="Submit" class="btn btn-lg btn-warning" style="float: right;">Submit</button>

<?php 
  } else { 
?>
    <!-- Display Error Message -->
    <p style="color: #DC143C;"><b>*Please select user/s</b></p>
<?php
  }
} 
?>
    </form>
  </div></br>
</div>

<?php
// Send Bulk Email PHPMailer

$emailArray='';
$name='';
$email='';
$SM = new SubscribeManager();
$UM = new UserManager();

if(isset($_POST["mail"])){

  $emailArray = explode(', ', $_POST["recipient"]);
  
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
  
  foreach ($emailArray as $email){
    $hashkey = $SM -> getUserByEmail($email) -> hashkey;
    $id = $SM -> getUserByEmail($email) -> id;
    $firstname = $UM -> getUserByEmail($email) -> firstName;
    $lastname = $UM -> getUserByEmail($email) -> lastName;
    $link = "localhost/capstone/public/modules/user/unsubscribe.php";
    $mail->addBCC($email);
    $mail->isHTML(true);
    $mail->Subject = $_POST["subject"];
    $mail->Body = "<p>Dear ".$firstname." ".$lastname.",</p><p>".$_POST["message"]. "</p><p>Click on the link below if you want to unsubscribe from our mailing list.</p><p><a href = {$link}?id={$id}&hashkey={$hashkey}>Unsubscribe</a></p>";
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

include '../../includes/footer.php';
?>