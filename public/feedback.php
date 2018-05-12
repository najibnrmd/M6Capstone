<?php
use classes\entity\Feedback;
use classes\business\FeedbackManager;
use classes\business\Validation;

require_once 'includes/autoload.php';
$formerror="";

$email="";
$error_firstname="";
$error_lastname="";
$error_passwd="";
$error_email="";
$error_comments="";
$validate=new Validation();

if(isset($_POST["submitted"])){
    $email=strip_tags($_POST["email"]);
    $lastname=strip_tags($_POST["lastname"]);
    $firstname=strip_tags($_POST["firstname"]);	
	$comments=strip_tags($_POST["comments"]);	
	
	$validate->check_name($firstname, $error_firstname);
	$validate->check_name($lastname, $error_lastname);
	if(empty($error_firstname) && empty($error_email) && empty($error_comments))
	{
		$feedback=new Feedback();
        $feedback->firstname=$firstname;
        $feedback->lastname=$lastname;
        $feedback->email=$email;
        $feedback->comments=$comments;
		$FM=new FeedbackManager();
		$FM->insertFeedback($feedback);
        $formerror="* Your feedback submitted successfully!";
	}
}
?>
      <div class="col-lg-6" style="margin-top: 60px; margin-bottom: 80px; padding: 0 20px">
        <form method="post" class="form-horizontal">
              <div class="form-group" style="padding: 30px 0 0 0">
                <div class="col-lg-8">
                  <input type="text" name="firstname" placeholder="Your First Name" title="Field cannot be empty" class="form-control" required style="height: 40px">
                </div>
              </div>
              <div class="form-group" style="padding: 30px 0 0 0">
                <div class="col-lg-8">
                  <input type="text" name="lastname" placeholder="Your Last Name" class="form-control" style="height: 40px">
                </div>
              </div>
              <div class="form-group" style="padding: 30px 0 0 0">
                <div class="col-lg-8">
                  <input type="email" name="email" placeholder="Your Email" title="Field cannot be empty" class="form-control" required style="height: 40px">
                </div>
              </div>
              <div class="form-group" style="padding: 30px 0 0 0">
                <div class="col-lg-8">
                  <textarea name="comments" rows = "7" cols = "50" placeholder="Message" title="Field cannot be empty" class="form-control" required></textarea>
                </div>
              </div>

              <div class="form-group" style="padding-bottom: 30px">
                <div class="col-lg-8" style="text-align: center; margin-top: 20px">
                  <button type="submit" name="submitted" value="Submit" class="btn btn-primary btn-lg" style="background-color: #FF9933; border-color: #FF9933 !important;">Submit</button>
                </div>
              </div>
            </form>
      </div>