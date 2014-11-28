<?php
include_once("globals.php");

function dbConnect()
{
    $db = new mysqli($GLOBALS['host'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']) or die('Unable to connect.');
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

function getGamePlayers($Game_ID)
{
    $sql = "SELECT PlayerID from gameplayer where GameID=?";
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
    $sql = "SELECT UserID, Name, Age, UserName, ImageLocation from userprofile where UserID=?";
    $query = query($UserID, $sql);
    if($query)
    {
        return $query[0];
    }
    else
        return NULL;
}
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

function getHost($GameID)
{
    $db = dbConnect();
    $sql = "SELECT Host_ID FROM game WHERE Game_ID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i', $GameID);
    $stmt->execute();
    $query = $stmt->get_result();
    if($query->num_rows > 0)
    {
        $result = $query->fetch_array(MYSQLI_ASSOC);
        return $result['Host_ID'];
    }
    else
    {
        return NULL;
    }
}

//These getGames functions are for home page functionality. If the user is logged in, it will display their hosted and participating games.
function getHostGames($UserID)
{
    $db = dbConnect();
    $sql = "SELECT * FROM game WHERE Host_ID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i', $UserID);
    $stmt->execute();
    $query = $stmt->get_result();
    if($query->num_rows > 0)
    {
        $result = $query->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
    else
    {
        return NULL;
    }
}

function getPlayerGames($UserID)
{
    $db = dbConnect();
    $sql = "SELECT GameID FROM gameplayer WHERE PlayerID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i', $UserID);
    $stmt->execute();
    $query = $stmt->get_result();
    if($query->num_rows > 0)
    {
        $result = $query->fetch_all(MYSQLI_ASSOC);        
        //get game details for each game returned
        return getGameDetails($UserID);
    }
    else
    {
        return NULL;
    }



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
    $sql = "SELECT * from userprofile where UserName = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $UserName);
    $stmt->execute();
    $query = $stmt->get_result();

}

function getSports()
{
    $db = dbConnect();
    $sql = "SELECT SportName from sport";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $query = $stmt->get_result();
    $db->close();
    if($query->num_rows > 0)
    {   
        return $result = $query->fetch_all(MYSQLI_ASSOC); 
    }
    else
    {
        return NULL;
    }

}

function getGameDetails($GameID)
{
    $db = dbConnect();
    $sql = "SELECT * from game where Game_ID=?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i', $GameID);
    $stmt->execute();
    $query = $stmt->get_result();
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


// function getPlayerDetails($GameID)          // Pulls player details for Join Page (Not needed but available to use as this is Jake's functionality)
// {
   
//     $db = dbConnect();
//     $sql = "SELECT PlayerID from gameplayer where GameID=?";
//     $stmt = $db->prepare($sql);
//     $stmt->bind_param('i', $GameID);
//     $stmt->execute();
//     $query = $stmt->get_result();
//     $result = $query->fetch_all(MYSQLI_ASSOC);
//     $detailsdisplayarray = array();


//     foreach($result as $matchedID)
//     {
//         $playerrating = 0;
//         $playerrating2 = 0;
//         $counter = 0;
//         $ratingquery = "SELECT Rating from playerratinggame where PlayerEvaluated = ?";
//         $stmt = $db->prepare($ratingquery);
//         $stmt->bind_param('i', $matchedID['PlayerID']);
//         $stmt->execute();
//         $matchedratings = $stmt->get_result();
//         $matchedratingsaddition = $matchedratings->fetch_all(MYSQLI_ASSOC);
        
//         foreach($matchedratingsaddition as $sum)
//         {
//             $playerrating += $sum['Rating'];
//             $sum['Rating'] -= $playerrating;
//             $counter++;
//         }


//         $playerdetailsquery = "SELECT Name, Age from userprofile where UserID = ?";    
//         $stmt = $db->prepare($playerdetailsquery);
//         $stmt->bind_param('i', $matchedID['PlayerID']);
//         $stmt->execute();
//         $profileinfo = $stmt->get_result();
//         $profilearray = $profileinfo->fetch_all(MYSQLI_ASSOC);

//         foreach($profilearray as $value)
//         {
//             $detailsdisplayarray[] = array('Name' => $value["Name"], 'Age' => $value["Age"], 'Rating' => ($playerrating/$counter));
//         }

//     }
   
//         return $detailsdisplayarray;
//         $db->close();
// }

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

}


function DetermineNextUserID()
{
    $db = dbConnect();
    $sql = "SELECT UserID from userprofile";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $query = $stmt->get_result();
    $maxnum=max($query->fetch_all(MYSQLI_ASSOC));
    $db->close();
    if($stmt->affected_rows > 0)
    {
        return $maxnum['UserID'] +1;
    }
    else
    {
        return 1;
    }

}

function JoinGame($GameID, $PlayerID)
{
    $db = dbConnect();
    $sql = "INSERT INTO `gameplayer` (GameID, PlayerID) VALUES (?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('ii', $GameID, $PlayerID);
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

function checkGamePassword($GameID, $Password)
{
    $db = dbConnect();
    $sql = "SELECT Password from game where Game_ID=?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i', $GameID);
    $stmt->execute();
    $query = $stmt->get_result();
    $returnedpw = $query->fetch_all(MYSQLI_ASSOC);
    $db->close();
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
    
}

function kickPlayer($GameID, $PlayerID)
{
    $db = dbConnect();
    $sql = "DELETE FROM gameplayer where GameID=? AND PlayerID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('ii', $GameID,$PlayerID);
    $stmt->execute();
    $db->close();
    if($stmt->affected_rows == 1)
        return TRUE;
    else
        return FALSE;
}


function displayGames($GameDetails, $type)
{
    echo "<table class='table table-striped table-condensed'>";
    foreach($GameDetails as $index=>$game)
    {
        echo "<th>Name</th>";
        echo "<th>Sport</th>";
        echo "<th>Date and Time</th>";
        echo "<th></th>";
        echo "<tr>";
        echo "<td>{$game['Name']}</td>";
        echo "<td>{$game['Sport']}</td>";
        echo "<td>{$game['DateAndTime']}</td>";
        echo "<td><a href='index.php?page=browse&Game_ID={$game['Game_ID']}'>View Details</a></td>";
        echo "</tr>";
        
    }
    echo "</table>";
}


?>