<head>
<link href="/menu_assets/styles.css" rel="stylesheet" type="text/css">
</head>

<!--If successfully logged in as a student, they will see a tab for discussion and ratings!-->
<?php 

	if(isset($_SESSION['student']) && $_SESSION['student']==true){

?>

<div class ='navigation'>
	<ul>
		<li id="first"><a href="index.php">Home</a></li>
		<li id="second"><a href="about.php">About Us</a></li>
		<li id="third"><a href="employers.php">Employers</a></li>
		<li id="fourth"><a href="ratings.php">Ratings</a></li>
		<li id="fifth"><a href="discussion.php">Discussion</a></li>
	</ul>
</div>

<!--If successfully logged in as an admin, they will see an additional admin panel tab!-->
<?php

	}elseif(isset($_SESSION['admin']) && $_SESSION['admin']==true){ 

?>

<div class ='navigation'>
	<ul id='nav'>
		<li><a href="index.php">Home</a></li>
		<li><a href="about.php">About Us</a></li>
		<li><a href="employers.php">Employers</a></li>
		<li><a href="ratings.php">Ratings</a></li>
		<li><a href="discussion.php">Discussion</a></li>
		<li><a href="admin.php">Admin</a></li>
	</ul>
</div>

<!--Otherwise, there will only be the three tabs...-->
<?php

	}else{

?>

<div id='cssmenu'>
<ul>
   <li class='active'><a href='index.php'><span>Home</span></a></li>
   <li><a href='about.php'><span>About Us</span></a></li>
   <li><a href='employers.php'><span>Employers</span></a></li>
   <li><a href='login.php'><span>Log In</span></a></li>
   <li><a href="ratings.php">Ratings</a></li>
   <li><a href="discussion.php">Discussion</a></li>
   <li><a href="admin.php">Admin</a></li>
</ul>
</div>

<?php
	
	}

?>