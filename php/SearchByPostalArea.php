<!-- Get list of procedures for a given hospital-->
<?php
include 'db_connect.php';

$sql = "SELECT * FROM dbo.newDB WHERE providerZipCode LIKE ? AND dRGCode=?;";
#10 here is the first 2 digits of the zipcode given by the user and % is the regular expression
$zipCodeDigits = '10%';
$dRGCode = 39;
$params = array($zipCodeDigits, $dRGCode);
$result = sqlsrv_query($conn, $sql, $params);
$index = 0;
if( $result == false) {
    die( print_r( sqlsrv_errors(), true) );
}
else
{
    while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) )
    {
        $index = $index+1;
        echo $row['providerName']. ", City:  " . $row['providerCity'] . "<br><br>";
    }
}
echo $index;
sqlsrv_free_stmt($result);
?>