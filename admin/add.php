<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Team 3">

    <title>Compare Care | Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
        crossorigin="anonymous">

    <!-- Custom CSS -->
    <link href="../css/dashboard.css" rel="stylesheet">

    <?php include_once "../php/db_connect.php"; ?>

</head>

<body>
<script>
    function goBack() {
        window.history.back();
    }
</script>
    <div id="id1" class="userDetails">
        <?php
        include_once("../php/db_connect.php");
			error_reporting(E_ALL & ~E_NOTICE); //Hide error messages (e.g. notices on homepage, will only be turned on when releasing website)
			$url = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
			$message = "REFERER is: ".parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
			//echo "<script type='text/javascript'>alert('$message');</script>";

			$userName = "";
			$encrypPass = "";
            $position = "customer";

			//Check website navigating from before allowing post requests only if ftom the same server as this
			if($url != "") { //If the referee is not an about:blank page or been entered from the URL bar or a first entry
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
			if($url == "") { //If the referee is an about:blank page or been entered from the URL bar or a first entry
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

			if ($encrypPass == ""){
				if (isset($_COOKIE["encrypPass"])) {
					$encrypPass = $_COOKIE["encrypPass"];
					if ($encrypPass == " ") {
						$encrypPass = "";
					}
				}
            }
            
            if ($position == "" || $position == "databaseFind"){
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
        <button class="navbar-toggler my-1" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
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
                    <input readonly="true" id="id3.1" class="form-control mr-2" type="text" placeholder="Username" name="userName" required>
                    <input readonly="true" id="id3.2" class="form-control mr-2" type="password" placeholder="Password" name="uncrypPass" required>
                    <input class="form-control" type="hidden" name="remember" value="checked">
                    <button class="btn btn-outline-success login-btn my-2 my-sm-0 mr-2" type="submit">Log In</button>
                    <button class="btn btn-outline-success login-btn my-2 my-sm-0 mr-2" type="register" onclick="location.href='../register.php';">Register</button>
                </div>
            </form>
            <div id="id4" class="logout">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active account" href="#">
                            <?php
                            if ($userName != ""){
                                echo "$userName"."'s";
                            }
                            ?> Account
                        </a>
                    </li>
                    <li class="nav-item">
                        <form action="../login.php" method="POST">
                            <input type='hidden' name="logout" value="true">
                            <button class="btn btn-outline-success login-btn my-2 my-sm-0 mr-2" type="submit">Logout</button>
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
                    ?>Add New Data | Admin Dashboard
                    </h1>
                </div>
            </div>
        </div>
    </div>



    <?php
    if (isset($_POST["submit"])) {
        //get variables
        $dRGCode=$_POST['dRGCode'];
        $dRGDescription=$_POST['dRGDescription'];
        $providerId= $_POST['providerId'];
        $providerName=$_POST['providerName'];
        $providerStreetAddress=$_POST['providerStreetAddress'];
        $providerCity=$_POST['providerCity'];
        $providerState=$_POST['providerState'];
        $providerZipCode=$_POST['providerZipCode'];
        $hospitalReferralRegionHRRDescription=$_POST['hospitalReferralRegionHRRDescription'];
        $totalDischarges=$_POST['totalDischarges'];
        $averageCoveredCharges=$_POST['averageCoveredCharges'];
        $averageTotalPayments = $_POST['averageTotalPayments'];
        $averageMedicarePayments=$_POST['averageMedicarePayments'];
        $year=$_POST['year'];

        //check if the data is duplicated
        include "../php/db_connect.php";
        $sql = "SELECT * FROM dbo.newDB WHERE dRGCode=".$dRGCode." AND providerId=".$providerId." AND year =".$year;
        $result = sqlsrv_query($conn, $sql);

        if($row=sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)) {
            echo '<div class="container">
                    <div class="row">
                    <div class="text-center mx-auto mb-4">
                    <br>
                    <h4 class="text-centre">The data you insert is duplicated. If you want to edit this data again</h4>
                    <button class="btn btn-success btn-mini search-btn my-4" type="submit" onClick = "goBack()">
                    <i class="fas fa-long-arrow-alt-left"></i> Go Back</button><hr>
                    <h4 class="text-centre">Or you can update this data</h4>
                    <form class="" action="../admin/edit.php" method="post">
                    <input type = "hidden" name = "dRGCode" value = "'.$dRGCode.'">
                    <input type = "hidden" name = "providerId" value = "'.$providerId.'">
                    <input type = "hidden" name = "year" value = "'.$year.'">
                    <input type = "hidden" name = "action" value = 2>
                    <button class="btn btn-success btn-mini search-btn my-4" type="submit" name = "Submit">
                    <i class="fas fa-long-arrow-alt-left"></i> Update</button>
                    </form>
                    </div></div></div>';
        }else{
            //insert the data when the data is not duplicated
            sqlsrv_free_stmt($result);
            $providerStreetAddress = str_replace("'","''",$providerStreetAddress);
            $sql = "INSERT INTO dbo.insertDB(dRGCode, dRGDescription, providerId, providerName, providerStreetAddress,
        providerCity, providerState, providerZipCode, hospitalReferralRegionHRRDescription, totalDischarges,
        averageCoveredCharges, averageTotalPayments, averageMedicarePayments, year)
        Values (".$dRGCode.",'".$dRGDescription."',".$providerId.",'".$providerName."','".$providerStreetAddress.
                "','".$providerCity."','".$providerState."',".$providerZipCode.",'".$hospitalReferralRegionHRRDescription.
                "',".$totalDischarges.",".$averageCoveredCharges.",".$averageTotalPayments.",".$averageMedicarePayments.
                ",".$year." )";
            $result = sqlsrv_query($conn, $sql);
            sqlsrv_free_stmt($result);
            echo '<div class="container">
                    <div class="row">
                    <div class="text-center mx-auto mb-4">
                    <br>
                    <h3 class="text-centre">Inserted Successfully</h3>
                    <form class="" action="../admin/Admin.php" method="post">
                    <button class="btn btn-success btn-mini search-btn my-4" type="submit">
                    <i class="fas fa-long-arrow-alt-left"></i> Go Back to Admin</button>
                    </form>
                    </div></div></div>';
        }
    }
    else{
         ?>
    <div class="container">
        <div class="row">
            <div class="text-center mx-auto mb-4">
                <br>
                <h1 class="text-centre" >Fill the data in form below to add in database</h1><hr>
                <form class="navbar-form" action="add.php" method="post">
                    <h4 class="text-left">DRG Definition</h4><hr>
                    <h5 class="text-left">DRG Code</h5>
                    <input required type="number" name="dRGCode" class="form-control my-2">
                    <h5 class="text-left">DRG Description</h5>
                    <input required type="text" name="dRGDescription" class="form-control my-2">
                    <hr>
                    <h4 class="text-left">Provider Information</h4><hr>
                    <h5 class="text-left">Provider ID</h5>
                    <input required type="number" name="providerId" class="form-control my-2">
                    <h5 class="text-left">Provider Name</h5>
                    <input required type="text" name="providerName" class="form-control my-2">
                    <h5 class="text-left">Provider Street Address</h5>
                    <input required type="text" name="providerStreetAddress" class="form-control my-2">
                    <h5 class="text-left">Provider City</h5>
                    <input required type="text" name="providerCity" class="form-control my-2">
                    <h5 class="text-left">Provider State</h5>
                    <input required type="text" maxlength="2" name="providerState" class="form-control my-2">
                    <h5 class="text-left">Provider Zip Code</h5>
                    <input required type="number" name="providerZipCode" class="form-control my-2">
                    <h5 class="text-left">Hospital Referral Region HRR Description</h5>
                    <input required type="text" name="hospitalReferralRegionHRRDescription" class="form-control my-2">
                    <hr>
                    <h4 class="text-left">Charges Data</h4><hr>
                    <h5 class="text-left">Total Discharges</h5>
                    <input required type="number" name="totalDischarges" class="form-control my-2"><br>
                    <h5 class="text-left">Average Covered Charges</h5>
                    <input required type="number" step="any" min="0" name="averageCoveredCharges"
                           class="form-control my-2"><br>
                    <h5 class="text-left">Average Total Payments</h5>
                    <input required type="number" step="any" min="0" name="averageTotalPayments"
                           class="form-control my-2"><br>
                    <h5 class="text-left">Average Medicare Payments</h5>
                    <input required type="number" step="any" min="0" name="averageMedicarePayments"
                           class="form-control my-2"><br>
                    <h5 class="text-left">Year of the Procedure</h5>
                    <input required type="number" step="any" min="0" name="year" class="form-control my-2"><br>
                    <input class="btn btn-success btn-mini search-btn my-4" style="padding: .500rem .79rem;"
                           type="submit"
                           name="submit" value="Submit">
                </form>
                <br><br>
                <form class="" action="../admin/admin.php" method="post">
                <button class="btn btn-success btn-mini search-btn my-4" type="submit"><i class="fas fa-long-arrow-alt-left"></i> Go Admin</button>
                </form>
                </div>
        </div>
    </div>

    <br><br>
<?php } ?>
    <!-- Footer -->
    <footer class="py-3 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Compare Care 2019</p>
        </div>
        <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
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
			if ( ($userName != "") && ($encrypPass != "") ) {
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