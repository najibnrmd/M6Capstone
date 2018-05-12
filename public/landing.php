<?php
$pagetitle = "ABC | Landing";
use classes\business\UserManager;
use classes\business\Validation;

require_once 'includes/autoload.php';
include 'includes/header.php';
?>

<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="bootstrap/css/design.css">

<div class="container">

	<div class="row" style="background-color: #F2F2F2;">
		<div class="col-lg-6" style="padding-left: 50px">
			<div class="row">
				<h1 style="font-weight: 700; font-size: 40px">JOIN OUR GROWING DEVELOPER COMMUNITY</h1>
				<p style="padding-top: 10px; font-size: 20px; line-height: 200%">Interact with fellow software developers from around the world.<br/>Answer questions and discuss solutions.<br/>Collaborate on projects.<br/>Job Opportunities.</p>
			</div>
			<div class="row">
					<a href="modules/user/register.php" class="btn btn-warning btn-lg" role="button" aria-pressed="true" style="margin-bottom: 20px;">Register</a>
					<a href="login.php" class="btn btn-default btn-lg" role="button" aria-pressed="true" style="margin-left: 20px; margin-bottom: 20px;">Log In</a>
			</div>
		</div>
		<div class="col-lg-6" style="padding-left: 100px">
			<img src="images/hero.png">
		</div>
	</div>


	<div class="row" style="background-color: #FFF;"></div>
		<div class="row" style="text-align: center; padding-top: 20px;">
			<h2 style="font-weight: 700; font-size: 36px">About Us</h2>
		</div>
		<div class="row" style="font-size: 20px">
			<div class="col-lg-4" style="padding: 30px 20px">
				<p>Founded in 2017, ABC DevCom Portal is the largest, most trusted online community for developers to learn, share their knowledge, and build their careers. More than 50 million professional and aspiring programmers visit ABC DevCom Portal each month to help solve coding problems, develop new skills, and find job opportunities.</p>
			</div>
			<div class="col-lg-4" style="padding: 30px 20px">
				<p>ABC DevCom partners with businesses to help them understand, hire, engage, and enable the world's developers. Our products and services are focused on developer marketing, technical recruiting, market research, and enterprise knowledge sharing..</p>
			</div>
			<div class="col-lg-4" style="padding: 30px 20px">
				<p>ABC DevCom currently employs more than 250 people in its head offices in New York, Denver, and London as well as remote workers from Israel, Brazil, Japan, Germany, Slovenia, Spain, Poland, France, Russia, the Philippines, Canada, the UK, and the United States. The company is committed to diversity in the workplace and is currently hiring.</p>
			</div>
		</div>

</div>

<?php
include 'includes/footer.php';
?>