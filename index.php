<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Team 8">

    <title>Compare Care</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
          crossorigin="anonymous">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
          crossorigin="anonymous">

    <!-- Custom CSS -->
    <link href="css/home.css" rel="stylesheet">

    <script src="https://d3js.org/d3.v5.js"></script>
</head>

<body>

<div id="id1" class="userDetails">
    <?php
    error_reporting(E_ALL & ~E_NOTICE); //Hide error messages (e.g. notices on homepage, will only be turned on when releasing website)
    $url = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
    $message = "REFERER is: " . parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
    //echo "<script type='text/javascript'>alert('$message');</script>";
    //This breaks the GETs for some reason?
    //if($url != "") { //If the referee is not an about:blank page or been entered from the URL bar or a first entry
    $state = "";
    $zipCode = "";
    $dRGInput = "";
    $order = "price_asc";
    $priceMax = "0";
    $priceMin = "0";

    if (isset($_GET['state'])) {
        $state = $_GET['state'];
    }

    if (isset($_GET['zipCode'])) {
        $zipCode = $_GET['zipCode'];
    }

    if (isset($_GET['dRGInput'])) {
        $dRGInput = $_GET['dRGInput'];
    }

    if (isset($_POST['order'])) {
        $order = $_POST['order'];
    }

    if (isset($_POST['priceMin'])) {
        $priceMin = $_POST['priceMin'];
    }

    if (isset($_POST['priceMax'])) {
        $priceMax = $_POST['priceMax'];
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
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#"><i class="fas fa-ambulance"
                                        title="Compare care logo. Vehicle with medical cross symbol on side"></i>
        Compare Care</a>
    <button class="navbar-toggler my-1" type="button" data-toggle="collapse" data-target="#navbarResponsive"
            aria-controls="navbarResponsive"
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home<span class="sr-only">(current)</span></a>
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
                       name="userName" required aria-label="Enter your username">
                <input readonly="true" id="id3.2" class="form-control mr-2" type="password" placeholder="Password"
                       name="uncrypPass" required aria-label="Enter your Password">
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
<header class="header" role="banner">

    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="float-lg-left text-center">
                    <br><br>
                    <h1 class="mt-5">Find the best procedure</h1>
                    <hr/>
                    <form action="index.php" method="GET">
                        <div class="form-group m-0" role="search">
                            <input required type="text" placeholder="DRG Code or Keyword" name="dRGInput" class="form-control my-2" aria-label="DRG Code or keywords" value="<?php echo isset($_GET['dRGInput']) ? $_GET['dRGInput'] : '' ?>" >
                            <select required class="form-control my-2" name="state" aria-label="State selection">
                                <option value="" disabled selected hidden>Select State</option>
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

                            <input required type="number" placeholder="Zip Code" name="zipCode" class="form-control my-2" aria-label="Zip Code" value="<?php echo isset($_GET['zipCode']) ? $_GET['zipCode'] : '' ?>" >

                        </div>

                        <div class="form-group m-0">
                            <button class="btn btn-success btn-mini search-btn my-4" type="submit">Search</button>
                        </div>
                    </form>

                </div>
            </div>
            <div class="col-lg-6">
                <div class="text-center">

                    <div id="map" alt="Map used to display search results" title="Google Map"></div>
                </div>

            </div>
        </div>
    </div>

</header>


<!-- Page Content -->
<!-- --------------------------------------------------------------------- -->


<script>
    var map, infoWindow;
    var geocoder;
    var userPos;
    var haveUserLocation;

    var customLabel = {
        label: 'R'
    };

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: new google.maps.LatLng(37.09024, -95.712891),
            zoom: 3

        });

        geocoder = new google.maps.Geocoder();
        infoWindow = new google.maps.InfoWindow;


        // Try HTML5 geolocation.
        if (navigator.geolocation) {
            console.log("1")
            navigator.geolocation.getCurrentPosition(function (position) {
                userPos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                if("<?php echo !empty($_GET); ?>")
                {

                }
                else {
                    infoWindow.setPosition(userPos);
                    infoWindow.setContent('location found');
                    infoWindow.open(map);
                    map.setCenter(userPos);
                    map.setZoom(8); //If location is found, increase zoom
                }


                haveUserLocation = true;
            }, function () {
                handleLocationError(true, infoWindow, map.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            //handleLocationError(false, infoWindow, map.getCenter());
            //haveUserLocation = false;
            //
            //d3.csv("US_ZipCode_2018.csv").then(function(data) {
            //
            //    console.log("test")
            //    for (var i = 0; i < 33145; i++) {
            //        if (data[i].ZIP == "<?php //echo $_GET['zipCode']; ?>//") {
            //            userPos = {
            //                lat: parseFloat(data[i].LAT),
            //                lng: parseFloat(data[i].LNG)
            //            };
            //
            //            console.log("User Pos: " + userPos)
            //        }
            //    }
            //});

        }

        console.log("2")

        if (!haveUserLocation) {

            haveUserLocation = true;

            d3.csv("US_ZipCode_2018.csv").then(function (data) {

                console.log("test")
                for (var i = 0; i < 33145; i++) {
                    if (data[i].ZIP == "<?php echo $_GET['zipCode']; ?>") {
                        userPos = {
                            lat: parseFloat(data[i].LAT),
                            lng: parseFloat(data[i].LNG)
                        };
                        console.log("User Pos: " + userPos.lat)
                        return;

                    }
                }
            });
        }

        <?php
        include "./php/db_connect.php";
        if (empty($dRGInput) or empty($state)) {

        } else {
            function isDRGCode($dRGInput)
            {
                if (preg_match('/^[0-9]{1,3}$/', $dRGInput)) {
                    return true;
                } else {
                    return false;
                }
            }

            if (isDRGCode($dRGInput)) {
                $sql = "SELECT dRGDescription, providerName, providerCity, averageTotalPayments, providerId, providerStreetAddress, providerZipCode FROM dbo.newDB WHERE providerZipCode LIKE ? AND dRGCode=? AND year=2017";
                # get first 2 digits of the zipcode given by the user, % is the regular expression for SQL (any number of chars can follow)
                $zipCodeDigits = substr($zipCode, 0, 2) . "%";
                $params = array($zipCodeDigits, $dRGInput);
            } else {
                $sql = "SELECT * FROM dbo.newDB WHERE providerZipCode LIKE ? AND dRGDescription LIKE ? AND year=2017";
                # get first 2 digits of the zipcode given by the user, % is the regular expression for SQL (any number of chars can follow)
                $zipCodeDigits = substr($zipCode, 0, 2) . "%";
                $params = array($zipCodeDigits, "%" . $dRGInput . "%");
            }

            //check if valid price range given
            if ($priceMin < $priceMax) {
                //priceMax will be set as value at this point to pass the operator, but priceMin can be empty still
                if (empty($priceMin)) {
                    $priceMin = 0;
                }
                $sql .= " AND averageTotalPayments BETWEEN " . $priceMin . " AND " . $priceMax;
            }

            if (!empty($order)) {
                if ($order == "price_desc") {
                    $sql .= " ORDER BY averageTotalPayments DESC";
                } else if ($order == "price_asc") {
                    $sql .= " ORDER BY averageTotalPayments ASC";
                } else if ($order == "distance_desc") {
                    //change to distance!!!!

                } else if ($order == "distance_asc") {
                    //change to distance!!
                    $sql .= " ORDER BY averageTotalPayments ASC";
                } else if ($order == "city_desc") {
                    $sql .= " ORDER BY providerCity DESC";
                } else if ($order == "city_asc") {
                    $sql .= " ORDER BY providerCity ASC";
                }
            }
            $result = sqlsrv_query($conn, $sql, $params);

            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                if (empty($row['dRGCode'])) {
                    $dRGCode = $dRGInput;
                } else {
                    $dRGCode = $row['dRGCode'];
                }
                $zipCode = $row['providerZipCode'];
                $providerID = $row['providerId'];
                $name = $row['providerName'];
                $address = $row['providerStreetAddress'];
                $city = $row['providerCity'];
                $aTPs = $row['averageTotalPayments'];
                echo 'codeAddress("' . $zipCode . '","' . $address . '", "' . $city . '", "' . $name . '","' . $dRGCode . '","' . $providerID . '","' . $aTPs . '");';
            }
            sqlsrv_free_stmt($result);
        }
        ?>


    }


    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function () {
            if (request.readyState == 4) {
                request.onreadystatechange = doNothing;
                callback(request, request.status);
            }
        };

        request.open('GET', url, true);
        request.send(null);
    }

    function doNothing() {
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        // infoWindow.setPosition(pos);
        // infoWindow.setContent(browserHasGeolocation ?
        //     'Error: The Geolocation service failed.' :
        //     'Error: Your browser doesn\'t support geolocation.');
        // infoWindow.open(map);


    }

    function codeAddress(zipCode, address, city, hospitalName, dRGCode, providerID, aTPs) {
        var latLong;
        d3.csv("US_ZipCode_2018.csv").then(function (data) {
            for (var i = 0; i < 33145; i++) {
                if (data[i].ZIP === zipCode) {
                    console.log("Found");
                    console.log("Zip: " + data[i].ZIP);
                    //console.log("zip: " + zip);
                    latLong = {
                        lat: parseFloat(data[i].LAT),
                        lng: parseFloat(data[i].LNG)
                    };
                    console.log("location: " + latLong.lat);
                    createMarker(address, city, latLong, hospitalName, dRGCode, providerID, aTPs);
                }
            }
        });
    }

    function createMarker(address, city, latLong, hospitalName, dRGCode, providerID, aTPs) {
        map.setCenter(latLong);
        map.setZoom(8);

        var infowincontent = document.createElement('div');
        var strong = document.createElement('strong');
        //strong.textContent = name;
        infowincontent.appendChild(strong);

        var text = document.createElement('text');
        text.setAttribute('style', 'white-space: pre; font-weight:bold');
        text.textContent = hospitalName + '\r\n';
        infowincontent.appendChild(text);

        var text1 = document.createElement('text1');
        text1.setAttribute('style', 'white-space: pre;');
        text1.textContent = 'Average Total Payments: $' + Math.round(aTPs) + '\r\n' +
            'Address: ' + address + '\r\n' + 'City: ' + city + '\r\n';
        infowincontent.appendChild(text1);
        var miles = document.createElement('miles');
        miles.setAttribute('style', 'white-space: pre; color : red;');
        if (haveUserLocation) {
            var milesFrom = getDistance(latLong, userPos) + '\r\n';
            miles.textContent = 'Miles: ' + milesFrom //getDistance(latLong, userPos) + '\r\n';
            infowincontent.appendChild(miles);
        }

        if (haveUserLocation) {
            document.getElementById(hospitalName).innerText = "Miles: " + milesFrom
            document.getElementsByClassName("resultContainer").id = milesFrom
        }

        var link = document.createElement('a');
        link.innerHTML = '<a href="hospitalDetails.php?'
            + 'providerId=' + providerID + '&dRGCode=' + dRGCode + '">Click here to view more information</a>';
        infowincontent.appendChild(link);

        var icon = customLabel
        {
        }
        ;

        var marker = new google.maps.Marker({
            map: map,
            position: latLong
        });

        console.log("mark: " + marker.position)
        console.log("marker")

        marker.addListener('click', function () {
            infoWindow.setContent(infowincontent);
            infoWindow.open(map, marker);
        });


    }


    var rad = function (x) {
        return x * Math.PI / 180;
    };

    var getDistance = function (p1, p2) {
        var R = 6378137; // Earth’s mean radius in meter

        var dLat = rad(p2.lat - p1.lat);
        var dLong = rad(p2.lng - p1.lng);
        var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(rad(p1.lat)) * Math.cos(rad(p2.lat)) *
            Math.sin(dLong / 2) * Math.sin(dLong / 2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        var d = R * c;
        return Math.round(d / 1609.344); // returns the distance in meter
    };
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCEOf66YDCHpSc9OhGNJHhejaGG9DArF-U&callback=initMap" async
        defer>
</script>

<div class="container" role="main">
    <form action="<?php echo "index.php?state=".$state."&zipCode=".$zipCode."&dRGInput=".$dRGInput?>"
          method="POST"
          <?php if (empty($dRGInput) or empty($state) or empty($zipCode)) {echo "hidden";} ?>>
        <div class="row my-3 text-center sorters">
            <div class="col-lg-2">
                <label class="my-2"><strong>Price Range:</strong></label>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Min: $</span>
                    </div>
                    <input type="number" class="form-control my-2"
                           aria-label="Minimum amount (to the nearest dollar)" placeholder="0" min="0" step="500"
                           name="priceMin">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Max: $</span>
                    </div>
                    <input type="number" class="form-control my-2"
                           aria-label="Maximum amount (to the nearest dollar)" placeholder="0" min="0" step="500"
                           name="priceMax">
                </div>
            </div>
            <div class="col-lg-3">
                <select class="form-control my-2" name="order" aria-label="Filter type">
                    <option value="" disabled selected hidden>Sort by</option>
                    <option value="price_asc" type="submit">Price: Low to High</option>
                    <option value="price_desc" type="submit">Price: High to Low</option>
                    <option value="distance_asc" type="submit">Distance: Closest First</option>
                    <option value="distance_desc" type="submit">Distance: Furthest First</option>
                    <option value="city_asc" type="submit">City Name: A - Z</option>
                    <option value="city_desc" type="submit">City Name: Z - A</option>
                </select>
            </div>
            <div class="col-lg-3">
                <button class="btn search-btn mt-2" type="submit">Apply</button>
            </div>
        </div>
    </form>
    <hr/>


    <!-- Get list of procedures for a given hospital-->


    <script>
        function divSort() {
            var toSort = document.getElementById('results').children;
            toSort = Array.prototype.slice.call(toSort, 0);

            toSort.sort(function (a, b) {
                var aord = +a.id.split('-')[1];
                var bord = +b.id.split('-')[1];
                // two elements never have the same ID hence this is sufficient:
                return (aord > bord) ? 1 : -1;
            });

            var parent = document.getElementById('results');
            parent.innerHTML = "";

            for (var i = 0, l = toSort.length; i < l; i++) {
                parent.appendChild(toSort[i]);
            }
        }


    </script>
    <div id="results">
        <?php
        include_once("php/db_connect.php");

        if (empty($dRGInput) or empty($state) or empty($zipCode)) {
        if (!empty($userName)) {
            #get userId from userName
            $resultID = sqlsrv_query($conn, "SELECT * FROM userDB WHERE userName=?", array($userName));
            if ($resultID == FALSE) {
                echo '<h1 class="display-3 pb-5 text-center">Database Query Error!</h1>';
                die(print_r(sqlsrv_errors(), true));
            } else {
                if (sqlsrv_has_rows($resultID) == 0) {
                    //no user with that user name
                } else {
                    $rowID = sqlsrv_fetch_array($resultID, SQLSRV_FETCH_ASSOC);
                    $userID = $rowID['userID'];
                }
            }

            $sql = 'SELECT * FROM dbo.newDB main, dbo.bmDB bm WHERE bm.userID=? AND main.providerId=bm.providerId AND main.dRGCode=bm.dRGCode AND year=2017';
            $param = array($userID);
            # run sql query on already set up database connection with custom parameters
            $result = sqlsrv_query($conn, $sql, $param);

        if ($result == FALSE) {
            echo '<h1 class="display-3 pb-5 text-center">Databse Query Error!</h1>';
            die(print_r(sqlsrv_errors(), true));
        } else {
            #return if no results from query.
        if (sqlsrv_has_rows($result) == 0) {
            echo '<h1 class="display-3 pb-5 text-center">Bookmark procedures to view them here</h1>';
            echo '<h1 class="display-3 pb-5 text-center"><br><br></h1>';
        } else {
            echo '<h3 class="pt-5"><i class="fas fa-bookmark"></i> Your Bookmarks</h3>';
            #display formatted query results on frontend.
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            ?>
            <div class="card my-3">
                <div class="row no-gutters">
                    <div class="col">
                        <div class="card-body">
                            <h4 class="card-title nhsColor" style="
                                            float: left">
                                <?php echo $row['providerName']; ?><h3 class="card-title mb-2" style="
                                            float: right">
                                    $
                                    <?php echo round($row['averageTotalPayments']); ?>
                                </h3><br>
                            </h4>
                            <h5 class="card-title text-secondary">
                                <br><?php echo $row['dRGDescription']; ?>
                            </h5>
                            <p class="card-text">
                                <?php echo $row['providerCity']; ?>
                            </p>
                            <form action="hospitalDetails.php" method="GET">
                                <input type='hidden' name="providerId"
                                       value="<?php echo $row['providerId']; ?>">
                                <?php
                                if (empty($row['dRGCode'])) {
                                    $dRGCode = $dRGInput;
                                } else {
                                    $dRGCode = $row['dRGCode'];
                                }
                                ?>
                                <input type='hidden' name="dRGCode" value="<?php echo $dRGCode; ?>">
                                <button class="btn btn-success buy-btn mx-1 m-1" style="
                                            float: right" type="buy">
                                    <i class="fas fa-info-circle" style="color: white"></i> View more information
                                </button>
                                <br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        }
        }
        } else {
            echo '<h1 class="display-3 pb-5 text-center">Create an account to save procedures!</h1>';
            echo '<h3 class="pb-5 text-center">Benefit from quick access to procedures you often search for.</h3>';
            echo '<div class="col-sm-2 m-auto">
                        <button class="btn search-btn btn-outline-success my-2 my-sm-0 mr-2" onclick="location.href = \'register.php\'"> Register</button>
                        </div><br><br>';
        }
        } else {
        # run sql query on already set up database connection with custom parameters
        $result = sqlsrv_query($conn, $sql, $params);

        $rows_count = 0;
        #returns error if required
        if ($result == FALSE) {
            echo '<h1 class="display-3 pb-5 text-center">Databse Query Error!</h1>';
            die(print_r(sqlsrv_errors(), true));

        } else {
        #return if no results from query.
        if (sqlsrv_has_rows($result) == 0) {
            echo '<h1 class="display-3 pb-5 text-center">No results found!</h1>';
            echo '<h1 class="display-3 pb-5 text-center"><br><br><br></h1>';
        } else {
        #display formatted query results on frontend.


        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $rows_count++;
        ?>
            <div id="" class="resultContainer">
                <div class="card my-3">
                    <div class="row no-gutters">
                        <div class="col">
                            <div class="card-body">
                                <h4 class="card-title nhsColor" style="
                                            float: left">
                                    <?php echo ucwords(strtolower($row['providerName'])); ?><h3
                                            class="card-title mb-2"
                                            style="
                                            float: right">
                                        $
                                        <?php echo round($row['averageTotalPayments']); ?>
                                    </h3><br>
                                </h4>
                                <h5 class="card-title text-secondary">
                                    <br><?php echo ucwords(strtolower($row['dRGDescription'])); ?>
                                </h5>
                                <p class="card-text">
                                    <?php echo $row['providerCity']; ?>
                                </p>
                                <br>
                                <p class="distance" id="<?php echo $row['providerName']; ?>"></p>
                                <form action="hospitalDetails.php" method="GET">
                                    <input type='hidden' name="providerId"
                                           value="<?php echo $row['providerId']; ?>">
                                    <?php

                                    if (empty($row['dRGCode'])) {
                                        $dRGCode = $dRGInput;
                                    } else {
                                        $dRGCode = $row['dRGCode'];
                                    }
                                    ?>
                                    <input type='hidden' name="dRGCode" value="<?php echo $dRGCode; ?>">
                                    <button class="btn btn-success buy-btn mx-1 m-auto" style="
                                            float: right" type="buy">
                                        <i class="fas fa-info-circle"></i> View more information
                                    </button>
                                    <br>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }

        ?>

            <button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fas fa-arrow-up"></i> Top
            </button>
            <script>//Get the button:
                mybutton = document.getElementById("myBtn");

                // When the user scrolls down 20px from the top of the document, show the button
                window.onscroll = function () {
                    scrollFunction()
                };

                function scrollFunction() {
                    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                        mybutton.style.display = "block";
                    } else {
                        mybutton.style.display = "none";
                    }
                }

                // When the user clicks on the button, scroll to the top of the document
                function topFunction() {
                    document.body.scrollTop = 0; // For Safari
                    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
                }</script>
            <?php

        }
        }
            sqlsrv_free_stmt($result);

        } ?>
    </div>
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