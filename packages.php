<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Compare Care | Packages</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
          crossorigin="anonymous">
    <!-- Custom CSS -->
    <link href="css/packages.css" rel="stylesheet">


    <?php
    error_reporting(E_ALL & ~E_NOTICE); //Hide error messages (e.g. notices on homepage, will only be turned on when releasing website)
    $url = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);

    //This breaks the GETs for some reason?
    //if($url != "") { //If the referee is not an about:blank page or been entered from the URL bar or a first entry
    $state = "";
    $zipCode = "";
    $dRGCode = "";
    $order = "price_asc";

    if (isset($_GET['state'])) {
        $state = $_GET['state'];
    }

    if (isset($_GET['zipCode'])) {
        $zipCode = $_GET['zipCode'];
    }

    if (isset($_GET['dRGCode'])) {
        $dRGCode = $_GET['dRGCode'];
    }

    if (isset($_GET['order'])) {
        $order = $_GET['order'];
    }

    //}
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
    <a class="navbar-brand" href="index.php"><i class="fas fa-ambulance"></i> Compare Care</a>
    <button class="navbar-toggler my-1" type="button" data-toggle="collapse" data-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
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
            <li class="nav-item active">
                <a class="nav-link" href="#">Packages<span class="sr-only">(current)</span></a>
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
                       name="userName"
                       required>
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
                        <?php echo $userName ?>'s Account</a>
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


<div class="place">
    <div class="container">
        <div class="row">
            <div class="text-center mx-auto mb-4">
                <h1 class="mt-5">Search again?</h1>
                <hr/>
                <form class="form-inline mb-5" action="packages.php" method="GET">
                    <input required type="text" placeholder="DRG Code or Keywords" name="dRGCode"
                           class="form-control my-2">
                    <select class="form-control m-1 mb-2 mx-2" name="state">
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
                    <input required type="text" placeholder="Zip Code" name="zipCode" class="form-control my-2">
                    <button class="btn btn-success search-btn mx-1 m-auto" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <form action="packages.php" method="GET">
        <input type="hidden" name="state" value="<?php echo $state; ?>"/>
        <input type="hidden" name="zipCode" value="<?php echo $zipCode; ?>"/>
        <input type="hidden" name="dRGCode" value="<?php echo $dRGCode; ?>"/>
        <div class="row my-3 text-center sorters">
            <div class="col-lg-3">
                <button class="btn search-btn mx-1 m-auto" value="price_desc" name="order" type="submit"><i
                            class="fas fa-sort-amount-down"></i>
                    Sort by Price DESC
                </button>
            </div>
            <div class="col-lg-3">
                <button class="btn search-btn mx-1 m-auto" value="price_asc" name="order" type="submit"><i
                            class="fas fa-sort-amount-up"></i>
                    Sort by Price ASC
                </button>
            </div>
            <div class="col-lg-3">
                <button class="btn search-btn mx-1 m-auto" value="distance_asc" name="order" type="submit"><i
                            class="fas fa-sort-amount-down"></i>
                    Sort by Closest Distance
                </button>
            </div>
            <div class="col-lg-3">
                <button class="btn search-btn mx-1 m-auto" value="distance_desc" name="order" type="submit"><i
                            class="fas fa-sort-amount-up"></i>
                    Sort by Furthest Distance
                </button>
            </div>
        </div>
        <div class="row my-3 text-center sorters">
            <div class="col-lg-3">
                <button class="btn search-btn mx-1 m-auto" value="city_desc" name="order" type="submit"><i
                            class="fas fa-sort-amount-down"></i>
                    Sort by City Name DESC
                </button>
            </div>
            <div class="col-lg-3">
                <button class="btn search-btn mx-1 m-auto" value="city_asc" name="order" type="submit"><i
                            class="fas fa-sort-amount-up"></i>
                    Sort by City Name ASC
                </button>
            </div>
        </div>
    </form>
    <hr/>
    <!-- Card Generation -->

    <!-- Get list of procedures for a given hospital-->
    <?php
    include_once("php/db_connect.php");

    $sql = "SELECT dRGDescription, providerName, providerCity, averageTotalPayments, providerId FROM dbo.newDB WHERE providerZipCode LIKE ? AND dRGCode=? AND year=2017";

    if (!empty($order)) {
        if ($order == "price_desc") {
            $sql .= " ORDER BY averageTotalPayments DESC";
        } else if ($order == "price_asc") {
            $sql .= " ORDER BY averageTotalPayments ASC";
        } else if ($order == "distance_desc") {
            //change to distance!!!!
            $sql .= " ORDER BY averageTotalPayments DESC";
        } else if ($order == "distance_asc") {
            //change to distance!!
            $sql .= " ORDER BY averageTotalPayments ASC";
        } else if ($order == "city_desc") {
            $sql .= " ORDER BY providerCity DESC";
        } else if ($order == "city_asc") {
            $sql .= " ORDER BY providerCity ASC";
        }
    }

    # get first 2 digits of the zipcode given by the user, % is the regular expression for SQL (any number of chars can follow)
    $zipCodeDigits = substr($zipCode, 0, 2) . "%";
    $params = array($zipCodeDigits, $dRGCode);
    $result = sqlsrv_query($conn, $sql, $params);

    $rows_count = 0;

    if ($result == FALSE) {
        echo '<h1 class="display-3 pb-5 text-center">Databse Query Error!</h1>';
        die(print_r(sqlsrv_errors(), true));
    } else {
        if (sqlsrv_has_rows($result) == 0) {
            echo '<h1 class="display-3 pb-5 text-center">No results found!</h1>';
            echo '<h1 class="display-3 pb-5 text-center"><br><br><br></h1>';
        } else {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $rows_count++;
                ?>
                <div class="card my-3">
                    <div class="row no-gutters">
                        <div class="col">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <?php echo $row['providerName']; ?><br>
                                    <?php echo $row['dRGDescription']; ?>
                                </h4>
                                <h3 class="card-title mb-2">
                                    $
                                    <?php echo round($row['averageTotalPayments']); ?>
                                </h3>
                                <p class="card-text">
                                    <?php echo $row['providerCity']; ?>
                                </p>
                                <form action="hospitalDetails.php" method="GET">
                                    <input type='hidden' name="providerId" value="<?php echo $row['providerId']; ?>">
                                    <button class="btn btn-success buy-btn mx-1 m-auto" type="buy">
                                        <i class="fas fa-info-circle"></i> View more information
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
        }

        sqlsrv_free_stmt($result);

    } ?>

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
                $(this).addClass('shadow-lg').css('cursor', 'pointer');
            },
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