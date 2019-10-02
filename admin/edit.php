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
                    ?>Edit / Delete Data | Admin Dashboard
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="mx-auto mb-4">

<script>
    function goBack() {
        window.history.back();
    }
</script>
<?php
include "../php/db_connect.php";
//get column name
$sql = "SELECT name FROM sys.columns WHERE object_id = OBJECT_ID('dbo.insertDB')";
$result = sqlsrv_query($conn, $sql);
$count_column = 0;
while($row=sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)){
    $column_name[$count_column] = $row['name'];
    $count_column++;
}
sqlsrv_free_stmt($result);
//check the submit
if (isset($_POST["Submit"])) {
    $dRGCode=$_POST['dRGCode'];
    $providerId= $_POST['providerId'];
    $year = $_POST['year'];
    $action = $_POST['action'];
    $sql = "SELECT * FROM insertDB WHERE dRGCode = ".$dRGCode." AND providerId = ".$providerId." AND year = ".
        $year;
    $result = sqlsrv_query($conn, $sql);
    //check if this procedure exists
    if($row=sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)){
        //show the procedure
        echo '<div class="text-center mx-auto mb-4">
            <hr><h2 class="text-centre">The procedure information</h2><hr></div>';
        echo '<li><strong>DRG Code : </strong>'.$dRGCode.'</li>
            <li><strong> DRG Description : </strong>'.$row['dRGDescription'].'</li><li><strong> Provider ID : </strong>'.
            $row['providerId'].'</li><li><strong> Provider Name : </strong>'.$row['providerName'].
            '</li><li><strong> Provider Street Address : </strong>'.$row['providerStreetAddress'].
            '</li><li><strong> Provider City : </strong>'.$row['providerCity'].'</li><li><strong> Provider State : </strong>'.
            $row['providerState'].'</li><li><strong> Provider Zip Code : </strong>'.$row['providerZipCode'].
            '</li><li><strong>Hospital Referral Region HRR Description : </strong>'.
            $row['hospitalReferralRegionHRRDescription'].'</li><li><strong> Total Discharges : </strong>'.$row['totalDischarges'].
            '</li><li><strong> Average Covered Charges : </strong>'.$row['averageCoveredCharges'].
            '</li><li><strong> Average Total Payments : </strong>'.$row['averageTotalPayments'].
            '</li><li><strong> Average Medicare Payments : </strong>'.$row['averageMedicarePayments'].
            '</li><li><strong> Year : </strong>'.$row['year'].'</li>';
        if($action == "1"){ //delete
            sqlsrv_free_stmt($result);
            echo '<div class="text-center mx-auto mb-4">
            <hr><h3 class="text-centre">Click button to confirm deleting this procedure</h3>
            <form action = "edit.php?dRGCode='.$dRGCode.'&providerId='.$providerId.'&year='. $year.'" method = "POST">
            <button class="btn btn-success btn-mini search-btn my-4" type="submit" name="ConfirmInfo">Confirm</button></form></div>';
        }
        else if($action == "2"){//update
            echo "<div class=\"text-center mx-auto mb-4\">
            <hr><h3 class=\"text-centre\">Choose the checkbox and enter information</h3><hr></div>";
            sqlsrv_free_stmt($result);
            //select the column that users want to update
            echo '<form action = "edit.php?dRGCode='.$dRGCode.'&providerId='.$providerId.'&year='.
                $year.'" method = "POST" ><table class = "table"><tr><th>Column</th><th>Column Data</th></tr><tr>';
            for($t = 0;$t < count($column_name); $t++){
                echo '<td><input type = "checkbox" name = "column[]" value = "'.$column_name[$t].'"> '
                    .$column_name[$t].'  </input></td>';
                if($t > 9 && $t < 13) echo '<td><input type = "number" step="0.000001" min="0" name = "column_info[]" /></td></tr>';
                else if($t == 0 || $t == 2 || $t == 7 || $t == 9 || $t == 13)
                    echo '<td><input type = "number" min="0" name = "column_info[]" /></td></tr>';
                else echo '<td><input type = "text" name = "column_info[]" /></td></tr>';
            }
            echo '</table><button class="btn btn-success btn-mini search-btn my-4" type="submit" name = "UpdateInfo">
                  Update</button></form>';
        }
    }else{

        echo "<div class=\"text-center mx-auto mb-4\">
            <hr><h3 class=\"text-centre\">Sorry, there is not such procedure in the data.</h3></div>";

    }
}else if(isset($_POST["ConfirmInfo"])){//confirm to delete the procedure
    $dRGCode = $_GET['dRGCode'];
    $providerId = $_GET['providerId'];
    $year = $_GET['year'];
    $sql = "DELETE FROM dbo.insertDB WHERE dRGCode = ".$dRGCode." AND providerId = ".$providerId." AND year = ".
        $year;
    $result = sqlsrv_query($conn, $sql);
    sqlsrv_free_stmt($result);
    echo "<div class=\"text-center mx-auto mb-4\">
            <hr><h2 class=\"text-centre\">Deleted successfully.</h2></div>";
}
else if(isset($_POST["UpdateInfo"])){//confirm to update the procedure
    //get information to update the procedure
    $column = $_POST['column'];
    $col_info = $_POST['column_info'];
    $dRGCode = $_GET['dRGCode'];
    $providerId = $_GET['providerId'];
    $year = $_GET['year'];
    $num = 0;
    if(is_array($column)) {
        for ($con = 0; $con < count($column); $con++) {
            $temp_col = $column[$con];
            //search the input fields which the check boxes are chosen
            for($find_num = 0; $find_num < count($column_name); $find_num++){
                if($column_name[$find_num] == $temp_col){//check if the input field is empty
                    if(!$col_info[$find_num]){
                        echo "<div class=\"text-center mx-auto mb-4\">
                        <hr><h4 class=\"text-centre\">The input field ".$temp_col." is empty!</h4></div>";
                        $state = false;
                    }else{//update the procedure
                        $sql = "UPDATE insertDB SET ".$temp_col." = "."'".$col_info[$find_num]."' WHERE dRGCode = ".$dRGCode." AND providerId = ".$providerId." AND year = ".$year;
                        $result = sqlsrv_query($conn, $sql);
                        $state = true;
                    }
                }
            }
        }
    }
    if($state == true)//check if the procedure is updated
        echo "<div class=\"text-center mx-auto mb-4\"><hr><h3 class=\"text-centre\">Updated successfully</h3></div>";
    else
        echo '<button class="btn btn-success btn-mini search-btn my-4" onclick="goBack()">
                        <i class="fas fa-long-arrow-alt-left"></i> Go Back</button>';;
}
else{//get the basic information of the procedure
    $sql = "SELECT year FROM dbo.newDB GROUP BY year ORDER BY year";
    $result = sqlsrv_query($conn, $sql);
    echo '<form class="navbar-form" action = "edit.php" method = "POST">
        <div class="form-group text-left">
        <br><h2 class="text-center">Please enter the details below to find the data you want to update</h2><hr>
                <label class="text-left" for="get_dRGCode">DRG Code: </label>
                <input required class="form-control my-2" type="text" name="dRGCode" placeholder="Enter DRG Code">
                <br>
                <label for="get_providerId">Provider ID: </label>
                <input required class="form-control my-2" type="text" name="providerId" placeholder="Enter Provider Id">
                <br>
                <label for="get_year">Year: </label>
                <select required class="form-control my-2" name="year">';
    while($row=sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)){
        echo '<option value = "'.$row['year'].'">'.$row['year'].'</option>';
    }
    echo '</select></div><br>
        <label for="get_action">Action: </label>
        <select class="form-control my-2" name="action">
        <option required value = "0" disabled selected hidden>Please select the action</option>
        <option required value = 1>Delete</option>
        <option required value = 2>Update</option></select>
        <p><input class="btn btn-success btn-mini search-btn my-4" name="Submit" id="Submit" value="Submit" type="Submit" /></p>
    </form>';
}

?>
<br><br>
<form class="" action="../admin/admin.php" method="post">
    <button class="btn btn-success btn-mini search-btn my-4" type="submit"><i class="fas fa-long-arrow-alt-left"></i> Go Admin</button>
</form>
        </div>
    </div>
</div>


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