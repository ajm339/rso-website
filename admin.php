<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Quicksand:700" />
    <!--<link rel="stylesheet" type="text/css" href="styles/styles.css" />-->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript" src="scripts/scripts.js"></script>
<script type="text/javascript" src="scripts/navigation.js" ></script>
<script type="text/javascript" src="scripts/jquery-bp.js" ></script>


<link rel="stylesheet" href="css/main.css" type="text/css" />
  <link rel="stylesheet" href="css/borderPINKadmin.css" type="text/css" />

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
  <div id='login' class='pri-nav'><div><a href='login.php'>Log In</a></div></div>
  <div id='rate' class='pri-nav'><div><a href="rate.php">Rate</a></div></div>
  <div id='discuss' class='pri-nav'><div><a href="discuss.php">Discuss</a></div></div>
  <div id='admin' class='pri-nav active'><div><a href="admin.php">Admin</a></div></div>
  </div>
  </div>

  <div id='wrapper'>
<?php
if(isset($_GET["task"])){
  print("<a id='back' href =6 'admin.php'>Back</a>");
}
?>
<h1 class ='CENTERED' >Administrator's Page</h1>

<?php
//Administrator Page

//connect to the database
require('inc/database.php');

//Check if user is logged in AND if he/she is an administrator. If yes....
if (isset($_SESSION["admin"])) {

  //show options to view all users, banned users, flagged posts
  if (!isset($_GET["task"])) {
    print("<div class='adminMAINbuttons'>");
    print("<a href=admin.php?task=allusers><button class = \"adminBUTTON\">Click here to view all users</button></a>");
    print("<a href=admin.php?task=bannedusers><button class = \"adminBUTTON\">Click here to view banned users</button></a>");
    print("<a href=admin.php?task=flagged><button class = \"adminBUTTON\">Click here to view flagged posts</button></a>");
    print("<a href=admin.php?task=flaggedreview><button class = \"adminBUTTON\">Click here to view flagged reviews</button></a>");
    print("<a href=admin.php?task=approve><button class = \"adminBUTTON\">Click here to view pending additions to Professors and Courses</button></a>");
    print("</div>");

    //if view all users
  } elseif ($_GET["task"] == "allusers") {
    if (isset($_GET["ban"])) {
      $mysqli->query("UPDATE Students SET isbanned=\"1\" WHERE studentnetID=\"$_GET[ban]\"");
    }
    if (isset($_GET["unban"])) {
      $mysqli->query("UPDATE Students SET isbanned=\"0\" WHERE studentnetID=\"$_GET[unban]\"");
    }

    // if admin wants to grant admin privileges, update database (users)
    if (isset($_GET["newadmin"])) {
      $mysqli->query("UPDATE Students SET isAdmin=\"1\" WHERE studentnetID=\"$_GET[newadmin]\"");
    }
    if (isset($_GET["removeadmin"])) {
      $mysqli->query("UPDATE Students SET isAdmin=\"0\" WHERE studentnetID=\"$_GET[removeadmin]\"");
    }


    // query to display all users in the database
    $results = $mysqli->query("SELECT * FROM Students ORDER BY studentnetID");
    print("<table>");
    print("<thead><th>netID</th><th>Username</th><th>Banned?</th><th>Admin</th></thead>");
    while ($array = $results->fetch_assoc()) {
      // if admin bans someone, update database (users)


      print("<tr><td>$array[studentnetID]</td><td>$array[username]</td>");
      if ($array["isbanned"] == 0) {
        print("<td><a href=\"admin.php?task=allusers&ban=$array[studentnetID]\">Click to ban</a></td>");
      } else {
        print("<td>Banned. <a href=\"admin.php?task=allusers&unban=$array[studentnetID]\">Click to unban</a></td>");
      }

      if ($array["isAdmin"] == 0) {
        print("<td><a href=\"admin.php?task=allusers&newadmin=$array[studentnetID]\">Grant admin privileges</a></td></tr>");
      } else {
        print("<td>Already admin. <a href=\"admin.php?task=allusers&removeadmin=$array[studentnetID]\">Remove admin status</a></td></tr>");
      }
    }
    print("</table>");

    //if view banned users
  } elseif ($_GET["task"] == "bannedusers") {

    if (isset($_GET["ban"])) {
      $mysqli->query("UPDATE Students SET isbanned=\"1\" WHERE studentnetID=\"$_GET[ban]\"");
    }
    if (isset($_GET["unban"])) {
      $mysqli->query("UPDATE Students SET isbanned=\"0\" WHERE studentnetID=\"$_GET[unban]\"");
    }

    // if admin wants to grant admin privileges, update database (users)
    if (isset($_GET["newadmin"])) {
      $mysqli->query("UPDATE Students SET isAdmin=\"1\" WHERE studentnetID=\"$_GET[newadmin]\"");
    }
    if (isset($_GET["removeadmin"])) {
      $mysqli->query("UPDATE Students SET isAdmin=\"0\" WHERE studentnetID=\"$_GET[newadmin]\"");
    }
    // query to display all users in the database
    $results = $mysqli->query("SELECT * FROM Students WHERE isbanned=\"1\"  ORDER BY studentnetID");
    print("<table>");
    print("<thead><th>netID</th><th>Username</th><th>Banned?</th><th>Admin</th></thead>");
    while ($array = $results->fetch_assoc()) {
      // if admin bans someone, update database (users)



      print("<tr><td>$array[studentnetID]</td><td>$array[username]</td>");
      if ($array["isbanned"] == 0) {
        print("<td><a href=\"admin.php?task=allusers&ban=$array[studentnetID]\">Click to ban</a></td>");
      } else {
        print("<td>Banned. <a href=\"admin.php?task=bannedusers&unban=$array[studentnetID]\">Click to unban</a></td>");
      }

      if ($array["isAdmin"] == 0) {
        print("<td><a href=\"admin.php?task=allusers&newadmin=$array[studentnetID]\">Grant admin privileges</a></td></tr>");
      } else {
        print("<td>Already admin. <a href=\"admin.php?task=bannedusers&removeadmin=$array[studentnetID]\">Remove admin status</a></td></tr>");
      }
    }
    print("</table>");

    //if view flagged post
  } elseif ($_GET["task"] == "flagged") {

    if (isset($_GET["ban"])) {
      $mysqli->query("UPDATE Students SET isbanned=\"1\" WHERE studentnetID=\"$_GET[ban]\"");
    }
    if (isset($_GET["unban"])) {
      $mysqli->query("UPDATE Students SET isbanned=\"0\" WHERE studentnetID=\"$_GET[unban]\"");
    }
    if (isset($_GET["delete"])) {
      $mysqli->query("UPDATE Posts SET response=\"<i>This post has been deleted by an administrator</i>\" WHERE postID=\"$_POST[delete]\"");
    }
    if (isset($_GET["unflag"])) {
      $mysqli->query("UPDATE Posts SET isFlagged=0 WHERE postID='$_GET[unflag]'");
    }

    //loop through all posts that are flagged, create a link that goes right to the review in the forum
    $results = $mysqli->query("SELECT * FROM Posts NATURAL JOIN TopicToPosts NATURAL JOIN Topics NATURAL JOIN Students WHERE isFlagged=\"1\"");
    if ($results->num_rows != 0) { //if there are flagged posts
      print("<table>");
      print("<thead><th>netID</th><th>Username</th><th>Topic Title</th><th>Post</th><th>Banned?</th></thead>");

      // if admin bans someone, update database (users)
      while ($array = $results->fetch_assoc()) {

        print("<tr><td>$array[studentnetID]</td><td>$array[username]</td><td>$array[title]</td><td><a href=\"discuss.php?topicID=$array[topicID]\">$array[response]</a></td>");
        if ($array["isbanned"] == 0) {
          print("<td><a href=\"admin.php?task=flagged&ban=$array[studentnetID]\">Click to ban</a>");
        } else {
          print("<td>Banned. <a href=\"admin.php?task=flagged&unban=$array[studentnetID]\">Click to unban</a>");
        }
        print("<br><a href=\"admin.php?task=flagged&delete=$array[postID]\">Click to delete post</a>
          <br><a href=\"admin.php?task=flagged&unflag=$array[postID]\">Click to unflag post</a></td></tr>");

      }
      print("</table>");
    } else {
      print("There are no flagged posts at this time.");
    }
    //if flagged review
  } elseif ($_GET["task"] == "flaggedreview") {
    if (isset($_GET["ban"])) {
      $mysqli->query("UPDATE Students SET isbanned=\"1\" WHERE studentnetID=\"$_GET[ban]\"");
    }
    if (isset($_GET["unban"])) {
      $mysqli->query("UPDATE Students SET isbanned=\"0\" WHERE studentnetID=\"$_GET[unban]\"");
    }

    if (isset($_GET["delete"])) {
      $mysqli->query("DELETE FROM Ratings WHERE ratingID='$_GET[delete]'");
    }
    if (isset($_GET["unflag"])) {
      $mysqli->query("UPDATE Ratings SET isFlagged=0 WHERE ratingID='$_GET[unflag]'");
    }

    //loop through all posts that are flagged, create a link that goes right to the post in the forum
    $results = $mysqli->query("SELECT * FROM Ratings NATURAL JOIN Students NATURAL JOIN Professors NATURAL JOIN Classes WHERE isFlagged=\"1\"");
    if ($results->num_rows != 0) { //if there are flagged ratings
      print("<table>");
      print("<thead><th>Course</th><th>Professor</th><th>Username</th><th>Rating</th><th>Review</th><th>Banned?</th></thead>");

      // if admin bans someone, update database (users)
      while ($array = $results->fetch_assoc()) {

        print("<tr><td>$array[CourseName]</td><td>$array[fName] $array[lName]</td><td>$array[username]</td><td>$array[rating]</td><td>$array[review]</td>");
        if ($array["isbanned"] == 0) {
          print("<td><a href=\"admin.php?task=flaggedreview&ban=$array[studentnetID]\">Click to ban</a>");
        } else {
          print("<td>Banned. <a href=\"admin.php?task=flaggedreview&unban=$array[studentnetID]\">Click to unban</a>");
        }
        print("<br><a href=\"admin.php?task=flaggedreview&delete=$array[ratingID]\">Click to delete review</a>
          <br><a href=\"admin.php?task=flaggedreview&unflag=$array[ratingID]\">Click to unflag review</a></td></tr>");

      }
      print("</table>");
    } else {
      print("There are no flagged reviews at this time.");
    }


  } elseif ($_GET["task"] == "approve") {
    if (isset($_POST["approveprofadd"])) {
      $mysqli->query("UPDATE Professors SET profapproved=1 WHERE professornetID='$_POST[profnetid]'");
    }
    if (isset($_POST["deleteprofadd"])) {
      $mysqli->query("DELETE FROM Professors WHERE professornetID='$_POST[profnetid]'");
    }


    //display professors that need to be approved
    $results = $mysqli->query("SELECT * FROM Professors WHERE profapproved=0");
    if ($results->num_rows != 0) { //if there are pending professors
      print("<table>");
      print("<thead><th>netID</th><th>First Name</th><th>Last Name</th><th>Approve?</th></thead>");

      // if admin bans someone, update database (users)
      while ($array = $results->fetch_assoc()) {

        print("<tr><td>$array[professornetID]</td><td>$array[fName]</td><td>$array[lName]</td><td>
          <form action=\"admin.php?task=approve\" method=\"post\" onSubmit=\"return confirm('Are you sure you want to approve this?')\">
          <input type=\"hidden\" name=\"profnetid\" value=\"$array[professornetID]\" />
          <input type=\"submit\" name=\"approveprofadd\" value=\"Approve\" /></form>

          <form action=\"admin.php?task=approve\" method=\"post\" onSubmit=\"return confirm('Are you sure you want to delete this?')\">
          <input type=\"hidden\" name=\"profnetid\" value=\"$array[professornetID]\" />
          <input type=\"submit\" name=\"deleteprofadd\" value=\"Remove\" /></form>
          </td>
          </tr>");

      }
      print("</table>");
    } else {
      print("There are no pending professor additions at this time.");
    }
    //-------------------------------------------------************************--------------------------------
    print("<br />");
    //stuff to approve classes
    if (isset($_POST["approvecourseadd"])) {
      $mysqli->query("UPDATE Classes SET classapproved=1 WHERE courseID='$_POST[courseid]'");
    }
    if (isset($_POST["deletecourseadd"])) {
      $mysqli->query("DELETE FROM Classes WHERE courseID='$_POST[courseid]'");
    }


    //loop through all posts that are flagged, create a link that goes right to the post in the forum
    $results = $mysqli->query("SELECT * FROM Classes WHERE classapproved=0");
    if ($results->num_rows != 0) { //if there are pending professors
      print("<table>");
      print("<thead><th>Course Name</th><th>Approve?</th></thead>");

      // if admin bans someone, update database (users)
      while ($array = $results->fetch_assoc()) {

        print("<tr><td>$array[CourseName]</td><td>
          <form action=\"admin.php?task=approve\" method=\"post\" onSubmit=\"return confirm('Are you sure you want to approve this?')\">
          <input type=\"hidden\" name=\"courseid\" value=\"$array[courseID]\" />
          <input type=\"submit\" name=\"approvecourseadd\" value=\"Approve\" /></form>

          <form action=\"admin.php?task=approve\" method=\"post\" onSubmit=\"return confirm('Are you sure you want to delete this?')\">
          <input type=\"hidden\" name=\"courseid\" value=\"$array[courseID]\" />
          <input type=\"submit\" name=\"deletecourseadd\" value=\"Remove\" /></form>
          </td>
          </tr>");

      }
      print("</table>");
    } else {
      print("There are no pending course additions at this time.");
    }
  }

} else {
  // if not logged in

  print("You do not have sufficient privileges to view this page.");

  //page should not be viewable in a tab, but if person types link directly, page will show helpful message ("You do not have sufficient privileges...")
}

$mysqli->close();
?>

</div>



  </body>
  </html>
