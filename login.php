<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Log In</title>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Quicksand:700" />
    <!--<link rel="stylesheet" type="text/css" href="styles/styles.css" />-->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script type="text/javascript" src="scripts/scripts.js"></script>
    <script type="text/javascript" src="scripts/navigation.js" ></script>
    <script type="text/javascript" src="scripts/jquery-bp.js" ></script>


    <link rel="stylesheet" href="css/main.css" type="text/css" />
	<link rel="stylesheet" href="css/borderTEALlogin.css" type="text/css" />

  <script type="text/javascript" src="js/jquery.js" ></script>
  <script type="text/javascript" src="js/jquery-bp.js" ></script>
  <script type="text/javascript" src="js/navigation.js" ></script>
  </head>
  <body>
    <div id='header'>

      <!--Title Page with login form and logo-->
      <?php include("inc/title.php");?>

    </div>

      <div id='navigation' class='container'>
		<div id='positionNAV'>
           <div id='index' class='pri-nav'><div><a href='index.php'>Index</a></div></div>
           <div id='about' class='pri-nav'><div><a href='about.php'>About Us</a></div></div>
           <div id='employers' class='pri-nav'><div><a href='employers.php'>Employers</a></div></div>
           <div id='login' class='pri-nav active'><div><a href='login.php'>Log In</a></div></div>
<?php
	if(isset($_SESSION['student'])){echo ("<div id='rate' class='pri-nav'><div><a href=\"rate.php\">Rate</a></div></div>
				   <div id='discuss' class='pri-nav'><div><a href=\"discuss.php\">Discuss</a></div></div>");}

	if(isset($_SESSION['admin'])){echo ("<div id='rate' class='pri-nav'><div><a href=\"rate.php\">Rate</a></div></div>
				   <div id='discuss' class='pri-nav'><div><a href=\"discuss.php\">Discuss</a></div></div>
				   <div id='admin' class='pri-nav'><div><a href=\"admin.php\">Admin</a></div></div>");}

	?>
		</div>
      </div>

  	<div id='wrapper'>

      <!--If students aren't registered for an account, they can register here.-->
      <h1>Account Registration</h1>


	<!--Process login input from the navigation bar here.-->
	<?php
require('inc/database.php');

	////Make sure all fields are set
	//if(isset($_POST["submit"]) && isset($_POST['username']) && isset($_POST['realPassword'])){
	//  //Sanitize inputs
	//  $username = htmlentities(mysqli_real_escape_string($mysqli,$_POST["username"]));
	//  $password = htmlentities(mysqli_real_escape_string($mysqli,$_POST["realPassword"]));
	//
	//
	//  //Check login information
	//  $logincheck = $mysqli->query("SELECT * FROM Students WHERE username='$username' AND hashpassword='".hash("sha256",$password)."'");
	//
	//  if($logincheck->num_rows == 1) {
	//    //Process login information
	//    $array = $logincheck->fetch_assoc();
	//    if ($array["activation"] == null) {
	//      if ($array["isbanned"] == 0) {
	//	if ($array["isAdmin"] == 1) {
	//	  $_SESSION["admin"]=$array["studentnetID"];
	//	  print("You have successfully logged in.");
	//	} else {
	//	  $_SESSION["student"] = $array["studentnetID"];
	//	  print("You have successfully logged in.");
	//	}
	//      } else {
	//	print("You cannot login to the site because you have been banned. Please contact a system administrator if this seems incorrect.");
	//      }
	//    } else {
	//      print("Please activate your account. Contact a system administrator for assistance.");
	//    }
	//  }
	//}
      ?>
      <?php if (!isset($_SESSION["student"]) && !isset($_SESSION["admin"]) && !isset($_GET["forgot"])) { ?> <!-- If person is not logged in, show registration form-->
	<h2>Please input the following information into the form to make your account. You will be sent an email to your Cornell email address to activate your account.</h2>
	<form action="login.php" method="post">
	    <p>
	      netID: <input pattern="[A-Za-z]{2,3}[0-9]{1,4}" type="text" id="netid" name="netid" placeholder="NetID" /><br>
	      Username: <input type="text" id="userReg" name="userReg" placeholder="Username" /><br>
	      <!--<input type="text" id="userFakePass" name="userFakePass" value="Password" />-->
	      Password: <input type="password" id="userRealPass" name="userRealPass" placeholder="Password"/> <br>
	      <input type="submit" id="registersubmit" name="registersubmit" value="Register!" />
	    </p>
	</form>

      <?php } elseif (!isset($_GET["forgot"])){
	print("You are already logged in. Please logout to register another user.");
      } elseif (isset($_GET["forgot"]) && $_GET["forgot"] == "true") {
	?>
	<form action="login.php" method="post">
	    <p>
	      Using your netID, we will send an email to your Cornell account with your username and a form to change your password.
	    </p>
	    <p>
	      Enter your netID: <input type="text" pattern="[A-Za-z]{2,3}[0-9]{1,4}" id="netid" name="netid" placeholder="NetID" />
	      <input type="submit" id="forgotsubmit" name="forgotsubmit" value="Send email!" />
	    </p>
	</form>


	<?php

      }
      if (isset($_POST["forgotsubmit"])) {
	  $netid = htmlentities(mysqli_real_escape_string($mysqli,$_POST["netid"]));
	  $results = $mysqli->query("SELECT * FROM Students WHERE studentnetID=\"$netid\"");
	  if ($results->num_rows >0) { //if the user actually exists in the database...
	    $array = $results->fetch_assoc();
	    $username = $array["username"];

	    $activatekey = hash("sha256",$netid);
	    $mysqli->query("UPDATE Students SET activation=\"$activatekey\" WHERE studentnetID=\"$netid\""); //create hashed activation key for security
	    $mysqli->query("UPDATE Students SET forgotPassword=\"1\" WHERE studentnetID=\"$netid\""); //set forgotPassword boolean to true

	    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	    $link = $actual_link."?forgot=change&netid=".$netid."&key=".$activatekey;
	    $message = "Your username is: $username.\n\n To reset your password, please click on the following link:\n\n".$link."";
	    mail($netid."@cornell.edu","ISSA Account Retrieval",$message);
	    print("<br>An activation email has been sent to your Cornell email address. Click the link provided to get your username and reset your password.");
	  } else {
	    print("<br>You are not currently in the system. Please register to make your account first.");
	  }
	}
      ?>

     <!--Process the registration input here.-->
      <?php

      if (isset($_POST["registersubmit"])) {
      //Make sure all fields are set
	$formvalid = true;

	//Make sure the netid is in a valid format
	if (!isset($_POST["netid"]) || empty($_POST["netid"]) || !(preg_match("/^[a-z]{2,3}[0-9]{1,4}$/", $_POST["netid"]))) {
	    print("<p>Fix your NetID!</p>");
	    $formvalid = false;
	}
	if (!isset($_POST["userReg"]) || empty($_POST["userReg"]) || !(preg_match("/^[a-z A-Z 0-9]+$/", $_POST["userReg"]))) {
	    print("<p>Fix your username!</p>");
	    $formvalid = false;
	}
	if (!isset($_POST["userRealPass"]) || empty($_POST["userRealPass"]) || !(preg_match("/^[a-z A-Z 0-9]+$/", $_POST["userRealPass"]))) {
	    print("<p>Fix your password!</p>");
	    $formvalid = false;
	}

	//Sanitize inputs
	if ($formvalid) {
	  $netid = htmlentities(mysqli_real_escape_string($mysqli,$_POST["netid"]));
	  $username = htmlentities(mysqli_real_escape_string($mysqli,$_POST["userReg"]));
	  $password = htmlentities(mysqli_real_escape_string($mysqli,$_POST["userRealPass"]));
	  $hashpassword = hash("sha256",$password);
	  $activation = hash("sha256",$netid);

	  $unique=true;
	  // check if username exists already
	  $netidcheck = $mysqli->query("SELECT * FROM Students WHERE studentnetID='$netid'");
	  if (mysqli_num_rows($netidcheck) != 0) {
	    print("The NetID you input is already registered.\n");
	    $unique=false;
	  }
	  $usernamecheck = $mysqli->query("SELECT * FROM Students WHERE username='$username'");
	  if (mysqli_num_rows($usernamecheck) != 0) {
	    print("The username you input is already registered.\n");
	    $unique=false;
	  }
	  // if user selected a unique username and NetID
	  if ($unique) {
	    $addtoDB = $mysqli->query("INSERT INTO Students(studentnetID,username,hashpassword,activation) VALUES('$netid','$username','$hashpassword','$activation')");
	    if (!$addtoDB) {
	      print("An error occurred when adding the user to the database.");
	    } else {  //Send a registration email
	      $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	      $link = $actual_link."?netid=".$netid."&key=".$activation;
	      $message = "To activate your account, please click on the following link:\n\n".$link."";
	      mail($netid."@cornell.edu","ISSA Registration Confirmation",$message);
	      print("<br>An activation email has been sent to your Cornell email address. Click the link provided to activate your account.");
	    }
	  }
	}


      }
      if (!isset($_GET["forgot"])) {
	//If they prove that they received the registration email
	if (isset($_GET['netid']) && preg_match('/[a-z]{2,3}[0-9]{1,4}$/', $_GET['netid'])) {
	  $activatenetid = htmlentities(mysqli_real_escape_string($mysqli,$_GET['netid']));
	}
	if (isset($_GET['key']) && (strlen($_GET['key']) == 64)){
	  $activatekey = htmlentities(mysqli_real_escape_string($mysqli,$_GET['key']));
	}

	//Verify them in the database and grant them student or admin access as necessary
	if (isset($activatenetid) && isset($activatekey)) {
	  $mysqli->query("UPDATE Students SET activation=NULL WHERE studentnetID='$activatenetid' AND activation='$activatekey'");
	  if (mysqli_affected_rows($mysqli) == 1) {
	    print("The activation was successful! You may now log in.");
	  } else {
	    print("The activation failed. Please contact a system administrator.");
	  }
	}
      }

      // if they forgot their password....
      if (isset($_GET["forgot"]) && $_GET["forgot"] == "change") {
	if (isset($_POST["changesubmit"])) {
	  $formvalid = true;
	  if (!isset($_POST["passwordone"]) || empty($_POST["passwordone"]) || !(preg_match("/^[a-z A-Z 0-9]+$/", $_POST["passwordone"]))) {
	      print("<p>Fix your password!</p>");
	      $formvalid = false;
	  }
	  if ($_POST["passwordone"] != $_POST["passwordtwo"]) {
	    print("<p>Your passwords did not match.</p>");
	    $formvalid = false;
	  }

	  if (!($formvalid)) {
	    ?>
	      Use this form to change your password!
	      <form action="<?php echo $_SERVER["REQUEST_URI"];?>" method="post">
		New Password: <input type="password" name="passwordone">
		Confirm Password: <input type="password" name="passwordtwo">
		<input type="submit" name="changesubmit" value="Update password!">
	      </form>
	      <?php

	  } else {
	    $changenetid = htmlentities(mysqli_real_escape_string($mysqli,$_GET['netid']));
	    $changekey = htmlentities(mysqli_real_escape_string($mysqli,$_GET['key']));
	    $escapedpassword = htmlentities(mysqli_real_escape_string($mysqli, $_POST["passwordone"]));
	    $newhashpassword = hash("sha256", $escapedpassword);
	    $mysqli->query("UPDATE Students SET forgotPassword='0', activation=NULL, hashpassword='$newhashpassword' WHERE studentnetID='$changenetid' AND activation='$changekey'");
	    if (mysqli_affected_rows($mysqli) == 1) {
	      print("Successfully changed your password! You may now log in.");
	    } else {
	      print("Changing your password failed. Please contact a system administrator.");
	    }
	  }
	}

	if(!isset($formvalid)) {
	  if (isset($_GET["netid"]) && preg_match('/[a-z]{2,3}[0-9]{1,4}$/', $_GET['netid']) && isset($_GET["key"]) && (strlen($_GET['key']) == 64)) {
	    $changenetid = htmlentities(mysqli_real_escape_string($mysqli,$_GET['netid']));
	    $changekey = htmlentities(mysqli_real_escape_string($mysqli,$_GET['key']));
	    //check if user actually submitted a request to change their password
	    $results = $mysqli->query("SELECT * FROM Students WHERE  studentnetID='$changenetid' AND activation='$changekey' AND forgotPassword='1'");
	    if ($results->num_rows == 1) {
	      ?>
	      Use this form to change your password!
	      <form action="<?php echo $_SERVER["REQUEST_URI"];?>" method="post">
		New Password: <input type="password" name="passwordone">
		Confirm Password: <input type="password" name="passwordtwo">
		<input type="submit" name="changesubmit" value="Update password!">
	      </form>
	      <?php
	    }
	  } else {
	    print("The link to change your password is not valid.");
	  }
	}

      }




    $mysqli->close();
      ?>

    </div>


  </body>
</html>