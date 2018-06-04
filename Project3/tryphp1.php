<?php

// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("marker");
$parnode = $dom->appendChild($node);

// Opens a connection to a pgSQL server
$conn_string = "host=134.74.112.18 dbname=d210 user=safv17 password=yous";
$conn = pg_connect($conn_string);
if(!$conn){
    die ("Could not open connection to database server");
}
$query = "SELECT * FROM ethnicity ";
$result = pg_query($conn, $query);
if(!$result){
    die('Invalid query : ' . pg_last_error());
}
header("Content-type: text/xml");
// Iterate through the rows, adding XML nodes for each
while ($row = pg_fetch_assoc($result)){
// ADD TO XML DOCUMENT NODE
$node = $dom->createElement("marker");
$newnode = $parnode->appendChild($node);
$newnode->setAttribute("id",$row['id']);
$newnode->setAttribute("schooldist", $row['schooldist']);
$newnode->setAttribute("category",$row['category']);
$newnode->setAttribute("avg_students", $row['avg_students']);
}
echo $dom->saveXML();
?>
