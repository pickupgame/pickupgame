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
    // var_dump($query);
    $db->close();
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
    $db->close();
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
    if($query)
    {
        return count($query);    
    }
    else
    {
        return NULL;
    }
    
}

function getGamePlayers($Game_ID)
{
    $sql = "select PlayerID from gameplayer where GameID=?";
    $query = query($Game_ID, $sql);
    if($query)
    {
        return $query;
    }
    else
        return NULL;
}


function getPlayerDetails($UserID)
{
    $sql = "select UserID, Name, Age, UserName, ImageLocation from userprofile where UserID=?";
    $query = query($UserID, $sql);
    if($query)
    {
        return $query[0];
    }
    else
        return NULL;
}


?>
