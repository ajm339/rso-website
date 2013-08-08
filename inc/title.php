<div id='headerSHRINK'>
<!--Add logo in later-->
	<a href="index.php"><img src="images/LOGONEW2.png" alt="Information Science Student Association"/></a>

<!--If the user isn't logged in, let them log in-->
<?php
  require('inc/database.php');

	if (isset($_GET["action"])) {
		if ($_GET["action"] == "logout") {
			if (isset($_SESSION["admin"])) {
				unset($_SESSION["admin"]);
				unset($_SESSION["username"]);
				unset($_SESSION["netid"]);
			}
			if (isset($_SESSION["student"])) {
				unset($_SESSION["student"]);
				unset($_SESSION["username"]);
				unset($_SESSION["netid"]);
			}
		} elseif ($_GET["action"] == "login") {

			//Make sure all fields are set
			if(isset($_POST["submit"]) && isset($_POST['username']) && isset($_POST['realPassword'])){
				//sanitize inputs
				$username = mysqli_real_escape_string($mysqli,$_POST["username"]);
				$password = mysqli_real_escape_string($mysqli,$_POST["realPassword"]);


				//Check login information
				$logincheck = $mysqli->query("SELECT * FROM Students WHERE username='$username' AND hashpassword='".hash("sha256",$password)."'");


			  if($logincheck->num_rows == 1) {
			//Process login information
			    $array = $logincheck->fetch_assoc();
			    if ($array["activation"] == null || $array["forgotPassword"] == 1) {
				if ($array["isbanned"] == 0) {
				  if ($array["isAdmin"] == 1) {
				    $_SESSION["admin"]=$array["studentnetID"];
				    $_SESSION["username"] = $array["username"];
				    $_SESSION["netid"] = $array["studentnetID"];
				    //print("Congrats admin $array[username]! You logged in!");
				  } else {
				    $_SESSION["student"] = $array["studentnetID"];
				    $_SESSION["username"] = $array["username"];
				    $_SESSION["netid"] = $array["studentnetID"];
				  }
				} else {
				  $banned = "<div class=\"\"><div class=\"error\">You are banned. Contact administrator.</div></div>";
				}
			    } else {
				if ($array["forgotPassword"] == 0) {
					$notactivated = "<div class=\"\"><div class=\"error\">You must activate your account before logging in.</div></div>";
				}
			    }
			  } else {
				$incorrect = "<div class=\"\"><div class=\"error\">Incorrect username/password combination.</div></div>";
			  }
			}
		}
	}

	//user must be either an admin or a student, otherwise, provide them with a log in option
	if(!isset($_SESSION['admin']) && !isset($_SESSION['student'])){

?>
<div id = "formCONTAINER">
	<form action="?action=login" method="post">
		<p class="clear"><span class="white">Login to view extra content!</span>
			<input type="text" id="username" name="username" placeholder="Username" />
			<input type="password" id="realPassword" name="realPassword" placeholder="Password"/>
			<input type="submit" name="submit" value="Log In" />
		</p>
	</form>
	<a id="forgot" href="login.php?forgot=true">Forgot your login info? Click here.</a>

<?php
	//Print the Error Message
	if(isset($banned)){
		print($banned);
	}
	else if(isset($incorrect)){
		print($incorrect);
	}
	else if(isset($notactivated)){
		print($notactivated);
	}
?>
</div>
<?php
	} else {
		if (isset($_SESSION["admin"])) { //welcome the admin, provide logout
			$query = $mysqli->query("SELECT * FROM Students WHERE studentnetID='$_SESSION[admin]'");
			$array = $query->fetch_assoc();
			print("<p class=\"clear\"><span class=\"white right\">Welcome, $array[username]! <a class = \"loginBAR\" href=\"?action=logout\">Click here to logout</a></span></p>");
		} else { //welcome the student, provide logout
			$query = $mysqli->query("SELECT * FROM Students WHERE studentnetID='$_SESSION[student]'");
			$array = $query->fetch_assoc();
			print("<p class=\"clear\"><span class=\"white right\">Welcome, $array[username]! <a class = \"loginBAR\" href=\"?action=logout\">Click here to logout</a></span></p>");
		}
	}
	$mysqli->close();

?>

</div>