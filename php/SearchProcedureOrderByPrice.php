<!-- Get list of hospitals ordered by price for a given procedure and location area -->
<?php
include 'db_connect.php';

$sql = "SELECT dRGDescription, providerName, providerCity, averageTotalPayments FROM dbo.newDB WHERE providerZipCode LIKE ? AND dRGCode=? ORDER BY averageTotalPayments;";
# 10 here is the first 2 digits of the zipcode given by the user and % is the regular expression (any number of chars can follow)
$zipCodeDigits = '10%';
$dRGCode = 40;
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
        echo print_r($row) . "<br><br>";
    }
}
echo $index;
sqlsrv_free_stmt($result);
?>