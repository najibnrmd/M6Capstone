<?php
$pagetitle = "ABC | Register";
require_once '../../includes/autoload.php';
require_once "../../includes/phpmailer/PHPMailerAutoload.php";
include '../../includes/header.php';
include '../../includes/password.php';
use classes\util\DBUtil;
use classes\business\UserManager;
use classes\business\SubscribeManager;
use classes\entity\User;

$formerror="";

$firstName="";
$lastName="";
$email="";
$password="";
$country="";

if(isset($_REQUEST["submitted"])){
    $firstName=$_REQUEST["firstName"];
    $lastName=$_REQUEST["lastName"];
    $email=$_REQUEST["email"];
    $country=$_REQUEST['country'];
    $password=$_REQUEST["password"];
    $password=password_hash($password, PASSWORD_DEFAULT);
    
    if($firstName!='' && $email!='' && $country!='' && $password!=''){
        $UM=new UserManager();
        $user=new User();
        $user->firstName=$firstName;
        $user->lastName=$lastName;
        $user->email=$email;
        $user->password=$password;
        $user->country=$country;
        $user->role="user";
        $existuser=$UM->getUserByEmail($email);
    
        if(!isset($existuser)){
            // Save the Data to Database
            $UM->saveUser($user);
            if (isset($_POST['subscription'])){
              $UM=new UserManager();
              $existuser=$UM->getUserByEmail($email);
              $id=$existuser->id;
              $SM=new SubscribeManager();
              $SM->subscribe($id, $email);

              //PHPMailer
              
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
              
              $hashkey = $SM -> getUserByEmail($email) -> hashkey;
              //$id = $SM -> getUserByEmail($email) -> id;
              $firstname = $existuser -> firstName;
              $lastname = $existuser -> lastName;
              $link = "localhost/capstone/public/modules/user/unsubscribe.php";
              $mail->addBCC($email);
              $mail->isHTML(true);
              $mail->Subject = "ABC DevOps Mailing List";
              $mail->Body = "<p>Dear ".$firstname." ".$lastname.",</p><p>You are now subscribed to our mailing list! Thank You!</p><p>Click on the link below if you want to unsubscribe from our mailing list.</p><p><a href = {$link}?id={$id}&hashkey={$hashkey}>Unsubscribe</a></p>";
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
            #header("Location:registerthankyou.php");
			      echo '<meta http-equiv="Refresh" content="1; url=./registerthankyou.php">';
        }
        else{
            $formerror="User Already Exist";
        }
    }else{
        $formerror="Please fill in the fields";
    }
}
?>
<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../../bootstrap/css/design.css">
  <div class="container">

    <div class="row">
      <div class="col-lg-12" style="text-align: center; padding-top: 30px;">
        <h2 style="font-size: 36px"><b>ABC Developer Community</b></h2>
      </div>  
    </div>

    <div class="row">
      <div class="col-lg-8 col-lg-offset-2">
        <div class="row" style="border-bottom: 1px solid #ccc; padding-top: 30px">
          <div class="col-lg-9">
            <p style="font-weight: 700; font-size: 20px">Registration</p>
          </div>
          <div class="col-lg-3">
            <a href="../../login.php" style="color: #169BD5; font-size: 16px;"><p style="text-align: right">Already a Member?</p></a>
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
            <a href="#" data-toggle="tooltip" data-placement="left" title="Optional. Alternatively, you can use your surname or father's name as your last name."><label class="control-label col-lg-3" style="text-align: left; font-size: 18px; color: #000">Last Name: <span class="glyphicon glyphicon-question-sign"></span></label></a>
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
                <label><input type="checkbox" name="subscription" value="Subscribe"><b>Subscribe to our mailing list</label>
              </div>
            </div>
          </div>

          <div class="form-group">
            <p style="text-align: center; padding: 20px 0;">By clicking Register, you agree to the ABC User Agreement and Privacy Policy</p>
          </div>

          <div class="form-group" style="text-align: right; padding-bottom: 30px">
            <button type="reset" name="reset" value="Reset" class="btn btn-default btn-lg" style="margin-right: 20px">Clear</button>
            <button type="submit" name="submitted" value="Submit" class="btn btn-warning btn-lg">Register</button>
            
          </div>
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="../../bootstrap/js/bootstrap.min.js"></script>

  <script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
  </script>


<?php
include '../../includes/footer.php';
?>