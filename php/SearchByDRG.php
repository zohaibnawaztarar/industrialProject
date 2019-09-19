
<?php
include './db_connect.php';


$sql = "SELECT * FROM dbo.newDB WHERE dRGCode=?";
$dRGCode =39;
$params = array($dRGCode);
#running query
$results = sqlsrv_query($conn, $sql, $params);

#if result is returned, print all rows. 
if( $results === false) {
    die( print_r( sqlsrv_errors(), true) );
}
else
{
	while($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)) 
	{
        echo $row['dRGCode'].", ".$row['providerName']."<br />";
    }
}
#Frees resources from statement.
sqlsrv_free_stmt( $results);
?>
