<?php
include("../db/globals.php");

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

function getSports()
{
    $db = dbConnect();
    $sql = "select SportName from sport";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $query = $stmt->get_result();

    if($query->num_rows > 0)
    {   
        return $result = $query->fetch_all(MYSQLI_ASSOC); 
    }
    else
    {
        return NULL;
    }

    mysql_close($db);

}

function getGameDetails($GameID)
{
    $db = dbConnect();
    $sql = "select * from game where Game_ID=?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i', $GameID);
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

     mysql_close($db);
}

function getPlayerDetails($GameID)          // Pulls player details for Join Page (Not needed but available to use as this is Jake's functionality)
{
   
    $db = dbConnect();
    $sql = "select PlayerID from gameplayer where GameID=?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i', $GameID);
    $stmt->execute();
    $query = $stmt->get_result();
    $result = $query->fetch_all(MYSQLI_ASSOC);
    $detailsdisplayarray = array();


    foreach($result as $matchedID)
    {
        $playerrating = 0;
        $playerrating2 = 0;
        $counter = 0;
        $ratingquery = "select Rating from playerratinggame where PlayerEvaluated = ?";
        $stmt = $db->prepare($ratingquery);
        $stmt->bind_param('i', $matchedID['PlayerID']);
        $stmt->execute();
        $matchedratings = $stmt->get_result();
        $matchedratingsaddition = $matchedratings->fetch_all(MYSQLI_ASSOC);
        
        foreach($matchedratingsaddition as $sum)
        {
            $playerrating += $sum['Rating'];
            $sum['Rating'] -= $playerrating;
            $counter++;
        }


        $playerdetailsquery = "select Name, Age from userprofile where UserID = ?";    
        $stmt = $db->prepare($playerdetailsquery);
        $stmt->bind_param('i', $matchedID['PlayerID']);
        $stmt->execute();
        $profileinfo = $stmt->get_result();
        $profilearray = $profileinfo->fetch_all(MYSQLI_ASSOC);

        foreach($profilearray as $value)
        {
            $detailsdisplayarray[] = array('Name' => $value["Name"], 'Age' => $value["Age"], 'Rating' => ($playerrating/$counter));
        }

    }
   
        return $detailsdisplayarray;
        mysql_close($db);
}

function HostGame($GameName, $Sport, $MaxPlayersNum, $DateAndTime, $Password, $Private, $Host_ID, $Description, $Latitude, $Longitude)
{
    $db = dbConnect();
    $sql = "INSERT INTO `game` (GameName, Sport, MaxPlayersNum, DateAndTime, Password, Private, Host_ID, Description, Latitude, Longitude)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('ssissiisdd', $GameName, $Sport, $MaxPlayersNum, $DateAndTime, $Password, $Private, $Host_ID, $Description, $Latitude, $Longitude);
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

     mysql_close($db);

}

function JoinGame($GameID, $PlayerID)
{
    $db = dbConnect();
    $sql = "INSERT INTO `gameplayer` (GameID, PlayerID) VALUES (?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('ii', $GameID, $PlayerID);
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

     mysql_close($db);
}

function checkGamePassword($GameID, $Password)
{
    $db = dbConnect();
    $sql = "select Password from game where Game_ID=?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i', $GameID);
    $stmt->execute();
    $query = $stmt->get_result();
    $returnedpw = $query->fetch_all(MYSQLI_ASSOC);

    foreach ($returnedpw as $checkpw)
    {
        if($checkpw['Password'] === $Password)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

    }
     mysql_close($db);
}

function kickPlayer($GameID, $PlayerID)
{
    $db = dbConnect();
    $sql = "DELETE FROM gameplayer where GameID=? AND PlayerID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('ii', $GameID,$PlayerID);
    $stmt->execute();
    return TRUE;
    mysql_close($db);
}

?>

