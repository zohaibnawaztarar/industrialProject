<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Team 8">

    <title>Compare Care</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
        crossorigin="anonymous">

    <!-- Custom CSS -->
    <link href="css/home.css" rel="stylesheet">


</head>

<body>

    <div id="id1" class="userDetails">
        <?php
			error_reporting(E_ALL & ~E_NOTICE); //Hide error messages (e.g. notices on homepage, will only be turned on when releasing website)
			$url = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
			$message = "REFERER is: ".parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
			//echo "<script type='text/javascript'>alert('$message');</script>";

			$userName = "";
			$encrypPass = "";

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

		?>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#"><i class="fas fa-ambulance"></i> Compare Care</a>
        <button class="navbar-toggler my-1" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
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
                    <a class="nav-link" href="packages.php">Packages</a>
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
                    <input readonly="true" id="id3.1" class="form-control mr-2" type="text" placeholder="Username" name="userName" required>
                    <input readonly="true" id="id3.2" class="form-control mr-2" type="password" placeholder="Password" name="uncrypPass" required>
                    <input class="form-control" type="hidden" name="remember" value="checked">
                    <button class="btn btn-outline-success login-btn my-2 my-sm-0 mr-2" type="submit">Log In</button>
                    <button class="btn btn-outline-success login-btn my-2 my-sm-0 mr-2" type="register" onclick="location.href='register.php';">Register</button>
                </div>
            </form>
            <div id="id4" class="logout">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link account" href="dashboard.php">
                            <?php
                            if ($userName != ""){
                                echo "$userName"."'s";
                            }
                            ?>
                            Account</a>
                    </li>
                    <li class="nav-item">
                        <form action="login.php" method="POST">
                            <input type='hidden' name="logout" value="true">
                            <button class="btn btn-outline-success login-btn my-2 my-sm-0 mr-2" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header with Background Image -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="float-lg-left text-center">
					<br><br>
                        <h1 class="mt-5">Find the best procedure!</h1>
                        <hr />
                        <form action="packages.php" method="GET">
                            <div class="form-group m-0">
                                <input required type="text" placeholder="DRG Code or Keywords" name="dRGCode" class="form-control my-2">
                                    
                                <select required class="form-control my-2" name="state">
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
								<input required type="text" placeholder="Zip Code" name="zipCode" class="form-control my-2">
                               </div>
                            
                            <div class="form-group m-0">
                                <button class="btn btn-success btn-mini search-btn my-4" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
		
	<h1> Sorting filters here</h1>

<div id="map"></div>

<script>
  var map, infoWindow;
  var geocoder;
  var userPos

  var customLabel = {
          label: 'R'
  };

  function initMap() {
      map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(-33.863276, 151.207977),
          zoom: 12
      });

      geocoder = new google.maps.Geocoder();
      infoWindow = new google.maps.InfoWindow;

      // Try HTML5 geolocation.
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          userPos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };
          var providerID1 = '330126';
          var dRGCode1 = 39;
          infoWindow.setPosition(userPos);
          infoWindow.setContent('location found');
          //infoWindow.setContent('<a href="https://zeno.computing.dundee.ac.uk/2019-projects/team8/hospitalDetails.php?'
          //   +'providerId='+providerID1+'&dRGCode='+dRGCode1+'">Click here to view more information</a>');
            infoWindow.open(map);

          map.setCenter(userPos);
          map.setZoom(10); //If location is found, increase zoom
        }, function() {
          handleLocationError(true, infoWindow, map.getCenter());
        });
      } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
      }
        //codeAddress('5401','sdfasdfdsf','asdfa','RD');
      <?php
      include "./php/db_connect.php";
      $sql="SELECT TOP(2) * FROM dbo.newDB WHERE dRGCode=?";
      $dRGCode=39;
      $params=array($dRGCode);
      #runningquery
      $results=sqlsrv_query($conn,$sql,$params);
      if($results===false){
          die(print_r(sqlsrv_errors(),true));
      }

      while($row=sqlsrv_fetch_array($results,SQLSRV_FETCH_ASSOC)){
          $providerID = $row['providerId'];
          $name = $row['providerName'];
          $zip = $row['providerZipCode'];
          $address = $row['providerStreetAddress'];
          $city = $row['providerCity'];
          //$state = $row['providerState'];
          echo  "codeAddress(". "'".$zip."', '".$address."', '".$city."', '".$name."','".$dRGCode."','".$providerID."');";
      }

      ?>


/*
      downloadUrl('https://zeno.computing.dundee.ac.uk/2019-projects/team8/map_locations.xml', function (data) {
          var xml = data.responseXML;
          var markers = xml.documentElement.getElementsByTagName('marker');
          Array.prototype.forEach.call(markers, function (markerElem) {
              var id = markerElem.getAttribute('dRGCode');
              var address = markerElem.getAttribute('providerStreetAddress');
              var city = markerElem.getAttribute('providerCity');
              var zip = markerElem.getAttribute('providerZipCode');
              var state = markerElem.getAttribute('providerState');
              // var point = new google.maps.LatLng(
              //     parseFloat(markerElem.getAttribute('lat')),
              //     parseFloat(markerElem.getAttribute('lng')));

                codeAddress(zip, address, city, state);
              // var infowincontent = document.createElement('div');
              // var strong = document.createElement('strong');
              // strong.textContent = name
              // infowincontent.appendChild(strong);
              // infowincontent.appendChild(document.createElement('br'));
              //
              // var text = document.createElement('text');
              // text.textContent = address
              // infowincontent.appendChild(text);
              // var icon = customLabel
              // {
              // }
              // ;

              // var marker = new google.maps.Marker({
              //     map: map,
              //     position: point,
              //     label: icon.label
              // });
              // marker.addListener('click', function () {
              //     infoWindow.setContent(infowincontent);
              //     infoWindow.open(map, marker);
              // });


              // codeAddress(zip);
         // });
      });*/
  };

  function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
          if (request.readyState == 4) {
              request.onreadystatechange = doNothing;
              callback(request, request.status);
          }
      };

      request.open('GET', url, true);
      request.send(null);
  }

  function doNothing() {}


  function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
  }
  //
  function codeAddress(zipCode, address, city, hospitalName, dRGCode, providerID) {
      //zipCode = 36301;
      //num++;
      geocoder.geocode( {'address': zipCode}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {

              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = name
              infowincontent.appendChild(strong);

              //var text = document.createElement('text');
              //text.setAttribute('style', 'white-space: pre; font-weight:bold');
              //text.textContent = hospitalName + '\r\n';
              //infowincontent.appendChild(text);

              //var text1 = document.createElement('text1');
              //text1.setAttribute('style','white-space: pre;');
              //text1.textContent = 'Address: ' + address + '\r\n' + 'City: ' + city + '\r\n' +  'Miles: ';
              //infowincontent.appendChild(text1);

              //var miles = document.createElement('miles');
              //miles.setAttribute('style','white-space: pre; color : red;');
              //miles.textContent = getDistance(results[0].geometry.location, userPos) + '\r\n';
              //infowincontent.appendChild(miles);

              var link = document.createElement('text2');
              link.setAttribute('style','white-space: pre; color : blue;');
              link.textContent = '<a href="https://zeno.computing.dundee.ac.uk/2019-projects/team8/hospitalDetails.php?'
                  +'providerId='+providerID+'&dRGCode='+dRGCode+'">Click here to view more information</a>';
              //link.textContent = 'https://zeno.computing.dundee.ac.uk/2019-projects/team8/hospitalDetails.php?providerId=330126&dRGCode=39';
              infowincontent.appendChild(link);

              var icon = customLabel
              {
              }
              ;

              var marker = new google.maps.Marker({
                  map: map,
                  position: results[0].geometry.location
              });

              marker.addListener('click', function () {
                  infoWindow.setContent(infowincontent);
                  infoWindow.open(map, marker);
              });

          } else {
              alert("Geocode was not successful for the following reason: " + status);
          }
      });
  }


  var rad = function(x) {
      return x * Math.PI / 180;
  };

  var getDistance = function(p1, p2) {
      var R = 6378137; // Earth’s mean radius in meter
      var dLat = rad(p2.lat - p1.lat());
      var dLong = rad(p2.lng - p1.lng());
      var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
          Math.cos(rad(p1.lat())) * Math.cos(rad(p2.lat)) *
          Math.sin(dLong / 2) * Math.sin(dLong / 2);
      var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      var d = R * c;
      return Math.round(d / 1609.344); // returns the distance in meter
  };
</script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCEOf66YDCHpSc9OhGNJHhejaGG9DArF-U&callback=initMap" async defer>
    </script>
    <!--<div class="container">


        <h1 class="text-center mt-5">Featured Hospitals</h1>
        <div class="row my-5">
            <div class="col-sm-4 my-4">
                <a href="packages.php?where=Netherlands" class="custom-card">
                    <div class="card">
                        <img class="card-img-top" src="./resources/card2.jpg" alt="">
                        <div class="card-body text-center">
                            <h4 class="card-title">Hospital 1</h4>
                            <hr />
                            <a href="packages.php?where=Netherlands" class="btn btn-success buy-btn">More Info</a>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-4 my-4">
                <a href="packages.php?where=United+States+of+America" class="custom-card">
                    <div class="card">
                        <img class="card-img-top" src="./resources/card1.jpg" alt="">
                        <div class="card-body text-center">
                            <h4 class="card-title">Hospital 2</h4>
                            <hr />
                            <a href="packages.php?where=United+States+of+America" class="btn btn-success buy-btn">More Info</a>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-4 my-4">
                <a href="packages.php?where=China" class="custom-card">
                    <div class="card">
                        <img class="card-img-top" src="./resources/card13.jpg" alt="">
                        <div class="card-body text-center">
                            <h4 class="card-title">Hospital 3</h4>
                            <hr />
                            <a href="packages.php?where=China" class="btn btn-success buy-btn">More Info</a>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>-->

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