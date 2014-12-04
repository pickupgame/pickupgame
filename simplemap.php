<?php
error_reporting(0);
include_once("db/sql_functions.php");

  if(isset($_GET['Game_ID']))
  {
    $GameID = $_GET['Game_ID'];
    $query = "SELECT latitude, longitude FROM game WHERE Game_ID=?";
    $row = query($GameID,$query);
    if($row)
    {
      $lat = $row[0]["latitude"];
      $lon = $row[0]["longitude"];
    }
  }
  else
  {
    //default values
    $lat = "42.318766321413";
    $lon = "-83.26135446582";
  }

?>
<!DOCTYPE html>
<html> 
<head> 
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <title>Google Maps Multiple Markers</title> 
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvHfRePZIED1nOkkd0zrK6g6IzUAujCO4" 
          type="text/javascript"></script>
  <script type="text/javascript" src="javascript/jquery-1.11.1.js"></script>          
</head> 
<body>
  <div id="map" style="width: 400px; height: 300px; margin: 0 auto;"></div>

  <script type="text/javascript">
$(function(){
  var games = [];
  $.getJSON("api/locations.php",
  function(locations)
  {
    
    if(locations != null)
    {
      $.each(locations, function(idx, obj) {
        games.push(obj); 
      });       
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: <?php echo isset($_GET['Game_ID']) ? "16" : "10"; ?>,
        center: new google.maps.LatLng(<?php echo $lat ?>, <?php echo $lon ?>),
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });

      var marker, i;
      for (i = 0; i < games.length; i++) {  
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(games[i]['latitude'], games[i]['longitude']),
          map: map,
          icon: 'images/' + games[i]['sport'] + '.png',
          title: games[i]['name'],
          url: 'index.php?page=browse&Game_ID=' + games[i]['Game_ID']
        });
        marker['infowindow'] = new google.maps.InfoWindow({
          content: '<div>Name: ' + games[i]['name'] + '</div>' +
                  '<div>Description: ' + games[i]['Description'] + '</div>',
          disableAutoPan : true
        });


        google.maps.event.addListener(marker, 'mouseover', function() {
            this['infowindow'].open(map, this);
        });
        google.maps.event.addListener(marker, 'mouseout', function() {
            this['infowindow'].close(map, this);
        });
        google.maps.event.addListener(marker, 'click', function() {
            window.location.href = this.url;
        });
      }        
    }
    else
    {
    }
  });

});
  </script>
</body>
</html>