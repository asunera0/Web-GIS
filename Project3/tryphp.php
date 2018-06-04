<?php
//require("dbinfo.php");

// Start XML file, create parent node
$borocode = 1;
$dom = new DOMDocument("1.0");
$node = $dom->createElement("marker");
$parnode = $dom->appendChild($node);

// Opens a connection to a pgSQL server
$conn_string = "host=134.74.112.18 dbname=d210 user=safv17 password=yous";
$conn = pg_connect($conn_string);  
if(!$conn){
    die ("Could not open connection to database server");
}
$query = "SELECT category,avg_students FROM ethnicity where schooldist='$borocode' ";
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
$newnode->setAttribute("category",$row['category']);
$newnode->setAttribute("students", $row['avg_students']);
//$newnode->setAttribute("borocode",$row['borocode']);
//$newnode->setAttribute("x", $row['x']);
//$newnode->setAttribute("y", $row['y']);
}
echo $dom->saveXML();
?>
