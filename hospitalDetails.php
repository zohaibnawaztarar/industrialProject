<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Compare Care | Details</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
          crossorigin="anonymous">
    <!-- Custom CSS -->
    <link href="css/hospitalDetails.css" rel="stylesheet">

    <script src="js/print.js"></script>

    <script src="https://d3js.org/d3.v5.js"></script>
    <?php
    error_reporting(E_ALL & ~E_NOTICE); //Hide error messages (e.g. notices on homepage, will only be turned on when releasing website)
    $url = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);

    //This breaks the GETs for some reason?
    //if($url != "") { //If the referee is not an about:blank page or been entered from the URL bar or a first entry
    $providerId = "";
    $dRGCode = "";

    if (isset($_GET['dRGCode'])) {
        $dRGCode = $_GET['dRGCode'];
    }

    if (isset($_GET['providerId'])) {
        $providerId = $_GET['providerId'];
    }

    $userName = "";
    $encrypPass = "";
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
        // Unset all of the session variables.
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
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
    ?>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#"><i class="fas fa-ambulance"></i> Compare Care</a>
    <button class="navbar-toggler my-1" type="button" data-toggle="collapse" data-target="#navbarResponsive"
            aria-controls="navbarResponsive"
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.php">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="faq.php">FAQs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact-us.php">Contact Us</a>
            </li>
        </ul>
        <form class="navbar-form form-inline" action="login.php" method="POST">
            <div id="id3" class="form-group">
                <input readonly="true" id="id3.1" class="form-control mr-2" type="text" placeholder="Username"
                       name="userName" required>
                <input readonly="true" id="id3.2" class="form-control mr-2" type="password" placeholder="Password"
                       name="uncrypPass" required>
                <input class="form-control" type="hidden" name="remember" value="checked">
                <button class="btn btn-outline-success login-btn my-2 my-sm-0 mr-2" type="submit">Log In</button>
                <button class="btn btn-outline-success login-btn my-2 my-sm-0 mr-2" type="register"
                        onclick="location.href='register.php';">Register
                </button>
            </div>
        </form>
        <div id="id4" class="logout">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link account" href="dashboard.php">
                        <?php
                        if ($userName != "") {
                            echo "$userName" . "'s";
                        }
                        ?>
                        Account</a>
                </li>
                <li class="nav-item">
                    <form action="login.php" method="POST">
                        <input type='hidden' name="logout" value="true">
                        <button class="btn btn-outline-success login-btn my-2 my-sm-0 mr-2" type="submit">Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Header with Background Image -->
<div class="place">
    <div class="container">
        <div class="row">
            <div class="text-center mx-auto mb-4">
                <h1 class="mt-5">Search again?</h1>
                <hr/>
                <form class="form-inline mb-5" action="index.php" method="GET">
                    <input required type="text" placeholder="DRG Code or Keywords" name="dRGCode"
                           class="form-control my-2">
                    <select class="form-control my-2 m-1 mb-2 mx-2" name="state">
                        <option value="? OR 1=1" disabled selected>State</option>
                        <option value="AL">Alabama</option>
                        <option value="AK">Alaska</option>
                        <option value="AZ">Arizona</option>
                        <option value="AR">Arkansas</option>
                        <option value="CA">California</option>
                        <option value="CO">Colorado</option>
                        <option value="CT">Connecticut</option>
                        <option value="DE">Delaware</option>
                        <option value="DC">District Of Columbia</option>
                        <option value="FL">Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="HI">Hawaii</option>
                        <option value="ID">Idaho</option>
                        <option value="IL">Illinois</option>
                        <option value="IN">Indiana</option>
                        <option value="IA">Iowa</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="ME">Maine</option>
                        <option value="MD">Maryland</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MI">Michigan</option>
                        <option value="MN">Minnesota</option>
                        <option value="MS">Mississippi</option>
                        <option value="MO">Missouri</option>
                        <option value="MT">Montana</option>
                        <option value="NE">Nebraska</option>
                        <option value="NV">Nevada</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NM">New Mexico</option>
                        <option value="NY">New York</option>
                        <option value="NC">North Carolina</option>
                        <option value="ND">North Dakota</option>
                        <option value="OH">Ohio</option>
                        <option value="OK">Oklahoma</option>
                        <option value="OR">Oregon</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="SD">South Dakota</option>
                        <option value="TN">Tennessee</option>
                        <option value="TX">Texas</option>
                        <option value="UT">Utah</option>
                        <option value="VT">Vermont</option>
                        <option value="VA">Virginia</option>
                        <option value="WA">Washington</option>
                        <option value="WV">West Virginia</option>
                        <option value="WI">Wisconsin</option>
                        <option value="WY">Wyoming</option>
                    </select>
                    <button class="btn btn-success search-btn mx-1 m-2" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <form action="packages.php" method="GET">
        <input type="hidden" name="providerId" value="<?php echo $providerId; ?>"/>
        <input type="hidden" name="dRGCode" value="<?php echo $dRGCode; ?>"/>
    </form>

    <!-- Get hospital details -->
    <?php
    include_once("php/db_connect.php");
    $sql = "SELECT * FROM dbo.newDB WHERE providerId=? AND dRGCode=? AND year=?";

    $params = array($providerId, $dRGCode, 2017);
    $resultMain = sqlsrv_query($conn, $sql, $params);

    $params = array($providerId, $dRGCode, 2016);
    $result2016 = sqlsrv_query($conn, $sql, $params);

    $params = array($providerId, $dRGCode, 2015);
    $result2015 = sqlsrv_query($conn, $sql, $params);

    //var address;
    $rows_count = 0;

    if ($resultMain == FALSE) {
        echo '<h1 class="display-3 pb-5 text-center">Databse Query Error!</h1>';
        die(print_r(sqlsrv_errors(), true));
    } else {
        if (sqlsrv_has_rows($resultMain) == 0) {
            echo '<h1 class="display-3 pb-5 text-center">No results found! Something went wrong here, there should be results.</h1>';
            echo '<h1 class="display-3 pb-5 text-center"><br><br><br></h1>';
        } else {
            while ($row = sqlsrv_fetch_array($resultMain, SQLSRV_FETCH_ASSOC)) {
                $rows_count++;
                if($rows_count < 2)
                    $address = $row['providerName']." ".$row['providerStreetAddress'];
                if (sqlsrv_has_rows($result2016) == 0) {
                    $result2016_empty = true;
                } else {
                    $row2016 = sqlsrv_fetch_array($result2016, SQLSRV_FETCH_ASSOC);
                    $result2016_empty = false;
                }
                if (sqlsrv_has_rows($result2015) == 0) {
                    $result2015_empty = true;
                } else {
                    $row2015 = sqlsrv_fetch_array($result2015, SQLSRV_FETCH_ASSOC);
                    $result2015_empty = false;
                }
                ?>

                <div class="card my-3">
                    <div class="row no-gutters">
                        <div class="col">
                            <div class="card-body">
                                <h2 class="card-title">
                                    <?php echo ucwords(strtolower($row['providerName'])); ?><br>
                                </h2>
                                <h4 class="card-title mb-2 text-muted">
                                    <?php echo ucwords(strtolower($row['dRGDescription'])); ?>
                                    (DRG Code: <?php echo ucwords(strtolower($row['dRGCode'])); ?>)
                                </h4>
                                <h5 class="card-title mb-2">
                                    Address
                                </h5>
                                <p class="card-text">
                                    <?php echo ucwords(strtolower($row['providerStreetAddress'])); ?><br>
                                    <?php echo ucwords(strtolower($row['providerCity'])); ?><br>
                                    <?php echo $row['providerState']; ?><br>
                                </p>
                                <button class="btn btn-success btn-mini search-btn my-4 hidden-print"
                                        onclick="myFunction()"><span class="glyphicon glyphicon-print"
                                                                     aria-hidden="true"></span> Print
                                </button>
                            </div>
                        </div>
                        <div id="miniMap" style="width:450px; height: 350px;"></div>
                        <script>
                            var map;
                            var grocoder;
                            function initMap() {
                                //search by address
                                geocoder = new google.maps.Geocoder();
                                var address_1= "<?php echo $address?>";
                                geocoder.geocode({'address':address_1},function(results,status){
                                    if(status==google.maps.GeocoderStatus.OK){
                                        map = new google.maps.Map(document.getElementById('miniMap'), {
                                            center: results[0].geometry.location,
                                            zoom: 13
                                        });
                                        var marker = new google.maps.Marker({position: results[0].geometry.location, map: map});
                                    }else{
                                        alert("fail");
                                    }
                                })
                            }
                        </script>
                        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCEOf66YDCHpSc9OhGNJHhejaGG9DArF-U&callback=initMap" async
                                defer>
                        </script>
                    </div>
                </div>
                <div class="container">
                    <div class="card-deck mb-3 text-center">
                        <div class="card mb-4 box-shadow">
                            <div class="card-header">
                                <h4 class="my-0 font-weight-normal">Avg. Total Payments</h4>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title">~ $<?php echo round($row['averageTotalPayments']) ?><small
                                            class="text-muted"> in 2017</small></h1>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li>
                                        <?php
                                        if ($result2016_empty == true) {
                                            echo "No data for ";
                                        } else {
                                            echo "~ $" . round($row2016['averageTotalPayments']) . " in ";
                                        }
                                        ?>
                                        2016
                                    </li>
                                    <li>
                                        <?php
                                        if ($result2015_empty == true) {
                                            echo "No data for ";
                                        } else {
                                            echo "~ $" . round($row2015['averageTotalPayments']) . " in ";
                                        }
                                        ?>
                                        2015
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card mb-4 box-shadow">
                            <div class="card-header">
                                <h4 class="my-0 font-weight-normal">Covered Charges</h4>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title">~ $<?php echo round($row['averageCoveredCharges']) ?><small
                                            class="text-muted"> in 2017</small></h1>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li>
                                        <?php
                                        if ($result2016_empty == true) {
                                            echo "No data for ";
                                        } else {
                                            echo "~ $" . round($row2016['averageCoveredCharges']) . " in ";
                                        }
                                        ?>
                                        2016
                                    </li>
                                    <li>
                                        <?php
                                        if ($result2015_empty == true) {
                                            echo "No data for ";
                                        } else {
                                            echo "~ $" . round($row2015['averageCoveredCharges']) . " in ";
                                        }
                                        ?>
                                        2015
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card mb-4 box-shadow">
                            <div class="card-header">
                                <h4 class="my-0 font-weight-normal">Medicare Payments</h4>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title">~ $<?php echo round($row['averageMedicarePayments']) ?><small
                                            class="text-muted"> in 2017</small></h1>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li>
                                        <?php
                                        if ($result2016_empty == true) {
                                            echo "No data for ";
                                        } else {
                                            echo "~ $" . round($row2016['averageMedicarePayments']) . " in ";
                                        }
                                        ?>
                                        2016
                                    </li>
                                    <li>
                                        <?php
                                        if ($result2015_empty == true) {
                                            echo "No data for ";
                                        } else {
                                            echo "~ $" . round($row2015['averageMedicarePayments']) . " in ";
                                        }
                                        ?>
                                        2015
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
        }

        sqlsrv_free_stmt($resultMain);
        sqlsrv_free_stmt($result2016);
        sqlsrv_free_stmt($result2015);

    } ?>

    <!-- Other procedures listing -->
    <div class="container">

        <button class="btn btn-success search-btn mx-1 m-2" type="button" data-toggle="collapse"
                data-target="#collapseProcList" aria-expanded="false" aria-controls="collapseExample">
            Other procedures offered by this hospital
        </button>
        <div class="collapse" id="collapseProcList">
            <div class="card card-body">
                <div class="row">
                    <?php
                    $sqlProcList = "SELECT dRGCode, dRGDescription, providerId FROM dbo.newDB WHERE providerId=? AND year=2017 ORDER BY dRGDescription";
                    $params = array($providerId);
                    $resultProcList = sqlsrv_query($conn, $sqlProcList, $params);

                    if ($resultProcList == FALSE) {
                        echo '<h1 class="display-3 pb-5 text-center">Database Query Error!</h1>';
                        die(print_r(sqlsrv_errors(), true));
                    } else {
                        if (sqlsrv_has_rows($resultProcList) == 0) {
                            echo '<h1 class="display-3 pb-5 text-center">This hospital offers no other procedures.</h1>';
                            echo '<h1 class="display-3 pb-5 text-center"><br></h1>';
                        } else {
                            while ($row = sqlsrv_fetch_array($resultProcList, SQLSRV_FETCH_ASSOC)) {
                                ?>

                                <div class="col-md-4">
                                    <a href="hospitalDetails.php?providerId=<?php echo $providerId; ?>&dRGCode=<?php echo $row['dRGCode'] ?>">
                                        <?php echo ucwords(strtolower($row['dRGDescription'])) ?>
                                    </a>
                                </div>


                            <?php }
                        }
                        sqlsrv_free_stmt($resultProcList);
                    } ?>
                </div>
            </div>
        </div>
        <br><br>
    </div>
</div>

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
                $(this).removeClass('shadow-lg');
            }
        );

        // document ready
    });
</script>

<div class="showHideElements">
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