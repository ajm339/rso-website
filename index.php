<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Index</title>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Quicksand:700" />
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <link rel="stylesheet" href="css/main.css" type="text/css" />
    <script type="text/javascript" src="js/jquery.js" ></script>
    <script type="text/javascript" src="js/jquery-bp.js" ></script>
    <script type="text/javascript" src="js/navigation.js" ></script>
  </head>
  <body>
    <? require('inc/header.php'); ?>

    <div class='wrapper home'>
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
      <?php require("inc/leadership.php") ?>
    </div>
    <div class="padding">
    <h2>Listserv</h2>
    <p>Register for our listserv to learn about ISSA meetings, job opportunities, and more. In order to register, send "issa-l-request@cornell.edu" an email with the subject "join".</p>
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
