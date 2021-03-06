<?php
/**
 * Created by PhpStorm.
 * User: 0702555
 * Date: 07/11/2016
 * Time: 14:05
 */




// connect to your Azure server and select database (remember you connection details are all on the azure portal
$db = new mysqli(
    'eu-cdbr-azure-west-a.cloudapp.net',
    'b49490bb912f60',
    'e12a1d1b',
    'groupdatacreg' );

// test our connection
if ($db->connect_errno) {
    die ('Connection Failed :'.$db->connect_error );
}

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);


$query = "SELECT * FROM markers WHERE 1";
$result = $db->query($query);
if (!$result) {
    die('Nothing in result: ');
}
header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

while ($row = $result->fetch_array()){
    // ADD TO XML DOCUMENT NODE
    $node = $dom->createElement("marker");
    $newnode = $parnode->appendChild($node);
    $newnode->setAttribute("name",$row['name']);
    $newnode->setAttribute("address", $row['address']);
    $newnode->setAttribute("lat", $row['lat']);
    $newnode->setAttribute("lng", $row['lng']);
    $newnode->setAttribute("type", $row['type']);
}


$result->close();
$db->close();

echo $dom->saveXML();

?>
