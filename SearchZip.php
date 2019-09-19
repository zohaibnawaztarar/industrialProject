
<?php

//include './db_connect.php';
/*
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

$sql = "SELECT * FROM dbo.newDB WHERE dRGCode=?";
$dRGCode =39;
$params = array($dRGCode);
#running query
$results = sqlsrv_query($conn, $sql, $params);
if( $results === false) {
    die( print_r( sqlsrv_errors(), true) );
}
//header("Content-type: text/xml");
// Iterate through the rows, adding XML nodes for each
while ($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)){
    // Add to XML document node
    $node = $dom->createElement("marker");
    $newnode = $parnode->appendChild($node);
    $newnode->setAttribute("providerZipCode", $row['providerZipCode']);
}
        $dom->save("/php/testingZipcode.xml");
*/

$xmlString = '<?xml version="1.0" encoding="ISO-8859-1"?>
<note>
<from>Jani</from>
<to>Tove</to>
<message>Remember me this weekend</message>
</note>';

$dom = new DOMDocument;
$dom->loadXML($xmlString);
 echo $xmlString;
//Save XML as a file
 echo $dom->save('/php/sitemap.xml');
?>

