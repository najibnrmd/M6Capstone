<?php
$pagetitle = "ABC | Contact Us";
use classes\business\UserManager;
use classes\business\Validation;

require_once 'includes/autoload.php';

include 'includes/header.php';
?>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="bootstrap/css/design.css">

	<div class="container">

		<div class="row">
			<div class="col-lg-5 col-lg-offset-1" style="margin-top: 90px; margin-bottom: 80px;">

				  <div style="text-align: center;">
				    <div style="padding-bottom: 20px">
					    <i class="fa fa-map-marker" style="font-size: 36px; color: #FF9933; padding-bottom: 10px"></i>
					    <p style="font-size: 18px">11 Eunos Road 8,<br>#08-01 Lifelong Learning Institute,<br>Singapore 535022</p>
				    </div>

				    <div style="padding-bottom: 20px">
					    <i class="fa fa-envelope" style="font-size: 36px; color: #FF9933; padding-bottom: 10px"></i>
					    <p style="font-size: 18px">info-devcom@abc.com</p>
				    </div>

				    <div style="padding-bottom: 20px">
					    <i class="fa fa-phone" style="font-size: 36px; color: #FF9933; padding-bottom: 10px"></i>
					    <p style="font-size: 18px">+65 65432178</p>
				    </div>
				 </div>
			</div>
			<?php include './feedback.php';?>

		</div>
		<div class="row">
			<div class="col-lg-12" style="margin-bottom: 80px; text-align: center;">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.7600334737967!2d103.88985331447665!3d1.3196913620398996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da19149fe4a925%3A0x82606eb494fd093c!2sLithan+Academy!5e0!3m2!1sen!2ssg!4v1514739525393" width="800" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
			</div>
		</div>
	</div>


<?php
include 'includes/footer.php';
?>