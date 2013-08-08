<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Ratings</title>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Quicksand:700" />
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script type="text/javascript" src="scripts/scripts.js"></script>
    <script type="text/javascript" src="scripts/navigation.js" ></script>
    <script type="text/javascript" src="scripts/jquery-bp.js" ></script>
    <link rel="stylesheet" href="css/main.css" type="text/css" />

    <script type="text/javascript" src="js/jquery.js" ></script>
    <script type="text/javascript" src="js/jquery-bp.js" ></script>
    <script type="text/javascript" src="js/navigation.js" ></script>
  </head>
  <body>
  <? require('inc/header.php'); ?>

  <div class='wrapper rate'>

<?php
//RATINGS

//connect to the database
require('inc/database.php');

//CHECK IF USER IS LOGGED IN. If yes....
if (isset($_SESSION["admin"]) || isset($_SESSION["student"])) {
  if (isset($_SESSION["admin"])) {
    $query = $mysqli->query("SELECT * FROM Students WHERE studentnetID='$_SESSION[admin]'");
  } else {
    $query = $mysqli->query("SELECT * FROM Students WHERE studentnetID='$_SESSION[student]'");
  }
  $array = $query->fetch_assoc();
  $isbanned = $array["isbanned"];
  if ($isbanned == 0) {

    if(isset($_GET["all"])){
      if ($_GET["all"] == "professors") {
        print ("<h3><a class='breadcrumbs' href=\"rate.php\">Rate Home</a> > Professors</h3>");
      }
      if ($_GET["all"] == "classes") {
        print ("<h3><a class='breadcrumbs' href=\"rate.php\">Rate Home</a> > Classes</h3>");
      }
    }
    if (isset($_GET["class"])) {
      $results = $mysqli->query("SELECT * FROM Classes WHERE courseID=\"$_GET[class]\"");
      $array = $results->fetch_assoc();
      print ("<h3><a class='breadcrumbs' href=\"rate.php\">Rate Home</a> > <a class='breadcrumbs' href=\"rate.php?all=classes\">Classes</a> > $array[CourseName]</h3>");
    }
    if (isset($_GET["professor"])) {
      $results = $mysqli->query("SELECT * FROM Professors WHERE professornetID=\"$_GET[professor]\"");
      $array = $results->fetch_assoc();
      print ("<h3><a class='breadcrumbs' href=\"rate.php\">Rate Home</a> > <a class='breadcrumbs' href=\"rate.php?all=professors\">Professors</a> > $array[fName] $array[lName]</h3>");
    }


    //ALL CLASSES TAUGHT BY PROFESSOR
    //if professor is selected -- $_GET["professor"]
    if (isset($_GET["professor"])) {
      $sanitizedprofessorID = htmlentities(mysqli_real_escape_string($mysqli, $_GET["professor"]));
      $results = $mysqli->query("SELECT * FROM Professors WHERE professornetID=\"$sanitizedprofessorID\"");
      if ($results->num_rows > 0 ){ //if there is a professor with the given netID...

        $array = $results->fetch_assoc();
        print("<h2>Showing reviews for <span class='highlight'>\"$array[fName] $array[lName]\"</span></h2>");
        print("<h4>Click the Class to read the ratings for all of the professors that teach the course</h4>");
        //print("<h3><a href=\"rate.php?all=professors\">Click to view all professors.</a></h3>");

        if (isset($_POST["flagrating"])) {
          $mysqli->query("UPDATE Ratings SET isFlagged=1 WHERE ratingID=$_POST[ratingid]");
        }

        // if user tries to add a review
        if (isset($_POST["addreviewsubmit"])) {
          //check if user submitted review for this class already (prevents spamming)
          $check = $mysqli->query("SELECT * FROM Ratings WHERE courseID=\"$_POST[courseID]\" AND professornetID=\"$sanitizedprofessorID\" AND studentnetID=\"$_SESSION[netid]\"");

          //if not spam, add review to the database
          if ($check->num_rows == 0) {
            if (empty($_POST["review"])) { //replace empty review with "N/A"
              $review = "N/A";
            } else {
              $review = htmlentities(mysqli_real_escape_string($mysqli, $_POST["review"]));
            }
            $mysqli->query("INSERT INTO Ratings(professornetID, courseID, studentnetID, rating, review)
              VALUES('$sanitizedprofessorID', '$_POST[courseID]', '$_SESSION[netid]', '$_POST[rating]', '$review')");
          } else {
            $spam = "You have already submitted a review for this professor teaching that course.";
          }
        }

        //show all classes taught by that professor -- query -- loop through results
        $results = $mysqli->query("SELECT AVG(rating) FROM Professors NATURAL JOIN Ratings WHERE professornetID=\"$sanitizedprofessorID\"");
        $average = $results->fetch_row();
        $results = $mysqli->query("SELECT * FROM Professors NATURAL JOIN Classes NATURAL JOIN Ratings WHERE professornetID = \"$sanitizedprofessorID\"");
        if ($results->num_rows > 0) {
          print("Average rating: $average[0]");
          print("<table>");
          print("<thead><th>Class</th><th>Rating</th><th>Review</th><th></th></thead>");
          while ($array = $results->fetch_assoc()) {
            // if admin bans someone, update database (users)
            print("<tr><td><a href=\"rate.php?class=$array[courseID]\">$array[CourseName]</a></td><td>$array[rating]</td><td>$array[review]</td><td>");
            if ($array["isFlagged"] == 0) {
              print("<form action=\"rate.php?professor=$_GET[professor]\" method=\"post\" onSubmit=\"return confirm('Are you sure you want to flag this?')\">
                <input type=\"hidden\" name=\"ratingid\" value=\"$array[ratingID]\" />
                <input type=\"submit\" name=\"flagrating\" value=\"Flag Review!\" /></form>");
            } else {
              print("Flagged.");
            }
            print("</td></tr>");
          }
          print("</table>");
        } else { //show message if there are no reviews currently
          print("There are no reviews for this course currently. Try adding one!<br>");
        }

        if (isset($spam)) {//tell the user if they already wrote a review for the given professor/class combo; prevent spamming
          print("<br>$spam<br>");
        }

        print("<br>Add a review for this professor!");
?>
        <form action="rate.php?professor=<?php echo $_GET["professor"] ?>" method="post">
          Course: <select name="courseID" required>
<?php
        $courses = $mysqli->query("SELECT DISTINCT(courseID), CourseName FROM Classes WHERE classapproved = 1 ORDER BY CourseName");
        while($array = $courses->fetch_assoc()) {
          print("<option value=\"$array[courseID]\">$array[CourseName]</option>");
        }
?>
        </select>
          Rating: <select name="rating" required>
<?php
        for($i = 1; $i <= 10; $i++) {
          print("<option value=\"$i\">$i</option>");
        }
?>
        </select>
          Review: <input type="text" name="review">
          <input type="submit" name="addreviewsubmit" value="Add review!">
          </form>

<?php
      } else {
        print("<h2>The professor with the given netID does not exist. Please contact a system administrator for assistance if necessary.");
      }

    } elseif (isset($_GET["class"])) {
      //SPECIFIC CLASS
      //if class is selected -- $_GET["class"]
      $sanitizedCourseID = htmlentities(mysqli_real_escape_string($mysqli, $_GET["class"]));
      $results = $mysqli->query("SELECT CourseName FROM Classes WHERE courseID=\"$sanitizedCourseID\"");
      if ($results->num_rows > 0 ) { // if there is a class with a given ID...
        $array = $results->fetch_assoc();
        $courseName = $array["CourseName"];
        print("<h2>Showing reviews for <span class='highlight'>\"$courseName\"</span></h2>");
        print("<h4>Click the Professor Name to read reviews for all of the classes that the professor teaches</h4>");
        //print("<h3><a href=\"rate.php?all=classes\">Click to view all classes.</a></h3>");

        if (isset($_POST["flagrating"])) {
          $mysqli->query("UPDATE Ratings SET isFlagged=1 WHERE ratingID=$_POST[ratingid]");
        }

        //if user tries to add review
        if (isset($_POST["addreviewsubmit"])) {
          //check if user submitted review for this class already (prevents spamming)
          $check = $mysqli->query("SELECT * FROM Ratings WHERE courseID=\"$sanitizedCourseID\" AND studentnetID=\"$_SESSION[netid]\"");

          //if not spam, add review to the database
          if ($check->num_rows == 0) {
            if (empty($_POST["review"])) { //replace empty review with "N/A"
              $review = "N/A";
            } else {
              $review = htmlentities(mysqli_real_escape_string($mysqli, $_POST["review"]));
            }
            $mysqli->query("INSERT INTO Ratings(professornetID, courseID, studentnetID, rating, review)
              VALUES('$_POST[professornetID]', '$sanitizedCourseID', '$_SESSION[netid]', '$_POST[rating]', '$review')");
          } else {
            $spam = "You have already submitted a review for this course.";
          }
        }
        //show ratings/reviews for that class
        $results = $mysqli->query("SELECT AVG(rating) FROM Classes NATURAL JOIN Ratings WHERE courseID=\"$sanitizedCourseID\"");
        $average = $results->fetch_row();
        $results = $mysqli->query("SELECT * FROM Ratings NATURAL JOIN Classes NATURAL JOIN Professors WHERE courseID=\"$sanitizedCourseID\"");
        if ($results->num_rows > 0) {
          print("Average rating: $average[0]");
          print("<table>");
          print("<thead><th>Professor Name</th><th>Rating</th><th>Review</th><th></th></thead>");
          while ($array = $results->fetch_assoc()) {
            // if admin bans someone, update database (users)

            print("<tr><td><a href=\"rate.php?professor=$array[professornetID]\">$array[lName], $array[fName]</a></td><td>$array[rating]</td><td>$array[review]</td>
              <td>");
            if ($array["isFlagged"] == 0) {
              print("<form action=\"rate.php?class=$_GET[class]\" method=\"post\" onSubmit=\"return confirm('Are you sure you want to flag this?')\">
                <input type=\"hidden\" name=\"ratingid\" value=\"$array[ratingID]\" />
                <input type=\"submit\" name=\"flagrating\" value=\"Flag Review!\" /></form>");
            } else {
              print("Flagged.");
            }
            print("</td></tr>");
          }
          print("</table>");
        } else {
          print("There are no reviews for this course currently. Try adding one!<br>");
        }

        if (isset($spam)) {
          print("<br>$spam<br>");
        }

        print("<br>Add a review for this class!");

        $professors = $mysqli->query("SELECT * FROM Professors");
?>
        <form action="rate.php?class=<?php echo $_GET["class"] ?>" method="post">
          Professor: <select name="professornetID" required>
<?php
        while($array = $professors->fetch_assoc()) {
          print("<option value=\"$array[professornetID]\">$array[lName], $array[fName]</option>");
        }
?>
        </select>
          Rating: <select name="rating" required>
<?php
        for($i = 1; $i <= 10; $i++) {
          print("<option value=\"$i\">$i</option>");
        }
?>
        </select>
          Review: <input type="text" name="review">
          <input type="submit" name="addreviewsubmit" value="Add review!">
          </form>

<?php
      } else {
        print("<h2>The class with the given ID does not exist. Please contact a system administrator for assistance if necessary.");
      }

    } else {
      // else, have options to display all professors or classes

      //"Sort by classes..." -- $_GET["allclasses] == true

      //"Sort by professors..." -- $_GET["allprofessors"] == true

      //ALL PROFESSORS OR CLASSES
      if (!isset($_GET["all"])) {
        print("<h1 class = 'CENTERED'>Rate Home</h1>");
        print("<div class='adminMAINbuttons'>");
        print("<a href=rate.php?all=professors><button class = \"adminBUTTON\">View by Professor</button></a>");
        print("<a href=rate.php?all=classes><button class = \"adminBUTTON\">View by Class</button></a>");
        print("</div>");
      } elseif ($_GET["all"] == "professors") {
        //ALL PROFESSORS
        $results = $mysqli->query("SELECT * FROM Professors WHERE profapproved=1 ORDER BY lName");
        print("<h2>Showing all professors!");
        print("<h4>Click the Professor Name to read reviews for all of the classes that the professor teaches</h4>");
        //print("<h3><a href=\"rate.php?all=classes\">Click to view all classes...</a></h3>");
        print("<table>");
        print("<thead><th>Professor Name</th></thead>");
        while ($array = $results->fetch_assoc()) {
          // if admin bans someone, update database (users)

          print("<tr><td><a href=\"rate.php?professor=$array[professornetID]\">$array[lName], $array[fName]</a></td></tr>");
        }
        print("</table>");


        //form for student to add a professor who is not yet in the database
        print("<br>Add a professor to be rated!");
?>
        <form action="rate.php?all=<?php echo $_GET["all"] ?>" method="post">
          First name: <input type="text" name="fName">
          Last name: <input type="text" name="lName">
          netID: <input type="text" name="profnetID">
          <input type="submit" name="addprof" value="Add professor!">
          </form>

<?php

        if (isset($_POST["addprof"])){
          if (!empty($_POST["fName"]) && !empty($_POST["lName"]) && !empty($_POST["profnetID"])) {
            //sanitize
            $fName = htmlentities(mysqli_real_escape_string($mysqli,$_POST["fName"]));
            $lName = htmlentities(mysqli_real_escape_string($mysqli,$_POST["lName"]));
            $profnetID = htmlentities(mysqli_real_escape_string($mysqli,$_POST["profnetID"]));

            $mysqli->query("INSERT INTO Professors(professornetID, lName, fName, profapproved) VALUES('$profnetID','$lName','$fName','0')");
            print("Your suggestion has been sent to the administrators to approve.");

          } else {
            print("Each box in the form must be filled out.");
          }
        }

      } elseif ($_GET["all"] == "classes") {
        //ALL CLASSES
        $results = $mysqli->query("SELECT * FROM Classes WHERE classapproved=1 ORDER BY CourseName");
        print("<h2>Showing all courses");
        print("<h4>Click the Course Names to read the reviews for the class</h4>");
        //print("<h3><a href=\"rate.php?all=professors\">Click to view all professors...</a></h3>");
        print("<table>");
        print("<thead><th>Course Name</th></thead>");
        while ($array = $results->fetch_assoc()) {
          // if admin bans someone, update database (users)

          print("<tr><td><a href=\"rate.php?class=$array[courseID]\">$array[CourseName]</a></td></tr>");
        }
        print("</table>");

        print("<br>Add a class to be rated!");
?>
        <form action="rate.php?all=<?php echo $_GET["all"] ?>" method="post">
          Course Name: <input type="text" name="coursename">
          <input type="submit" name="addcourse" value="Add Course!">
          </form>

<?php

        if (isset($_POST["addcourse"])){
          if (!empty($_POST["coursename"])) {
            //sanitize
            $coursename = htmlentities(mysqli_real_escape_string($mysqli,$_POST["coursename"]));

            $mysqli->query("INSERT INTO Classes(CourseName, classapproved) VALUES('$coursename','0')");
            print("Your suggestion has been sent to the administrators to approve.");

          } else {
            print("Each box in the form must be filled out.");
          }
        }
      }
    }
  } else {
    print("You cannot view this page because you have been banned.");
  }

  // if not logged in
} else {

  //page should not be viewable in a tab, but if person types link directly, page will show helpful message ("You do not have sufficient privileges...")
  print("You do not have sufficient privileges to view this page.");
}
?>

</div>



  </body>
  </html>
