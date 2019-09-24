<?php
//连接数据库
$serverName = "zeno.computing.dundee.ac.uk";
$connectionOptions = array(
    "Database" => "ip19team8db",
    "Uid" => "ip19team8",
    "PWD" => "abc111abc111.."
);

$json_string = file_get_contents("data.json");//解析本地json文件

//var_dump(json_decode($json_string, true));//打印json转化后的php数组

foreach($dRGDefinition as $x=>$x_value)
{
 echo "Value=" . $x_value;
 echo "<br>";
}
for ($i=1; $i<=3; $i++)
{
 echo $dRGDefinition[$i];
}


//向数据库添加新数据
$conn = sqlsrv_connect($serverName, $connectionOptions);
$sql ="INSERT INTO dbo.task (dRGDefinition,providerId,providerName,providerStreetAddress,providerCity,providerState,providerZipCode,hospitalReferralRegionHRRDescription,totalDischarges,averageCoveredCharges,averageTotalPayments,averageMedicarePayments,year) 
VALUES (2,2,2,2,2,2,2,2,2,2,2,2,2)";
$results = sqlsrv_query($conn, $sql);
sqlsrv_free_stmt( $results);




?>

