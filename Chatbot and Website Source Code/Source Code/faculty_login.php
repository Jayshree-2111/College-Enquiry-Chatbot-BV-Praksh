<?php
require 'credentials.php';

session_start();

error_reporting(0);


if (isset($_POST["signup"])) {
  
  $bv_id = mysqli_real_escape_string($conn, $_POST["signup_bv_id"]);
  $bv_emailid = mysqli_real_escape_string($conn, $_POST["signup_bv_emailid"]);
  $pass = mysqli_real_escape_string($conn, ($_POST["signup_password"]));

  $check_email = mysqli_num_rows(mysqli_query($conn, "SELECT bv_emailid FROM faculty_register WHERE bv_emailid='$bv_emailid'"));

  if ($check_email > 0) {
    ?>
      <script>
        alert("<?php echo "User registration failed. " . $bv_emailid . " already exists in our database!"?>");
      </script>
      <?php 
  } else if(strlen($_POST["signup_bv_id"])==10){
    $sql = "INSERT INTO faculty_register (bv_id, bv_emailid, pass) VALUES ('$bv_id', '$bv_emailid', '$pass')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $_POST["signup_bv_id"] = "";
      $_POST["signup_bv_emailid"] = "";
      $_POST["signup_password"] = "";
      echo "<script>alert('User registration successful.');</script>";
    }else {
        ?>
        <script>
          alert("<?php echo "User registration failed. " . $bv_id . " already exists in our database!"?>");
        </script>
        <?php 
    }
  }else {
      ?>
      <script>
          alert("<?php echo "User registration failed. " . $bv_id . " is incorrect"?>");
      </script>
      <?php
    }
  }
  
if (isset($_POST["send"])) {
	
  $id = mysqli_real_escape_string($conn, $_POST["bv_id"]);
  $dob = mysqli_real_escape_string($conn, ($_POST["bv_dob"]));

  $all = mysqli_query($conn, "SELECT * FROM faculty_register WHERE bv_id='$id' AND pass='$dob'");
  $count = mysqli_num_rows($all);
  
  if($count > 0){
    $fetch = mysqli_fetch_assoc($all);
    $bvmail = $fetch["bv_emailid"];
    $_POST["bv_id"] = "";
    $_POST["bv_dob"] = "";
    echo "<script>alert('Verify your email to login!');</script>";
    
    $otp = rand(100000,999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['mail'] = $bvmail;
    require "PHPMailer/PHPMailerAutoload.php";
    $mail = new PHPMailer;
    
    $mail->isSMTP();
    $mail->Host='smtp.gmail.com';
    $mail->Port=587;
    $mail->SMTPAuth=true;
    $mail->SMTPSecure='tls';
    
    $mail->Username=EMAILID;
    $mail->Password=PASSWORD;
    
    $mail->setFrom(EMAILID, 'BvChatbot_Praksh');
    $mail->addAddress($bvmail,$id);
    
    $mail->isHTML(true);
    $mail->Subject="Your OTP verification code to login Praksh-Chatbot";
    $mail->Body="<p>Dear Faculty, </p><h3>Your OTP verification code is: $otp <br></h3>
    <br/>
    <p>Only after verification you will be able to access our chatbot - Praksh to ask your queries.</p>
    <br/><br/>
    <p style='color: red'>This is a system generated mail. So, please do not reply to this mail!</p>
    <p>With regards,</p>
    <p><b>PRAKSH-Chatbot</b></p>
    ";
    
    if(!$mail->send()){
      ?>
      <script>
        alert("<?php echo "Login details are incorrect. Please try again!"?>");
      </script>
      <?php
      }else{
      ?>
      <script>
        alert("<?php echo "OTP sent to " . $bvmail ?>");
        window.location.replace('fac_otp.php');
      </script>
      <?php
    }            
  }else{
    ?>
      <script>
        alert("<?php echo "Either you are not registered or login details are incorrect!"?>");
      </script>
    <?php
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="faculty_login.css" />
  <title>Faculty Log in & Register Form</title>
</head>

<body>
  <div class="top-bar">
    <div class="logo" style="margin-left:11px;">
      <img src="https://i.postimg.cc/8C7W965P/image.png" height=50 width=50>
    </div>
    <div class="top-left"><a href="BV_Homepage.html" style="text-decoration: none; color:white">Banasthali Vidyapith</a></div>
    <div class="top-right">
    </div>
  </div>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="" class="sign-in-form" method="post">
          <center> <img src="https://i.postimg.cc/RCXLgKKb/Chatbotlogo.png" height=200 width=200></center>
          <h2 class="title">Log In</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Faculty ID" name="bv_id" pattern="([A-Z]{1,5})?([0-9]{1,5})" minlength="10" title="Please enter correct Faculty ID in capital letters" value="<?php echo $_POST['bv_id']; ?>" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" onfocus="(this.type='date')" placeholder="Date of Birth" name="bv_dob" min="1900-01-01" max="2004-12-31" title="Please enter a valid Date Of Birth only" value="<?php echo $_POST['bv_dob']; ?>" required />
          </div>
          <input type="submit" name="send" value="Send OTP" class="btn solid" />
        </form>
        <form action="" class="sign-up-form" method="post" id="registration-form">
          <center> <img src="https://i.postimg.cc/RCXLgKKb/Chatbotlogo.png" height=200 width=200></center>
          <h2 class="title">Register</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Faculty ID" name="signup_bv_id" pattern="([A-Z]{1,5})?([0-9]{1,5})" minlength="10" title="Please enter correct Faculty ID in capital letters" value="<?php echo $_POST["signup_bv_id"]; ?>" required />
          </div>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Banasthali Email" name="signup_bv_emailid" pattern=".+@banasthali\.in" title="Please enter a valid Banasthali email id only" size="40" value="<?php echo $_POST["signup_bv_emailid"]; ?>" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" onfocus="(this.type='date')" placeholder="Date of Birth" name="signup_password" min="1900-01-01" max="2004-12-31" title="Please enter a valid Date Of Birth only" value="<?php echo $_POST["signup_password"]; ?>" required />
          </div>
          <input type="submit" name="signup" class="btn" value="Register" />
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>New at BV प्रKश?</h3>
          <p>Just register with your Banasthali ID and then login to get all your queries related to Banasthali Vidyapith cleared with प्रKश!!
          </p>
          <button class="btn transparent" id="sign-up-btn">
            Register
          </button>
        </div>
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>Already Registered with BV प्रKश?</h3>
          <p>
            Just Login with the Banasthali ID (& other credentials) and get all your queries related to Banasthali Vidyapith cleared with प्रKश!!
          </p>
          <button class="btn transparent" id="sign-in-btn">
            Log In
          </button>
        </div>
      </div>
    </div>
  </div>

  <script src="jsfile.js"></script>
</body>

</html>