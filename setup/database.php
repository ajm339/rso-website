<?php

require("../inc/database.php");

$sql = "
CREATE TABLE `Classes` (
  `courseID` int(11) NOT NULL AUTO_INCREMENT,
  `CourseName` text NOT NULL,
  `classapproved` tinyint(1) NOT NULL,
  PRIMARY KEY (`courseID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

CREATE TABLE `Posts` (
  `postID` int(11) NOT NULL AUTO_INCREMENT,
  `timePosted` datetime NOT NULL,
  `isFlagged` tinyint(1) NOT NULL DEFAULT '0',
  `response` text NOT NULL,
  `username` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`postID`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

CREATE TABLE `Professors` (
  `professornetID` varchar(255) NOT NULL DEFAULT '',
  `fName` varchar(255) NOT NULL DEFAULT '',
  `lName` varchar(255) NOT NULL DEFAULT '',
  `profapproved` tinyint(1) NOT NULL,
  PRIMARY KEY (`professornetID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Ratings` (
  `ratingID` int(11) NOT NULL AUTO_INCREMENT,
  `professornetID` varchar(255) NOT NULL DEFAULT '',
  `courseID` int(11) NOT NULL,
  `studentnetID` varchar(255) NOT NULL DEFAULT '',
  `rating` int(11) NOT NULL,
  `review` text NOT NULL,
  `isFlagged` tinyint(1) NOT NULL,
  PRIMARY KEY (`ratingID`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

CREATE TABLE `Students` (
  `studentnetID` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(255) NOT NULL DEFAULT '',
  `hashpassword` varchar(255) NOT NULL DEFAULT '',
  `isbanned` tinyint(1) NOT NULL DEFAULT '0',
  `activation` varchar(255) DEFAULT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `forgotPassword` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`studentnetID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `TaughtBy` (
  `courseID` int(11) NOT NULL,
  `professornetID` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `Topics` (
  `topicID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `dateCreated` date NOT NULL,
  `dateModified` datetime NOT NULL,
  `topicCreator` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`topicID`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

CREATE TABLE `TopicToPosts` (
  `postID` int(11) NOT NULL,
  `topicID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";

$mysqli->query($sql);
