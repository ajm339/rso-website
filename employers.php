<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Employers</title>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Quicksand:700" />
    <!--<link rel="stylesheet" type="text/css" href="styles/styles.css" />-->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript" src="scripts/scripts.js"></script>
<script type="text/javascript" src="scripts/navigation.js" ></script>
<script type="text/javascript" src="scripts/jquery-bp.js" ></script>


<link rel="stylesheet" href="css/main.css" type="text/css" />
  <link rel="stylesheet" href="css/borderGREENemployers.css" type="text/css" />

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
  <div id='employers' class='pri-nav active'><div><a href='employers.php'>Employers</a></div></div>
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
    <h1>For Employers</h1>
    <div class="padding">
    <h2>Corporate Recruiting</h2>
    <p> The ISSA is a leading organization on campus for Information Science and Information Science Systems &amp; Technology graduate and undergraduate students. Our students have both broad training and specializations in areas such as Information Systems, Human-Computer Interaction, and Social Studies of Computing.
    <br /><br />
    The ISSA host employer events throughout the academic year.
    </p>
    <ul>
    <li>We take care of <b>organizing and advertising your event</b> to our large student base</li>
    <li>We're open to hosting information sessions, tech talks, portfolio critiques, informal lunches, or any other type of event you'd like us to organize.</li>
    <li>All types of events can be requested via the <a href="http://www.engineering.cornell.edu/resources/career_services/employers/recruiting/issa-info-session-request-form.cfm">Info Session Request Form</a>.</li>
    <li>If you have any questions, please contact one of our Corporate Chairs, Josh Freeberg (<a href="mailto:jaf287@cornell.edu">jaf287</a>) and Matt Baron (<a href="mailto:mlb338@cornell.edu">mlb338</a>), or contact us at <a href="mailto:issa@cornell.edu">issa@cornell.edu</a> with any questions.</li>
    </ul>
    </div>
    <div class="padding">
    <h2>Resume Book</h2>
    <p> Each year, the ISSA sends out all members' resumes to our industry contacts. If you are in industry and would like to receive our resume book each year, please email <a href="mailto:issa@cornell.edu">issa@cornell.edu</a>
    </p>
    <ul>
    <li>Your name</li>
    <li>Email address</li>
    <li>Company</li>
    <li>Position</li>
    </ul>
    </div>
    </div>



    </body>
    </html>
