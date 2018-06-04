<?php
require("phpsqlsearch_dbinfo.php");
// Get parameters from URL
//$center_lat = $_GET["lat"];
//$center_lng = $_GET["lng"];
$district = $_GET["district"];
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
// Set the active mySQL database
//$db_selected = mysql_select_db($database, $connection);
//if (!$db_selected) {
//  die ("Can\'t use db : " . mysql_error());
//}
// Search the rows in the markers table
$query = "SELECT dbn, district, name, totalstudents, gradrate, safety, quality, classsize, lat, lng FROM schools where district = ".$district;//"+$district+";";
//  pg_real_escape_string($district),
//  mysql_real_escape_string($center_lng),
//  mysql_real_escape_string($center_lat),
 // mysql_real_escape_string($dist));
$result = pg_query($query);
//$result = mysql_query($query);
if (!$result) {
  die("Invalid query: " . pg_last_error());
}
header("Content-type: text/xml");
// Iterate through the rows, adding XML nodes for each
while ($row = @pg_fetch_assoc($result)){
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("dbn", $row['dbn']);
  $newnode->setAttribute("name", $row['name']);
  $newnode->setAttribute("gradrate", $row['gradrate']);
  $newnode->setAttribute("safety", $row['safety']);
  $newnode->setAttribute("quality", $row['quality']);
  $newnode->setAttribute("classsize", $row['classsize']);
  $newnode->setAttribute("totalstudents", $row['totalstudents']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("district", $row['district']);
}
echo $dom->saveXML();
?>
