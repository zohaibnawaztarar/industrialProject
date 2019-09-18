<?php
$serverName = "zeno.computing.dundee.ac.uk";
$connectionOptions = array(
    "Database" => "ip19team8db",
    "Uid" => "ip19team8",
    "PWD" => "abc111abc111.."
);
//Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
if($conn)
    echo "Connected!"
?>