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
        print($securityquestion);
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
?>