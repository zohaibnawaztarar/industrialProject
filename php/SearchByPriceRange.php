<!-- returns list of procedures filtered by price range-->
<?php
include './db_connect.php';

$lowerlimit = 0;
$upperlimit = 5000;
$sql = "SELECT *  FROM dbo.newDB WHERE averageTotalPayments BETWEEN ? AND ?";
$params = array($lowerlimit, $upperlimit);
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
        echo $row['dRGCode'].", ".$row['dRGDescription'].",".$row['averageTotalPayments']."<br/>";
    }
}

#Frees resources from statement.
sqlsrv_free_stmt( $results);

?>
