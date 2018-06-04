<?php
require("phpsqlsearch_dbinfo.php");
// Get parameters from URL
//$slat = $_GET["slat"];
//$slng = $_GET["slng"];
$dbn = $_GET["dbn"];
// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);
// Opens a connection to a mySQL server
$conn_string =  "host=134.74.112.18 dbname=d210 user=safv17 password=yous";
$connection=pg_connect ($conn_string);
if (!$connection) {
  die("Not connected");
}
// Search the rows in the markers table
$query = "select name, borocd, housenum, streetname, city, lat, lng FROM libraries where st_distance(libraries.geom, (SELECT geom from schools where dbn='".$dbn."'))<5000;";
//  pg_real_escape_string($district),
//  mysql_real_escape_string($center_lng),
//  mysql_real_escape_string($center_lat),
 // mysql_real_escape_string($dist));
$result = pg_query($query);
if (!$result) {
  die("Invalid query: " . pg_last_error());
}
header("Content-type: text/xml");
// Iterate through the rows, adding XML nodes for each
while ($row = @pg_fetch_assoc($result)){
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("name", $row['name']);
  $newnode->setAttribute("borocode", $row['borocd']);
  $newnode->setAttribute("housenum", $row['housenum']);
  $newnode->setAttribute("streetname", $row['streetname']);
  $newnode->setAttribute("city", $row['city']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
}
echo $dom->saveXML();
?>
