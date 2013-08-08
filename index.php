<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Index</title>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Quicksand:700" />
   <!-- <link rel="stylesheet" type="text/css" href="styles/styles.css" />-->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript" src="scripts/scripts.js"></script>
<script type="text/javascript" src="scripts/navigation.js" ></script>
<script type="text/javascript" src="scripts/jquery-bp.js" ></script>


<link rel="stylesheet" href="css/main.css" type="text/css" />
  <link rel="stylesheet" href="css/borderREDhome.css" type="text/css" />

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
  <div id='index' class='pri-nav active'><div><a href='index.php'>Index</a></div></div>
  <div id='about' class='pri-nav'><div><a href='about.php'>About Us</a></div></div>
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
    <h1>Who We Are</h1>
    <div class="padding">
    <h2>Membership</h2>
    <p> The Information Science Student Association is open to all students (majors, minors, or undeclared) interested in Information Science or Information Science, Systems, &amp; Technology.
    </p>
    </div>
    <div class="padding">
    <h2>Benefits - Why join the ISSA?</h2>
    <p> 
    <b>Academic</b>: The ISSA connects underclassmen with upperclassmen who can share a wealth of information about courses, structuring schedules, and choosing tracks.
    <br /><br />
    <b>Career</b>: The ISSA hosts information sessions with employers looking to fill full-time and internship positions. Additionally, ISSA sends out a resume book of members to recruiters at all the major tech companies.
    <br /><br />
    <b>Research &amp; Leadership</b>: The ISSA connects students with professors regarding research opportunities and notifies members about leadership opportunities and on-campus jobs suited for IS and ISST students.
    <br /><br />
    <b>Social</b>: Through the ISSA, you will meet and build relationships with your classmates in IS and ISST and keep up with the latest news in the Information Science department. The ISSA allows you to connect with others in your major and find group members, start-up partners, mentors/mentees, and friends.
    </p>
    </div>
    <div class="padding">
    <h2>Leadership</h2>
    <p> President: Parker Moore (<a href="mailto:pjm336@cornell.edu">pjm336</a>)
    <br />
    Vice President: Zach Porges (<a href="mailto:zip2@cornell.edu">zip2</a>)
    <br />
    Treasurer: Sam Tung (<a href="mailto:sat83@cornell.edu">sat83</a>)
    <br />
    Corporate Relations Co­Chairs: Josh Freeberg (<a href="mailto:jaf287@cornell.edu">jaf287</a>) and Matt Baron (<a href="mailto:mlb338@cornell.edu">mlb338</a>)
    <br />
    Social Chair: Susie Forbath (<a href="mailto:sf335@cornell.edu">sf335</a>)
    <br />
    Communications Chair: Brian O'Connor  (<a href="mailto:bjo29@cornell.edu">bjo29</a>)
    </p>
    </div>
    <div class="padding">
    <h2>Listserv</h2>
    <p> <a href="https://lists.cs.cornell.edu/mailman/listinfo/issa-l">Register for our listserv</a> to learn about ISSA meetings, job opportunities, and more.
    </p>
    </div>
    <div class="padding">
    <h2>Facebook</h2>
    <p> <a href="https://www.facebook.com/groups/220901021255819/">Join our Facebook Group</a> to communicate with other ISSA members and stay in the loop.
    </p>
    </div>
    <div class='padding'>
    <h2>Contact</h2>
    <p> <a href="mailto:issa@cornell.edu">issa@cornell.edu</a>
    </p>
    </div>
    </div>


    </body>
    </html>