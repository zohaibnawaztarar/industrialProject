<?php

$serverName = "zeno.computing.dundee.ac.uk";
$connectionOptions = array(
    "Database" => "ip19team8db",
    "Uid" => "ip19team8",
    "PWD" => "abc111abc111.."
);

#Create connection to database.
$conn = sqlsrv_connect($serverName, $connectionOptions);


$sql = "SELECT *  FROM dbo.DRGChargesData WHERE averageTotalPayments BETWEEN 0 AND 10000";

#running query
$results = sqlsrv_query($conn, $sql);

#if result is returned, print all rows. 
if( $results === false) {
    die( print_r( sqlsrv_errors(), true) );
}
else
{
	while($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)) 
	{
        echo $row['dRGCode'].", ".$row['providerName'].",".$row['averageTotalPayments']."<br/>";
    }
}

#Frees resources from statement.
sqlsrv_free_stmt( $results);

?>
