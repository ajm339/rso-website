<?php date_default_timezone_set("America/New_York"); ?>
<div id='header'>
  <?php include("inc/title.php");?>
</div>
<div id='navigation' class='container'>
  <div id='positionNAV'>
    <div id='index' class='pri-nav'>
      <div>
        <a href='index.php'>Index</a>
      </div>
    </div>
    <div id='about' class='pri-nav'>
      <div>
        <a href='about.php'>About Us</a>
      </div>
    </div>
    <div id='employers' class='pri-nav'>
      <div>
        <a href='employers.php'>Employers</a>
      </div>
    </div>
    <div id='login' class='pri-nav'>
      <div>
        <a href='login.php'>Log In</a>
      </div>
    </div><?php
        if(isset($_SESSION['student'])){echo ("<div id='rate' class='pri-nav'><div><a href=\"rate.php\">Rate</a></div></div>
          <div id='discuss' class='pri-nav'><div><a href=\"discuss.php\">Discuss</a></div></div>");}

          if(isset($_SESSION['admin'])){echo ("<div id='rate' class='pri-nav'><div><a href=\"rate.php\">Rate</a></div></div>
            <div id='discuss' class='pri-nav'><div><a href=\"discuss.php\">Discuss</a></div></div>
            <div id='admin' class='pri-nav'><div><a href=\"admin.php\">Admin</a></div></div>");}
        ?>
  </div>
</div>
