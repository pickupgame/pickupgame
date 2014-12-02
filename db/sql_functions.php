<?php
include_once("globals.php");
$tabPaneCount = 0;
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
    if($PlayerEvaluated == $PlayerRater)
    {
        echo "<span class='text-danger'>You cannot rate yourself.</span>";
        return FALSE;
    }
    else
    {

        if(!checkHostRatedAlready($PlayerRater, $PlayerEvaluated))
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
        else
        {
            echo "You already rated that host!";
            return FALSE;            
        }
    }
}
function insertPlayerRating($PlayerEvaluated, $PlayerRater, $Rating)
{
    if($PlayerEvaluated == $PlayerRater)
    {
        echo "<span class='text-danger'>You cannot rate yourself.</span>";
        return FALSE;
    }
    else
    {
        if(!checkPlayerRatedAlready($PlayerRater, $PlayerEvaluated))
        {
            $db = dbConnect();
            $sql = "INSERT INTO `playerratinggame` (PlayerEvaluated, PlayerRater, Rating)
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
        else
        {
            echo "You already rated that player!";
            return FALSE;            
        }
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
    $db->close();
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
    $db->close();
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
    $db->close();
    if($query->num_rows > 0)
    {
        $result = $query->fetch_all(MYSQLI_ASSOC);        
        //get game details for each game returned
        $games = array();
        foreach($result as $v)
        {
             $games = getGameDetails($v['GameID']);
        }
        return $games;
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
    $db->close();
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
    $db->close();
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
    $db->close();
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
    $db->close();
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
    $db->close();
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
    if(!CheckifUserNameExist($UserName))
    {
        $sql = "INSERT INTO `userprofile` (Name, Age, UserName, Password, SecurityQuestion, SecurityAnswer, ImageLocation)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('sisssss', $Name, $Age, $UserName, $Password, $SecurityQuestion, $SecurityAnswer, $ImageLocation);
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
    else
    {
        $db->close();
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
    $db->close();
    if($query->num_rows > 0)
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }

}
function checkHostRatedAlready($PlayerRater, $PlayerEvaluated)
{
    $db = dbConnect();    
    $sql = "SELECT * from hostratinggame where PlayerRater=? AND PlayerEvaluated=?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('ii', $PlayerRater, $PlayerEvaluated);
    $stmt->execute();
    $query = $stmt->get_result();
    $db->close();
    if($query->num_rows > 0)
    {   
        return TRUE;
    }
    else
    {
        return FALSE;
    }

}
function checkPlayerRatedAlready($PlayerRater, $PlayerEvaluated)
{
    $db = dbConnect();    
    $sql = "SELECT * from playerratinggame where PlayerRater=? AND PlayerEvaluated=?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('ii', $PlayerRater, $PlayerEvaluated);
    $stmt->execute();
    $query = $stmt->get_result();
    $db->close();
    if($query->num_rows > 0)
    {   
        return TRUE;
    }
    else
    {
        return FALSE;
    }

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

function userInGame($PlayerID, $GameID)
{
    $db = dbConnect();
    $sql = "SELECT * FROM gameplayer WHERE GameID=? AND PlayerID=?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('ii', $GameID, $PlayerID);
    $stmt->execute();
    $query = $stmt->get_result();
     // echo $db->error;
    $db->close();
    if($query->num_rows > 0)
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }   
}

function JoinGame($GameID, $PlayerID)
{
    //cant allow host to join his own game as a player
    if(getHost($GameID) != $PlayerID)
    {
        if(!userInGame($PlayerID, $GameID))
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
        else
        {
            echo "<span class='text-danger'>You are already in the game.</span>";
            return FALSE;
        }
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
    if(userInGame($PlayerID, $GameID))
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
        echo "<td><a class='btn btn-info btn-xs' href='index.php?page=browse&Game_ID={$game['Game_ID']}'>View Details</a></td>";
        echo "</tr>";
        
    }
    echo "</table>";
}
function getPlayersRemaining($Game_ID)
{
    $db = dbConnect();
    //get max players
    $sql = "SELECT MaxPlayersNum FROM game WHERE Game_ID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i', $Game_ID);
    $stmt->execute();
    $query = $stmt->get_result();
    $maxplayers = $query->fetch_all(MYSQLI_ASSOC);
    //get total players in game
    $sql = "SELECT PlayerID FROM gameplayer WHERE GameID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i', $Game_ID);
    $stmt->execute();
    $query = $stmt->get_result();
    $currentlyplaying = $query->num_rows;
    $db->close();

    return $currentlyplaying . "/" . $maxplayers[0]['MaxPlayersNum'];

}

function generateSportsTabs()
{
    $db = dbConnect();
    $sql = "select SportName from sport";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $query = $stmt->get_result();
    $db->close();
    $tabCount = 0;
    if($query->num_rows > 0)
    {   
        $result = $query->fetch_all(MYSQLI_ASSOC);
        echo "<div role='tabpanel' id='mytab'>";
        echo '<ul class="nav nav-tabs" role="tablist">';
        foreach($result as $v)
        {
            if($tabCount == 0)
                echo "<li role='presentation' class='active'><a href = '#{$v['SportName']}' role='tab' data-toggle='tab' aria-controls='{$v['SportName']}'>{$v['SportName']}</a></li>";       // Just have links now. May want to swap for buttons (didn't want to 
            else                                                                                                                                                               // add buttons because of Bootstrap implementation)  
                echo "<li role='presentation'><a href = '#{$v['SportName']}' role='tab' data-toggle='tab' aria-controls='{$v['SportName']}'>{$v['SportName']}</a></li>";

            $tabCount++;
        }
        echo '</ul>';

        echo "<div class='tab-content'>";
        foreach($result as $v)
        {
            retrieveSportDetails($v['SportName']);
        }

        echo "</div>";
        echo "</div>";

    }
    else
    {
        return NULL;
    }
}

function retrieveSportDetails($SportName)
{
    global $tabPaneCount;
    $db = dbConnect();
    $sql = "SELECT Game_ID, Name, Sport, DateAndTime, Private, Host_ID FROM game WHERE Sport = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $SportName);
    $stmt->execute();
    $query = $stmt->get_result();
    $db->close();
    if($tabPaneCount == 0)
        echo "<div role='tabpanel' class='tab-pane active' id='{$SportName}'>";
    else
        echo "<div role='tabpanel' class='tab-pane' id='{$SportName}'>";
    $tabPaneCount++;
    echo "<table class='table table-striped'>";
    echo "<th>Name</th>";
    echo "<th>Sport</th>";
    echo "<th>Date and Time</th>";
    echo "<th>Players</th>";
    echo "<th>Pass?</th>";
    echo "<th>Host Rating</th>";

    if($query->num_rows > 0)
    {   
        $query->fetch_all(MYSQLI_ASSOC); //returns a NUM indexed array with an associative inside for all rows.
        foreach ($query as $sportsinfo)
        {
            echo "<tr>";
            echo "<td><a href='index.php?page=browse&Game_ID={$sportsinfo['Game_ID']}'>" . $sportsinfo['Name'] . "</a></td>";
            echo "<td>" . $sportsinfo['Sport'] . "</td>";
            echo "<td>" . $sportsinfo['DateAndTime'] . "</td>";
            echo "<td>" . getPlayersRemaining($sportsinfo['Game_ID']) . "</td>";

            if($sportsinfo['Private'] != 1)
            {
                echo "<td>No</td>";
            }
            
            if($sportsinfo['Private'] === 1)
            {
                echo "<td>Yes</td>";
            }

            echo "<td>" . getHostRating($sportsinfo['Host_ID']). "</td>";
            echo "</tr>";
        }
    }
    else
    {
        return NULL;
    }

       echo "</table>";
       echo "</div>";
}


function getUserInfo($UserID)
{
    $db = dbConnect();
    $sql = "SELECT * FROM userprofile WHERE UserID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i', $UserID);
    $stmt->execute();
    $query = $stmt->get_result();
    $db->close();
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
//updated from Josh's page
function getUpcomingGames($PlayerID)
{
    $db = dbConnect();
    $sql = "SELECT game.Game_ID, game.Name, game.Sport, game.DateAndTime FROM game INNER JOIN gameplayer ON game.Game_ID = gameplayer.GameID WHERE gameplayer.PlayerID = ?";
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