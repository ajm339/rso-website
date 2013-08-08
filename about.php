<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>About</title>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Quicksand:700" />
    <!--<link rel="stylesheet" type="text/css" href="styles/styles.css" />-->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript" src="scripts/scripts.js"></script>
<script type="text/javascript" src="scripts/navigation.js" ></script>
<script type="text/javascript" src="scripts/jquery-bp.js" ></script>


<link rel="stylesheet" href="css/main.css" type="text/css" />
  <link rel="stylesheet" href="css/borderGOLDabout.css" type="text/css" />

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
  <div id='about' class='pri-nav active'><div><a href='about.php'>About Us</a></div></div>
  <div id='employers' class='pri-nav'><div><a href='employers.php'>Employers</a></div></div>
  <div id='login' class='pri-nav'><div><a href='login.php'>Log In</a></div></div>
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

    <h1>What We Do</h1>
    <div class="padding">
    <h2>Recent ISSA Events include:</h2>
    <ul>
    <li>Alumni Panel</li>
    <li>Corporate Recruitment Sessions</li>
    <li>Ice Cream Social</li>
    <li>Lunch at Taverna Banfi</li>
    <li>Picnic in the Engineering Quad</li>
    <li>Research Panel</li>
    <li>Resume Critique Session</li>
    </ul>
    </div>
    <div class="padding">
    <h2>Student Mentoring Program</h2>
    <p> ISSA provides a great opportunity for students to work together to help each other flourish through their college career.  In addition to being assigned to a faculty advisor, new students in ISSA can opt to be paired with a student mentor. Student mentors are paired with new students who similar interests so that each pair can enjoy a fun and caring relationship.  Student mentors can give advice on courses, study skills, and other relevant topics.  The Student Mentoring Program is just one feature of ISSA that makes it such a unique and special group at Cornell University.
    </p>
    </div>
    </div>



    </body>
    </html>
