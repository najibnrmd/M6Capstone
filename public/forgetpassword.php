<?php
$pagetitle = "ABC | Forget Password";
use classes\business\UserManager;
use classes\business\Validation;

require_once 'includes/autoload.php';
require_once "includes/phpmailer/PHPMailerAutoload.php";
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
    $email=$_POST["email"];
	$UM=new UserManager();
	$existuser=$UM->getUserByEmail($email);
	if(isset($existuser)){
			$name=$existuser->firstName;
			//generate new password
			$newpassword=$UM->randomPassword(8,1,"lower_case,upper_case,numbers");
			//hash the new password
			$hashedpwd = password_hash($newpassword[0], PASSWORD_DEFAULT);
			//update database with new password
			$UM->updatePassword($email,$hashedpwd);  
			//$formerror="Valid email user. password: ".$newpassword[0];
			//coding for sending email
			// do work here
			$mail = new PHPMailer;
			//Enable SMTP debugging.
			//$mail->SMTPDebug = 3;
			//Set PHPMailer to use SMTP.
			$mail->isSMTP();
			//Set SMTP host name
			$mail->Host = "in-v3.mailjet.com";
			//Set this to true if SMTP host requires authentication
			$mail->SMTPAuth = true;
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
			$mail->addAddress($email, $name);
			$mail->isHTML(true);
			$mail->Subject = "Password Recovery";
			$mail->Body = "Dear ". $name. ",<br>Here is your new password: ".$newpassword[0];
			$mail->AltBody = "This is the plain text version of the email content";
			if(!$mail->send())
			{
			    echo "Mailer Error: " . $mail->ErrorInfo;
			}
			else
			{
			    echo "Message has been sent successfully";
			}
			//header("Location:home.php");
	}else{
			$formerror="Invalid email user";
	}
}

?>
<html>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="bootstrap/css/design.css">

	<div class="container">

		<div class="row">
			<div class="col-lg-12" style="text-align: center; padding-top: 30px;">
				<h2 style="font-size: 36px"><b>ABC Developer Community</b></h2>
			</div>	
		</div>

		<div class="row">
			<div class="col-lg-8 col-lg-offset-2" style="background-color: #F2F2F2; border: 1px solid #ccc; margin-top: 40px; margin-bottom: 60px; padding: 10px 60px">
				<div class="row" style="border-bottom: 1px solid #ccc; padding-top: 30px">
					<div class="col-lg-12">
						<p style="font-weight: 700; font-size: 20px;">Forgot Password</p>
					</div>
				</div>

				<form class="form-horizontal" method="post">
					<div class="form-group" style="padding: 20px 0 0 0">
						<div class="col-lg-12">
							<input type="email" name="email" value="<?=$email?>" pattern=".{1,}" title="Cannot be empty field" placeholder="e.g example@domain.com" class="form-control" required style="border: 2px solid #ccc; height: 40px">
						</div>
					</div>

					<div style="padding-top: 20px">
						<p>To reset password please enter your Enter Email Address then click Submit to proceed.</p>
					</div>

					<div class="form-group" style="padding-bottom: 10px">
						<div class="col-lg-6" style="font-size: 18px; text-align: left; margin-top: 30px">
							<a href="#" onClick="history.go(-1)" style="color: #333"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>
						</div>
						<div class="col-lg-6" style="text-align: right; margin-top: 20px">
							<button type="submit" name="submitted" value="Submit" class="btn btn-warning btn-lg">Submit <span class="glyphicon glyphicon-chevron-right"></span></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div></br></br></br></br></br></br></br></br>

<?php
include 'includes/footer.php';
?>