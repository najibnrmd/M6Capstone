<!-- Navigation Bar -->
<?php 

   if(isset($_SESSION["role"]))
   {
    if ($_SESSION["role"] == "admin"){
?>
<head><title><?=$pagetitle;?></title></head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <nav class="navbar navbar-inverse" style="height: 100px; background-color: #333">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                        
        </button>
        <a class="navbar-brand" href="/capstone/public/home.php"><img src="http://localhost/capstone/public/images/abc.png" class="logo"></a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li class="top-nav"><a href="/capstone/public/home.php" class="btn btn-link" role="button"> Home</a></li>
          <li class="top-nav"><a href="/capstone/public/modules/user/updateprofile.php" class="btn btn-link" role="button"> Update Profile</a></li>
          <li class="top-nav"><a href="/capstone/public/modules/user/userlistadmin.php" class="btn btn-link" role="button">Administer Users</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="top-nav"><a href="/capstone/public/logout.php" class="btn btn-link" role="button"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
        </ul>
      </div>
    </div>
  </nav>
<?php 
   } else
   {
?>
<head><title><?=$pagetitle;?></title></head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <nav class="navbar navbar-inverse" style="height: 100px; background-color: #333">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                        
        </button>
        <a class="navbar-brand" href="/capstone/public/home.php"><img src="http://localhost/capstone/public/images/abc.png" class="logo"></a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li class="top-nav"><a href="/capstone/public/home.php" class="btn btn-link" role="button"> Home</a></li>
          <li class="top-nav"><a href="/capstone/public/modules/user/updateprofile.php" class="btn btn-link" role="button"> Update Profile</a></li>
          <li class="top-nav"><a href="/capstone/public/modules/user/userlist.php" class="btn btn-link" role="button">View Users</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="top-nav"><a href="/capstone/public/logout.php" class="btn btn-link" role="button"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
        </ul>
      </div>
    </div>
  </nav>
<?php
    }
  } else
  {
?>
<head><title><?=$pagetitle;?></title></head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <nav class="navbar navbar-inverse" style="height: 100px; background-color: #333">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                        
        </button>
        <a class="navbar-brand" href="/capstone/public/landing.php"><img src="http://localhost/capstone/public/images/abc.png" class="logo"></a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
          <li class="top-nav"><a href="/capstone/public/modules/user/register.php" class="btn btn-link" role="button"><span class="glyphicon glyphicon-user"></span> Register</a></li>
          <li class="top-nav"><a href="/capstone/public/login.php" class="btn btn-link" role="button"><span class="glyphicon glyphicon-log-in"></span> Log In</a></li>
        </ul>
      </div>
    </div>
  </nav>
<?php 
   } 
?>