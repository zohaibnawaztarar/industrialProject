<!-- Get list of procedures for a given hospital-->
<?php
include './db_connect.php';

$sql = 'SELECT * FROM dbo.newDB WHERE providerId=?';
$providerId = 330304;
$params = array($providerId);
$result = sqlsrv_query($conn, $sql, $params);

if( $result == false) {
    die( print_r( sqlsrv_errors(), true) );
}
else
{
    while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) )
    {
        echo $row['dRGDescription'] . "<br>";
    }
}
sqlsrv_free_stmt( $result);
?>