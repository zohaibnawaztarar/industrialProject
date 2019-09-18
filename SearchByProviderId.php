<!-- Get list of procedures for a given hospital-->
<?php
include 'php/db_connect.php';

$sql = 'SELECT * FROM dbo.newDB WHERE providerId=?';
$params = array(330304);
$result = sqlsrv_query($conn, $sql, $params);

if( $result === false) {
    die( print_r( sqlsrv_errors(), true) );
}
else
{
    while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) )
    {
        echo var_dump($row['dRGDescription']) . "<br>";
    }
}
sqlsrv_free_stmt( $result);
?>