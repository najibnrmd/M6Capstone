<?php
$pagetitle = "ABC | Unsubscribe Confirmation";
require_once "../../includes/autoload.php";
include "../../includes/header.php";
use classes\business\SubscribeManager;

?>

<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../../bootstrap/css/design.css">
<link rel="stylesheet" type="text/css" href="../../bootstrap/css/layout.css">
<div class="container">

<?php

$id = "";
$hashkey = "";
$msg = "";

// GET User ID from URL
$id = $_GET['id'];
// GET User Hashkey from URL
$hashkey =  $_GET['hashkey'];

$SM = new SubscribeManager();
$existuser = $SM -> getUserById($id);

//var_dump ($existuser);

if ($existuser !== NULL) {  

    if (isset($_POST['subscribe'])){
        $msg = "<div class='alert alert-info alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <b>Info</b></br>You are still subscribed to our mailing list.</br>You will be redirected to our homepage in (5) seconds.
                </div>";
        header("refresh:5; URL=http://localhost/capstone/public/landing.php");
    } elseif (isset($_POST['unsubscribe'])) {

        if ($id != 0 && $hashkey != 0){
        // Unsubscribe User from Mailing List
        $unsubscribeUser = $SM -> unsubscribe($id, $hashkey);
        $msg = "<div class='alert alert-success alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <b>Success</b></br>You have successfully unsubscribe from our mailing list.</br>You will be redirected to our homepage in (5) seconds.
                </div>";
        header("refresh:5; URL=http://localhost/capstone/public/landing.php");
        } else {
        $msg = "Unsubscribe fail.";
        }
    } else {

?>
  <h2>Unsubscribe:</h2>
  <form method="POST">
    <div class="form-group">
        <p>Are you sure you want to unsubscribe from our mailing list?</p>
    </div>
    <button id="yes" name="unsubscribe" type="submit" class="btn btn-default" value="yes">YES</button>
    <button id="no" name="subscribe" type="submit" class="btn btn-default" value="no">NO</button>
  </form>
</div>
<?php 
    }
} else {
    $msg = "<div class='alert alert-warning alert-dismissible'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Warning</b></br>You have already unsubscribe from our mailing list.</br>You will be redirected to our homepage in (5) seconds.
            </div>";
    header("refresh:5; URL=http://localhost/capstone/public/landing.php");  
}
?>

    <p><?php echo $msg;?></p>
</div>

<?php 
include "../../includes/footer.php";
?>