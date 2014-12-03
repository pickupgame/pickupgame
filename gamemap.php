<!DOCTYPE html>
<?php
error_reporting(E_ALL);
include_once("/db/sql_functions.php");

  if(isset($_GET['Game_ID']))
  {
    $GameID = $_GET['Game_ID'];
    $queres = "SELECT * FROM game WHERE Game_ID=?";
    $row = query($GameID,$queres);
    $lat = $row[0]["Latitude"];
    $lon = $row[0]["Longitude"];
    $sport = $row[0]["Sport"];
    $gname = $row[0]["Name"];
  }
  else
  {
    $lat = "";
    $lon = "";
    $sport = "";
    $gname = ""; 
  }

?>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Complex icons</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>

    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvHfRePZIED1nOkkd0zrK6g6IzUAujCO4">
    </script>
    <script>
// This example adds a marker to indicate the position
// of Bondi Beach in Sydney, Australia
function initialize() {
  var jlat = <?php echo $lat ?>;
  var jlon = <?php echo $lon ?>;
  var jsport = "<?php echo $sport ?>";
  var jname = "<?php echo $gname ?>";
  var mapOptions = {
    zoom: 15,
    center: new google.maps.LatLng(jlat, jlon)
  }
  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

  var image = 'images/flag.png';
  var myLatLng = new google.maps.LatLng(jlat, jlon);
  var gameMarker = new google.maps.Marker({
      position: myLatLng,
      map: map,
      icon: image,
      title: jname
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>