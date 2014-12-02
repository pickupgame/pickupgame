<?php
include("globals.php");
function dbConnect()
{
    $db = new mysqli($GLOBALS['host'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if($db->connect_errno)
    {
        echo "<br>Error connecting to the Database. Contact the Database Administrator.<br>";
    }
    return $db;
}
function query($param, $querystring)
{
    // echo "$querystring <br>";
    $db = dbConnect();
    $sql = $querystring;
    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $param);
    $stmt->execute();
    $query = $stmt->get_result();
    if($query->num_rows > 0)
    {   
        return $query->fetch_all(MYSQLI_ASSOC); //returns a NUM indexed array with an associative inside for all rows.
    }
    else
    {
        return NULL;
    }
}
function insertHostRating($PlayerEvaluated, $PlayerRater, $Rating)
{
    $db = dbConnect();
    $sql = "INSERT INTO `hostratinggame` (PlayerEvaluated, PlayerRater, Rating)
    VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('ssi', $PlayerEvaluated, $PlayerRater, $Rating);
    $stmt->execute();
    // echo $db->error;
    if($stmt->affected_rows > 0)
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}
function getLikes($UserID)
{
    $sql = "select * from hostratinggame where PlayerEvaluated=?";
    $query = query($UserID, $sql);
    return count($query);
}
function getPassword($UserName)
{
    $db = dbConnect();
    $sql = "SELECT Password FROM userprofile WHERE UserName = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $UserName);
    $stmt->execute();
    $query = $stmt->get_result();
    if($query->num_rows > 0)
    {
        $row = $query->fetch_array(MYSQLI_ASSOC);
        $password=$row["Password"];
    }
    if($query->num_rows > 0)
    {   
        return $password; //returns the password for that username
    }
    else
    {
        return "";
    }
}
function getUserID($UserName)
{
    $db = dbConnect();
    $sql = "SELECT UserID FROM userprofile WHERE UserName = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $UserName);
    $stmt->execute();
    $query = $stmt->get_result();
    if($query->num_rows > 0)
    {
        $row = $query->fetch_array(MYSQLI_ASSOC);
        $userID=$row["UserID"];
    }
    if($query->num_rows > 0)
    {   
        return $userID; //returns the password for that username
    }
    else
    {
        return NULL;
    }
}
function getUserName($UserID)
{
    $db = dbConnect();
    $sql = "SELECT UserName FROM userprofile WHERE UserID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $UserID);
    $stmt->execute();
    $query = $stmt->get_result();
    if($query->num_rows > 0)
    {
        $row = $query->fetch_array(MYSQLI_ASSOC);
        $username=$row["UserName"];
    }
    if($query->num_rows > 0)
    {   
        return $username; //returns the password for that username
    }
    else
    {
        return NULL;
    }
}
function getSecurityQuestion($UserID)
{
    $db = dbConnect();
    $sql = "SELECT SecurityQuestion FROM userprofile WHERE UserID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $UserID);
    $stmt->execute();
    $query = $stmt->get_result();
    if($query->num_rows > 0)
    {
        $row = $query->fetch_array(MYSQLI_ASSOC);
        $securityquestion=$row["SecurityQuestion"];
    }
    if($query->num_rows > 0)
    {   
        return $securityquestion; //returns the password for that username
    }
    else
    {
        return NULL;
    }
}
function getSecurityAnswer($UserID)
{
    $db = dbConnect();
    $sql = "SELECT SecurityAnswer FROM userprofile WHERE UserID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $UserID);
    $stmt->execute();
    $query = $stmt->get_result();
    if($query->num_rows > 0)
    {
        $row = $query->fetch_array(MYSQLI_ASSOC);
        $securityanswer=$row["SecurityAnswer"];
    }
    if($query->num_rows > 0)
    {   
        return $securityanswer; //returns the password for that username
    }
    else
    {
        return NULL;
    }
}

function InsertNewUser($Name, $Age, $UserName, $Password, $SecurityQuestion, $SecurityAnswer, $ImageLocation)
{
    $db = dbConnect();
    $sql = "INSERT INTO `userprofile` (Name, Age, UserName, Password, SecurityQuestion, SecurityAnswer, ImageLocation)
    VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('sisssss', $Name, $Age, $UserName, $Password, $SecurityQuestion, $SecurityAnswer, $ImageLocation);
    $stmt->execute();
    // echo $db->error;
    if($stmt->affected_rows > 0)
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function CheckifUserNameExist($UserName)
{
    $db = dbConnect();
    $sql = "select * from userprofile where UserName = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $UserName);
    $stmt->execute();
    $query = $stmt->get_result();
    if($stmt->affected_rows > 0)
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}


function DetermineNextUserID()
{
    $db = dbConnect();
    $sql = "select UserID from userprofile";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $query = $stmt->get_result();
    $maxnum=max($query->fetch_all(MYSQLI_ASSOC));
    if($stmt->affected_rows > 0)
    {
        return $maxnum['UserID'] +1;
    }
    else
    {
        return 1;
    }
}

// added NEw Functions here
function getUserInfo($UserID)
{
    $db = dbConnect();
    $sql = "SELECT * FROM userprofile WHERE UserID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i', $UserID);
    $stmt->execute();
    $query = $stmt->get_result();
    if($query->num_rows > 0)
    {
        return $row=$query->fetch_array(MYSQLI_ASSOC);
    }
    else
    {
        return null;
    }
}
function UpdateUserInfo($UserID, $Name, $Age, $ImageLocation)
{
    $db = dbConnect();
    $sql = "UPDATE  `userprofile` SET Name=?, Age=?, ImageLocation=? WHERE UserID=?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('sisi', $Name, $Age, $ImageLocation, $UserID);
    $stmt->execute();
    // echo $db->error;
    if($stmt->affected_rows > 0)
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}
//updated from Josh's page
function getUpcomingGames($PlayerID)
{
    $db = dbConnect();
    $sql = "SELECT game.Game_ID, game.GameName, game.Sport, game.DateAndTime FROM game INNER JOIN gameplayer ON game.Game_ID = gameplayer.GameID WHERE gameplayer.PlayerID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i', $PlayerID);
    $stmt->execute();
    $query = $stmt->get_result();
    $counting = $query->fetch_all(MYSQLI_NUM);
    $db->close();
    if($query->num_rows > 0)
    {
        echo "<h2>Upcoming Games</h2>";
        echo "<table class='table table-striped table-condensed'>";
        foreach($counting as $dope)
        {
        echo "<th>Name</th>";
        echo "<th>Sport</th>";
        echo "<th>Date and Time</th>";
        echo "<th></th>";
        echo "<tr>";
        echo "<td>{$dope[1]}</td>";
        echo "<td>{$dope[2]}</td>";
        echo "<td>{$dope[3]}</td>";
        echo "</tr>";
        }
        echo "</table>";
    }
    else
    {
        return NULL;
    }
}

//used from previous -- DO NOT ADD
function getPlayerRating($UserID)
{
    $db = dbConnect();
    //positive ratings
    $sql = "SELECT * FROM playerratinggame WHERE PlayerEvaluated = ? AND Rating = 1";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i', $UserID);
    $stmt->execute();
    $query = $stmt->get_result();
    $positive = $query->num_rows;
    //negative ratings
    $sql = "SELECT * FROM playerratinggame WHERE PlayerEvaluated = ? AND Rating = 0";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i', $UserID);
    $stmt->execute();
    $query = $stmt->get_result();
    $negative = $query->num_rows;
    $db->close();    
    return ($positive - $negative);
}

//used from previous -- DO NOT ADD
function getHostRating($UserID)
{
    $db = dbConnect();
    //positive ratings
    $sql = "SELECT * FROM hostratinggame WHERE PlayerEvaluated = ? AND Rating = 1";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i', $UserID);
    $stmt->execute();
    $query = $stmt->get_result();
    $positive = $query->num_rows;
    //negative ratings
    $sql = "SELECT * FROM hostratinggame WHERE PlayerEvaluated = ? AND Rating = 0";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i', $UserID);
    $stmt->execute();
    $query = $stmt->get_result();
    $negative = $query->num_rows;
    $db->close();    
    return ($positive - $negative);
}

//new function -- Please add
function getTotalRatingsAsPlayer($UserID)
{
    $sql = "SELECT * from hostratinggame where PlayerEvaluated=?";
    $query = query($UserID, $sql);
    if($query)
    {
        return count($query);    
    }
    else
    {
        return NULL;
    }
    
}

?>