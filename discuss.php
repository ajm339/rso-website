<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Discussion</title>
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Quicksand:700" />
    <!--<link rel="stylesheet" type="text/css" href="styles/styles.css" />-->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript" src="scripts/scripts.js"></script>
<script type="text/javascript" src="scripts/navigation.js" ></script>
<script type="text/javascript" src="scripts/jquery-bp.js" ></script>


<link rel="stylesheet" href="css/main.css" type="text/css" />

  <script type="text/javascript" src="js/jquery.js" ></script>
<script type="text/javascript" src="js/jquery-bp.js" ></script>
<script type="text/javascript" src="js/navigation.js" ></script>
<!--<script type="text/javascript" src="js/tables.js" ></script>-->
  </head>
  <body>
    <? require('inc/header.php'); ?>

  <div class='wrapper discuss'>

<?php
//DISCUSSION BOARD
//connect to the database
require('inc/database.php');

//unset($_SESSION["admin"]);
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
    if (isset($_POST["submittopic"]) && !empty($_POST['title']) && !empty($_POST['response'])) {
      date_default_timezone_set('America/New_York');
      $date = date('Y-m-d H:i:s', time());
      $title = htmlentities(mysqli_real_escape_string($mysqli,$_POST["title"]));


      $mysqli->query("INSERT INTO Topics(title, dateCreated, dateModified, topicCreator) Values('$title', '$date', '$date', '$_SESSION[username]')");
      $_GET["topicID"] = mysqli_insert_id($mysqli);
    }elseif(isset($_POST["submittopic"]) && (empty($_POST["title"]) || empty($_POST['response']))){
      echo "Please enter both a topic title and first post.";
    }

    //if a topic is selected -- isset($_GET["topicID"])
    if (isset($_GET["topicID"])) {
      print("<a id='back' href = 'discuss.php'>Back</a>");
      $sanitizedtopicID = htmlentities(mysqli_real_escape_string($mysqli, $_GET["topicID"]));
      $results = $mysqli->query("SELECT * FROM Topics WHERE topicID=\"$sanitizedtopicID\"");
      $array = $results->fetch_assoc();
      print("<h2>$array[title]</h2>");
      //if user tries to add a post (isset($_POST["submitpost"])?)
      if (isset($_POST["response"])) {
        if(!empty($_POST['response'])){
          //use a query to add it to the topic (and the database, with the correct topicID)
          date_default_timezone_set('America/New_York');
          $date = date('Y-m-d H:i:s', time());
          $response = htmlentities(mysqli_real_escape_string($mysqli,$_POST["response"]));

          $mysqli->query("INSERT INTO Posts(timePosted, response, username) Values('$date', '$response', '$_SESSION[username]')");
          $postid = mysqli_insert_id($mysqli);
          $mysqli->query("INSERT INTO TopicToPosts(topicID, postID) VALUES($_GET[topicID],$postid)");
          $mysqli->query("UPDATE Topics SET dateModified='$date' WHERE topicID='$_GET[topicID]'");
        }else{
          echo "Please write a response before submitting.";
        }
      }
      //if user tries to rate a post
      if (isset($_POST["postrating"])) {
        //use query to update the ratings for that post
      }

      //if user flags a post
      if (isset($_POST["flagpost"])){
        //update post in the database that it is flagged
        $mysqli->query("UPDATE Posts SET isFlagged='1' WHERE postID='$_POST[postid]'");
      }

      if (isset($_SESSION["admin"]) && isset($_POST["ban"])) { //ban user if button is hit
        $mysqli->query("UPDATE Students SET isbanned=\"1\" WHERE studentnetID=\"$_POST[ban]\"");
      }

      if (isset($_SESSION["admin"]) && isset($_POST["delete"])) { //delete specific post if button is hit
        $mysqli->query("UPDATE Posts SET response=\"<i>This post has been deleted by an administrator</i>\" WHERE postID=\"$_POST[delete]\"");
      }

      //show all the posts in that topic -- query -- loop through results
      $results = $mysqli->query("SELECT * FROM TopicToPosts NATURAL JOIN Posts NATURAL JOIN Students WHERE topicID='$_GET[topicID]' ORDER BY timePosted");
      if ($results->num_rows > 0) {
        if (isset($_SESSION["student"])) { //display posts as student
          print("<table class=\"topicTable\">");
          print("<thead><th>Post Information</th><th>Response</th></thead>");
          //View as Normal User
          while ($array = $results->fetch_assoc()) {
            if ($array["isFlagged"] == 0) {
              $militaryTime = substr($array['timePosted'], 10);
              $date = substr($array['timePosted'], 0, 10);
              $standardTime = date('h:i:s A', strtotime($militaryTime));
              print("<tr><td id = 'USERNAME'>$array[username] <br /><br />
                Time Posted: $date $standardTime <br /><br />
                <form action=\"discuss.php?topicID=$_GET[topicID]\" method=\"post\">
                <input type=\"hidden\" name=\"postid\" value=\"$array[postID]\" />
                <input type=\"submit\" name=\"flagpost\" value=\"Flag Post!\" /></form>
                </td>
                <td id = 'RESPONSE'>$array[response]</td></tr>");
            } else {
              //View as Normal User with Flagged Post
              print("<tr><td id = 'USERNAME'>$array[username] <br /><br />
                Time Posted: $array[timePosted] <br /><br />Post has been flagged.</td>
                <td id = 'RESPONSE'>$array[response]</td></tr>");
            }

          }
          print("</table>");
        } elseif (isset($_SESSION["admin"])) { //display posts as admin
          print("<table class=\"topicTable\">");
          print("<thead><th>Post Information</th><th>Response</th><th>Ban User</th></thead>");
          //View as Admin
          while ($array = $results->fetch_assoc()) {
            $militaryTime = substr($array['timePosted'], 10);
            $date = substr($array['timePosted'], 0, 10);
            $standardTime = date('h:i:s A', strtotime($militaryTime));

            print("<tr><td id = 'USERNAME'>$array[username] <br /><br />
              Time Posted: $date $standardTime <br /><br />
              <form action=\"discuss.php?topicID=$_GET[topicID]\" method=\"post\" onSubmit=\"return confirm('Are you sure you want to delete this post?')\">
              <input type=\"hidden\" name=\"delete\" value=\"$array[postID]\" />
              <input type=\"submit\" value=\"Delete Post\" /></form>
              </td>

              <td id = 'RESPONSE'>$array[response]</td>");

            if ($array["isbanned"] == 0){
              print("<td><form action=\"discuss.php?topicID=$_GET[topicID]\" method=\"post\" onSubmit=\"return confirm('Are you sure you want to ban this user?')\">
                <input type=\"hidden\" name=\"ban\" value=\"$array[studentnetID]\" />
                <input type=\"submit\" value=\"Ban User\" /></form></td></tr>");
            } else {
              print("</tr>");
            }

          }
          print("</table>");
        }
      } else {
        print("There are no posts yet in this topic...");
      }

      if (isset($_SESSION["admin"])) {
        $query = $mysqli->query("SELECT * FROM Students WHERE studentnetID='$_SESSION[admin]'");
      } else {
        $query = $mysqli->query("SELECT * FROM Students WHERE studentnetID='$_SESSION[student]'");
      }
      $array = $query->fetch_assoc();
      if ($array["isbanned"] == 0) {
?>
        <form action="discuss.php?topicID=<?php echo $_GET["topicID"]; ?>" method="post">
          <textarea id = "discussionRESPONSE" type="textarea" name="response" onfocus="this.value=''; setbg('#e5fff3');" onblur="setbg('white')">Write a response...</textarea>
          <br />
          <input type="submit" name="submitpost" value="Add your post!"/>
          </form>

<?php
      }
    } else {
      // else, display a list of all the topics -- query

      //loop through each topic in the database, and add a link (text is topic title) that adds "?topicID=[topic's id #]" to URL


      if (isset($_SESSION['admin']) && isset($_POST["deleteTopic"])) { //delete specific specific topic if button is hit
        $mysqli->query("DELETE FROM Posts WHERE postID IN (SELECT postID FROM TopicToPosts WHERE topicID='$_POST[deleteTopic]')");
        $mysqli->query("DELETE FROM Topics WHERE topicID=\"$_POST[deleteTopic]\"");
        $mysqli->query("DELETE FROM TopicToPosts WHERE topicID=\"$_POST[deleteTopic]\"");
      }

      $results = $mysqli->query("SELECT * FROM Topics ORDER BY dateModified DESC");


?>

      <h1>Discussion Board</h1>

        <h3>Search for topics:</h3>
        <form action="discuss.php" method="post">
        <input type="text" name="search" placeholder="Search for a topic..." />
        <input type="submit" name="searchtopic" value="Search topics!"/>
        </form>
<?php
      //form to add a topic
?>
      <br>
        <h3>Use this form to create a new topic:</h3>
        <form action="discuss.php" method="post">
        Topic Title:<input type="text" name="title" placeholder="Topic Title"/>
        First Post:<input type="text" name="response" placeholder="First post..." />
        <input type="submit" name="submittopic" value="Create topic!"/>
        </form>
<?php
      if ($results->num_rows > 0) {



        //For admins
        if (isset($_SESSION['admin'])) {
          if (isset($_POST["searchtopic"])) {
            $results = $mysqli->query("SELECT * FROM Topics WHERE title LIKE \"%".htmlentities(mysqli_real_escape_string($mysqli,$_POST["search"]))."%\" ORDER BY dateModified DESC");
            if ($results->num_rows > 0) {
              print("<table class=\"tableSTYLES\">");
              print("<thead><th>Forum Title</th><th>Topic Creator</th><th>Date Modified</th><th>Delete</th></thead>");
              while ($array = $results->fetch_assoc()) {
                $militaryTime = substr($array['dateModified'], 10);
                $date = substr($array['dateModified'], 0, 10);
                $standardTime = date('h:i:s A', strtotime($militaryTime));
                print("<tr><td><a href=\"discuss.php?topicID=$array[topicID]\">$array[title]</a></td><td>$array[topicCreator]</td><td>$date $standardTime</td><td>
                  <form action=\"discuss.php\" method=\"post\" onSubmit=\"return confirm('Are you sure you want to delete this topic?')\">
                  <input type=\"hidden\" name=\"deleteTopic\" value=\"$array[topicID]\" />
                  <input type=\"submit\" value=\"Delete Topic\" /></form></td></tr>");
              }
              print("</table>");
            } else {
              print("Sorry, there were no results for your search.");
            }
          } else { //if user is not searching for a topic, list all topics
            print("<table>");
            print("<thead><th>Forum Title</th><th>Topic Creator</th><th>Date Modified</th><th>Delete</th></thead>");
            while ($array = $results->fetch_assoc()) {
              $militaryTime = substr($array['dateModified'], 10);
              $date = substr($array['dateModified'], 0, 10);
              $standardTime = date('h:i:s A', strtotime($militaryTime));
              print("<tr><td><a href=\"discuss.php?topicID=$array[topicID]\">$array[title]</a></td><td>$array[topicCreator]</td><td>$date $standardTime</td><td>
                <form action=\"discuss.php\" method=\"post\" onSubmit=\"return confirm('Are you sure you want to delete this topic?')\">
                <input type=\"hidden\" name=\"deleteTopic\" value=\"$array[topicID]\" />
                <input type=\"submit\" value=\"Delete Topic\" /></form></td></tr>");
            }
            print("</table>");
          }

        }else{

          //For normal logged in users
          if (isset($_POST["searchtopic"])) {
            $results = $mysqli->query("SELECT * FROM Topics WHERE title LIKE \"%".htmlentities(mysqli_real_escape_string($mysqli,$_POST["search"]))."%\" ORDER BY dateModified");
            if ($results->num_rows > 0) {
              print("<table class=\"tableSTYLES\">");
              print("<thead><th>Forum Title</th><th>Topic Creator</th><th>Date Modified</th></thead>");
              while ($array = $results->fetch_assoc()) {
                $militaryTime = substr($array['dateModified'], 10);
                $date = substr($array['dateModified'], 0, 10);
                $standardTime = date('h:i:s A', strtotime($militaryTime));
                print("<tr><td><a href=\"discuss.php?topicID=$array[topicID]\">$array[title]</a></td><td>$array[topicCreator]</td><td>$date $standardTime</td></tr>");
              }
              print("</table>");
            } else {
              print("Sorry, there were no results for your search.");
            }
          } else {
            print("<table>");
            print("<thead><th>Forum Title</th><th>Topic Creator</th><th>Date Modified</th></thead>");
            while ($array = $results->fetch_assoc()) {
              $militaryTime = substr($array['dateModified'], 10);
              $date = substr($array['dateModified'], 0, 10);
              $standardTime = date('h:i:s A', strtotime($militaryTime));
              print("<tr><td><a href=\"discuss.php?topicID=$array[topicID]\">$array[title]</a></td><td>$array[topicCreator]</td><td>$date $standardTime</td></tr>");
            }
            print("</table>");
          }
        }

      } else {
        print("There are no topics in the forum... Try adding one!");
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
