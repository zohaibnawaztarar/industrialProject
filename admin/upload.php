<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Team 3">

    <title>Compare Care | Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
          crossorigin="anonymous">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
          crossorigin="anonymous">

    <!-- Custom CSS -->
    <link href="../css/dashboard.css" rel="stylesheet">

    <?php include_once "../php/db_connect.php"; ?>

</head>

<body>

<div id="id1" class="userDetails">
    <?php
    include_once("../php/db_connect.php");
    error_reporting(E_ALL & ~E_NOTICE); //Hide error messages (e.g. notices on homepage, will only be turned on when releasing website)
    $url = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
    $message = "REFERER is: " . parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
    //echo "<script type='text/javascript'>alert('$message');</script>";

    $userName = "";
    $encrypPass = "";
    $position = "customer";

    //Check website navigating from before allowing post requests only if ftom the same server as this
    if ($url != "") { //If the referee is not an about:blank page or been entered from the URL bar or a first entry
        if ((array_key_exists('userName', $_POST) && (htmlspecialchars($_POST['userName']) != $userName))) {
            $userName = htmlspecialchars($_POST['userName']);
        }
        if ((array_key_exists('encrypPass', $_POST) && (htmlspecialchars($_POST['encrypPass']) != $encrypPass))) {
            $encrypPass = htmlspecialchars($_POST['encrypPass']);
        }
    }

    //Destroy session if navigating
    session_start();
    //Reset session if coming from other website
    //Remove?//if(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) != $_SERVER['SERVER_NAME']){
    if ($url == "") { //If the referee is an about:blank page or been entered from the URL bar or a first entry
        //http://php.net/manual/en/function.session-destroy.php
        //Unset all of the session variables.
        $_SESSION = array();

        //If it's desired to kill the session, also delete the session cookie.
        //Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        //Finally, destroy the session.
        session_destroy();
        session_start();
    }

    if ($userName == "") {
        if ((isset($_SESSION['userName'])) && !empty($_SESSION['userName'])) {
            $userName = $_SESSION["userName"];
            if ($userName == " ") {
                $userName = "";
            }
        }
    } else {
        $_SESSION['userName'] = $userName;
    }

    if ($encrypPass == "") {
        if ((isset($_SESSION['encrypPass'])) && !empty($_SESSION['encrypPass'])) {
            $encrypPass = $_SESSION["encrypPass"];
            if ($encrypPass == " ") {
                $encrypPass = "";
            }
        }
    } else {
        $_SESSION['encrypPass'] = $encrypPass;
    }

    if ((isset($_SESSION['position'])) && !empty($_SESSION['position'])) {
        $position = $_SESSION['position'];
    }

    if ($userName == "") {
        if (isset($_COOKIE["userName"])) {
            $userName = $_COOKIE["userName"];
            if ($userName == " ") {
                $userName = "";
            }
        }
    }

    if ($encrypPass == "") {
        if (isset($_COOKIE["encrypPass"])) {
            $encrypPass = $_COOKIE["encrypPass"];
            if ($encrypPass == " ") {
                $encrypPass = "";
            }
        }
    }

    if ($position == "" || $position == "databaseFind") {
        if (isset($_COOKIE["position"])) {
            $position = $_COOKIE["position"];
            if ($position == " ") {
                $position = "";
            }
        }
    }

    ?>
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="../index.php"><i class="fas fa-ambulance"></i> Compare Care</a>
    <button class="navbar-toggler my-1" type="button" data-toggle="collapse" data-target="#navbarResponsive"
            aria-controls="navbarResponsive"
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="../index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../about.php">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../faq.php">FAQs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../contact-us.php">Contact Us</a>
            </li>
        </ul>
        <form class="navbar-form form-inline" action="../login.php" method="POST">
            <div id="id3" class="form-group">
                <input readonly="true" id="id3.1" class="form-control mr-2" type="text" placeholder="Username"
                       name="userName" required>
                <input readonly="true" id="id3.2" class="form-control mr-2" type="password" placeholder="Password"
                       name="uncrypPass" required>
                <input class="form-control" type="hidden" name="remember" value="checked">
                <button class="btn btn-outline-success login-btn my-2 my-sm-0 mr-2" type="submit">Log In</button>
                <button class="btn btn-outline-success login-btn my-2 my-sm-0 mr-2" type="register"
                        onclick="location.href='../register.php';">Register
                </button>
            </div>
        </form>
        <div id="id4" class="logout">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active account" href="#">
                        <?php
                        if ($userName != "") {
                            echo "$userName" . "'s";
                        }
                        ?> Account
                    </a>
                </li>
                <li class="nav-item">
                    <form action="../login.php" method="POST">
                        <input type='hidden' name="logout" value="true">
                        <button class="btn btn-outline-success login-btn my-2 my-sm-0 mr-2" type="submit">Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="header">
    <div class="container">
        <div class="row">
            <div class="text-center mx-auto mb-4">
                <h1 class="my-5">
                    <?php
                    if ($userName != "" and $position != "customer") {
                        echo "$userName" . "'s ";
                    }
                    ?>Upload File | Admin Dashboard
                </h1>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_POST['submit'])) {
    $action = $_POST['action1'];
    //connect database
    $serverName = "zeno.computing.dundee.ac.uk";
    $connectionOptions = array(
        "Database" => "ip19team8db",
        "Uid" => "ip19team8",
        "PWD" => "abc111abc111.."
    );

//time start
    $costBegin = microtime(true);
    $costBegin1 = microtime(true);
//get data from json file
    $allowedExts = array("json");//check if the file is json file
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);     // get extension of json file
    if ($extension != "json" || $_FILES["file"]["error"] > 0) die("error");
    $json_string = file_get_contents($_FILES["file"]["tmp_name"]);//open file
    $replace = str_replace("'","''",$json_string,$i);//chang [ ' ] to [ '' ]
    $arr = array();//translate json array to php array
    $arr = json_decode($replace, true);
    $num = count($arr);//get the length of php array

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
    $spilt_dRGDefinition=array();//spilt dRGDefinition into dRGDeCode and dRGDescription

    if ($action == 1) {//replace
        //delete old data
        $conn = sqlsrv_connect($serverName, $connectionOptions);
        $sql = "DELETE FROM dbo.insertDB";
        $results = sqlsrv_query($conn,$sql);
        sqlsrv_free_stmt($results);

//insert new data into database
        if (!empty($arr)) {
            for($i = 0; $i < $num/1000; $i++)
            {
                if($i < $num/1000-1)
                {
                    $sql = "INSERT INTO dbo.insertDB (dRGCode,dRGDescription,providerId,providerName,providerStreetAddress,providerCity,providerState,providerZipCode,hospitalReferralRegionHRRDescription,totalDischarges,averageCoveredCharges,averageTotalPayments,averageMedicarePayments,year) 
            VALUES ";
                    for ($a = 0; $a < 1000; $a++)
                    {

                        $spilt_dRGDefinition = explode(' - ', $list_dRGDefinition[1000*$i+$a]);
                        $itemStr = '( ';
                        $itemStr .= sprintf(" '%s','%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' ",
                            $spilt_dRGDefinition[0],
                            $spilt_dRGDefinition[1],
                            $list_providerId[1000*$i+$a],
                            $list_providerName[1000*$i+$a],
                            $list_providerStreetAddress[1000*$i+$a],
                            $list_providerCity[1000*$i+$a],
                            $list_providerState[1000*$i+$a],
                            $list_providerZipCode[1000*$i+$a],
                            $list_hospitalReferralRegionHRRDescription[1000*$i+$a],
                            $list_totalDischarges[1000*$i+$a],
                            $list_averageCoveredCharges[1000*$i+$a],
                            $list_averageTotalPayments[1000*$i+$a],
                            $list_averageMedicarePayments[1000*$i+$a],
                            $list_year[1000*$i+$a]);
                        $itemStr .= '),';
                        $sql .= $itemStr;
                    }
                    $sql = rtrim($sql, ",");//delete the last comma
                    $sql .= ";";//add the last semicolon
                    $sql .="\n";
                    $conn = sqlsrv_connect($serverName, $connectionOptions);
                    $results = sqlsrv_query($conn, $sql);
                    if( $results=== false ) die( print_r( sqlsrv_errors(), true));
                    sqlsrv_free_stmt($results);//end of connect
                }
                else
                {
                    $sql = "INSERT INTO dbo.insertDB (dRGCode,dRGDescription,providerId,providerName,providerStreetAddress,providerCity,providerState,providerZipCode,hospitalReferralRegionHRRDescription,totalDischarges,averageCoveredCharges,averageTotalPayments,averageMedicarePayments,year) 
                VALUES ";
                    for ($a = 0; $a < $num-1000*$i; $a++)
                    {
                        $spilt_dRGDefinition = explode(' - ', $list_dRGDefinition[1000*$i+$a]);
                        $itemStr = '( ';
                        $itemStr .= sprintf(" '%s','%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' ",
                            $spilt_dRGDefinition[0],
                            $spilt_dRGDefinition[1],
                            $list_providerId[1000*$i+$a],
                            $list_providerName[1000*$i+$a],
                            $list_providerStreetAddress[1000*$i+$a],
                            $list_providerCity[1000*$i+$a],
                            $list_providerState[1000*$i+$a],
                            $list_providerZipCode[1000*$i+$a],
                            $list_hospitalReferralRegionHRRDescription[1000*$i+$a],
                            $list_totalDischarges[1000*$i+$a],
                            $list_averageCoveredCharges[1000*$i+$a],
                            $list_averageTotalPayments[1000*$i+$a],
                            $list_averageMedicarePayments[1000*$i+$a],
                            $list_year[1000*$i+$a]);
                        $itemStr .= '),';
                        $sql .= $itemStr;
                    }
                    $sql = rtrim($sql, ",");//delete the last comma
                    $sql .= ";";//add the last semicolon
                    $sql .="\n";
                    $conn = sqlsrv_connect($serverName, $connectionOptions);
                    $results = sqlsrv_query($conn, $sql);
                    if( $results=== false ) die( print_r( sqlsrv_errors(), true));
                    sqlsrv_free_stmt($results);//end of connect
                }
            }
        }

//print time
        $costEnd = microtime(true);
        $cost = round($costEnd - $costBegin, 3);
        //var_dump($cost);

        echo "<div class=\"text-center mx-auto mb-4\">
            <hr><h3 class=\"text-centre\">Replaced All Procedures Successfully</h3>
            <form class=\"\" action=\"../admin/admin.php\" method=\"post\">
            <button class=\"btn btn-success btn-mini search-btn my-4\" type=\"submit\">
            <i class=\"fas fa-long-arrow-alt-left\"></i> Go Admin</button></form></div>";
    } else if ($action == 2) {//insert
        //delete ID
        $conn = sqlsrv_connect($serverName, $connectionOptions);
        $sql = "ALTER TABLE insertDB DROP COLUMN ID";
        $results = sqlsrv_query($conn, $sql);//end of connect

//add ID
        $conn = sqlsrv_connect($serverName, $connectionOptions);
        $sql = "ALTER TABLE insertDB ADD ID INT IDENTITY(1,1)";
        $results = sqlsrv_query($conn, $sql);
        if( $results=== false ) die( print_r( sqlsrv_errors(), true));
        sqlsrv_free_stmt($results);//end of connect

//insert data into database
        if (!empty($arr)) {
            for($i = 0; $i < $num/1000; $i++)
            {
                if($i < $num/1000-1)
                {
                    $sql = "INSERT INTO dbo.insertDB (dRGCode,dRGDescription,providerId,providerName,providerStreetAddress,providerCity,providerState,providerZipCode,hospitalReferralRegionHRRDescription,totalDischarges,averageCoveredCharges,averageTotalPayments,averageMedicarePayments,year) 
            VALUES ";
                    for ($a = 0; $a < 1000; $a++)
                    {

                        $spilt_dRGDefinition = explode(' - ', $list_dRGDefinition[1000*$i+$a]);
                        $itemStr = '( ';
                        $itemStr .= sprintf(" '%s','%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' ",
                            $spilt_dRGDefinition[0],
                            $spilt_dRGDefinition[1],
                            $list_providerId[1000*$i+$a],
                            $list_providerName[1000*$i+$a],
                            $list_providerStreetAddress[1000*$i+$a],
                            $list_providerCity[1000*$i+$a],
                            $list_providerState[1000*$i+$a],
                            $list_providerZipCode[1000*$i+$a],
                            $list_hospitalReferralRegionHRRDescription[1000*$i+$a],
                            $list_totalDischarges[1000*$i+$a],
                            $list_averageCoveredCharges[1000*$i+$a],
                            $list_averageTotalPayments[1000*$i+$a],
                            $list_averageMedicarePayments[1000*$i+$a],
                            $list_year[1000*$i+$a]);
                        $itemStr .= '),';
                        $sql .= $itemStr;
                    }
                    $sql = rtrim($sql, ",");//delete the last comma
                    $sql .= ";";//add the last semicolon
                    $sql .="\n";
                    $conn = sqlsrv_connect($serverName, $connectionOptions);
                    $results = sqlsrv_query($conn, $sql);
                    if( $results=== false ) die( print_r( sqlsrv_errors(), true));
                    sqlsrv_free_stmt($results);//end of connect
                }
                else
                {
                    $sql = "INSERT INTO dbo.insertDB (dRGCode,dRGDescription,providerId,providerName,providerStreetAddress,providerCity,providerState,providerZipCode,hospitalReferralRegionHRRDescription,totalDischarges,averageCoveredCharges,averageTotalPayments,averageMedicarePayments,year) 
                VALUES ";
                    for ($a = 0; $a < $num-1000*$i; $a++)
                    {
                        $spilt_dRGDefinition = explode(' - ', $list_dRGDefinition[1000*$i+$a]);
                        $itemStr = '( ';
                        $itemStr .= sprintf(" '%s','%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' ",
                            $spilt_dRGDefinition[0],
                            $spilt_dRGDefinition[1],
                            $list_providerId[1000*$i+$a],
                            $list_providerName[1000*$i+$a],
                            $list_providerStreetAddress[1000*$i+$a],
                            $list_providerCity[1000*$i+$a],
                            $list_providerState[1000*$i+$a],
                            $list_providerZipCode[1000*$i+$a],
                            $list_hospitalReferralRegionHRRDescription[1000*$i+$a],
                            $list_totalDischarges[1000*$i+$a],
                            $list_averageCoveredCharges[1000*$i+$a],
                            $list_averageTotalPayments[1000*$i+$a],
                            $list_averageMedicarePayments[1000*$i+$a],
                            $list_year[1000*$i+$a]);
                        $itemStr .= '),';
                        $sql .= $itemStr;
                    }
                    $sql = rtrim($sql, ",");//delete the last comma
                    $sql .= ";";//add the last semicolon
                    $sql .="\n";
                    $conn = sqlsrv_connect($serverName, $connectionOptions);
                    $results = sqlsrv_query($conn, $sql);
                    if( $results=== false ) die( print_r( sqlsrv_errors(), true));
                    sqlsrv_free_stmt($results);//end of connect
                }
            }
        }

//print time
        $costEnd1 = microtime(true);
        $cost1 = round($costEnd1 - $costBegin1, 3);
        //var_dump($cost1);
        echo "<br>";
        $costBegin2 = microtime(true);
        $conn = sqlsrv_connect($serverName, $connectionOptions);
        $sql = "DELETE FROM insertDB WHERE ID NOT IN (SELECT max(ID) FROM insertDB GROUP BY dRGCode,dRGDescription,providerId,year); ";//delete the same data
        $results = sqlsrv_query($conn, $sql);
        sqlsrv_free_stmt($results);//end of connect

//delete ID
        $conn = sqlsrv_connect($serverName, $connectionOptions);
        $sql = "ALTER TABLE insertDB DROP COLUMN ID";
        $results = sqlsrv_query($conn, $sql);
        sqlsrv_free_stmt($results);//end of connect

//print time
        $costEnd2 = microtime(true);
        $cost2 = round($costEnd2 - $costBegin2, 3);
        //var_dump($cost2);
        echo "<div class=\"text-center mx-auto mb-4\">
            <hr><h3 class=\"text-centre\">Inserted New Procedures Successfully</h3>
            <form class=\"\" action=\"../admin/admin.php\" method=\"post\">
            <button class=\"btn btn-success btn-mini search-btn my-4\" type=\"submit\">
            <i class=\"fas fa-long-arrow-alt-left\"></i> Go Admin</button></form></div>";
    }
} else echo '<div class="container">
    <div class="row">
        <div class="text-center mx-auto mb-4">
            <form class="navbar-form" action="upload.php" method="post" enctype="multipart/form-data">

                <label class="my-2" for="file"><strong>Filename：</strong></label>
                <input class="form-control my-2" style="height: 100%" type="file" name="file" id="file"><br><br>
                
                <input  type="radio"  name = "action1" value= 1 checked>
                <label  for="action1"><strong>Replace all procedures and insert all procedures into database</strong></label> <br>
             
                <br><input type="radio"  name = "action1" value= 2> <label for="action1"><strong> Check, delete duplicated procedures then insert new procedures</strong></label> </br>
                
                <input class="btn btn-success btn-mini search-btn my-4" style="padding: .500rem .79rem;" type="submit"
                       name="submit" value="Submit">
                <br><br>
            </form>
            <br><br>
            <form class="" action="../admin/admin.php" method="post">
                <button class="btn btn-success btn-mini search-btn my-4" type="submit"><i class="fas fa-long-arrow-alt-left"></i> Go Back</button>
            </form>
        </div>
    </div>
</div>';
?>


<br><br>


<br>

<br>


</body>

</div>
<br><br><br><br><br><br>


<!-- Footer -->
<footer class="py-3 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Compare Care 2019</p>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>

<script type="text/javascript">
    $(document).ready(function () {
        // executes when HTML-Document is loaded and DOM is ready
        console.log("document is ready");


        $(".card").hover(
            function () {
                $(this).addClass('shadow-lg').css('cursor', 'pointer');
            },
            function () {
                $(this).removeClass('shadow-lg');
            }
        );

        // document ready
    });
</script>

<div id="id8" class="showHideElements">
    <?php
    if (($userName != "") && ($encrypPass != "")) {
        // Show logout
        echo '<script type="text/javascript">';
        echo 'var x = document.getElementById("id4");';
        echo 'x.style.display = "block";';
        echo '</script>';
    } else {
        //Show Login
        echo '<script type="text/javascript">';
        echo 'var x = document.getElementById("id3");';
        echo 'x.style.display = "block";';
        echo 'document.getElementById("id3.1").readOnly = false;';
        echo 'document.getElementById("id3.2").readOnly = false;';
        echo '</script>';
    }
    ?>
</div>
</body>

</html>