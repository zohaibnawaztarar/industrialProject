<?php
//connect database
$serverName = "zeno.computing.dundee.ac.uk";
$connectionOptions = array(
    "Database" => "ip19team8db",
    "Uid" => "ip19team8",
    "PWD" => "abc111abc111.."
);
//check if the file is json file
$allowedExts = array("json");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);     // 获取文件后缀名
if($extension != "json" || $_FILES["file"]["error"] > 0) die("文件上传错误");
//get data from json file
$json_string = file_get_contents($_FILES["file"]["tmp_name"]);
//translate json array to php array
$arr = array();
$arr = json_decode($json_string, true);
//get the length of php array
$num=count($arr);
//spilt php array into different columns
$list_dRGDefinition = array_column($arr, 'dRGDefinition');
$list_providerId = array_column($arr, 'providerId');
$list_providerName = array_column($arr, 'providerName');
$list_providerStreetAddress = array_column($arr, 'providerStreetAddress');
$list_providerCity = array_column($arr, 'providerCity');
$list_providerState = array_column($arr, 'providerState');
$list_providerZipCode = array_column($arr, 'providerZipCode');
$list_hospitalReferralRegionHRRDescription = array_column($arr, 'hospitalReferralRegionHRRDescription');
$list_totalDischarges = array_column($arr, 'totalDischarges');
$list_averageCoveredCharges = array_column($arr, 'averageCoveredCharges');
$list_averageTotalPayments = array_column($arr, 'averageTotalPayments');
$list_averageMedicarePayments = array_column($arr, 'averageMedicarePayments');
$list_year = array_column($arr, 'year');
//spilt dRGDefinition into dRGDeCode and dRGDescription
$spilt_dRGDefinition=array();
//insert new datas into database
$conn = sqlsrv_connect($serverName, $connectionOptions);
for($a = 0;$a <$num;$a++) {
    $spilt_dRGDefinition = explode(' - ', $list_dRGDefinition[$a]);
    $sql ="INSERT INTO dbo.terminalDB (dRGCode,dRGDescription,providerId,providerName,providerStreetAddress,providerCity,providerState,providerZipCode,hospitalReferralRegionHRRDescription,totalDischarges,averageCoveredCharges,averageTotalPayments,averageMedicarePayments,year) 
           VALUES ('$spilt_dRGDefinition[0]',
                '$spilt_dRGDefinition[1]',
                '$list_providerId[$a]',
                '$list_providerName[$a]',
                '$list_providerStreetAddress[$a]',
                '$list_providerCity[$a]',
                '$list_providerState[$a]',
                '$list_providerZipCode[$a]',
                '$list_hospitalReferralRegionHRRDescription[$a]',
                '$list_totalDischarges[$a]',
                '$list_averageCoveredCharges[$a]',
                '$list_averageTotalPayments[$a]',
                '$list_averageMedicarePayments[$a]',
                '$list_year[$a]')";
           $results = sqlsrv_query($conn,$sql);
//if( $results === false )   {die(print_r( sqlsrv_errors(), true));}
}
sqlsrv_free_stmt($results);
?>