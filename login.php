<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Compare Care | Login</title>

    <!-- Public stylesheet for material design icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Private stylesheet -->
    <link rel="stylesheet" type="text/css" href="css/packages.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Not sure if I still need the syle thingy -->

    <script type="text/javascript">
        function pageLoad() {
        }

        window.onload = pageLoad;
    </script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
          crossorigin="anonymous">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
          crossorigin="anonymous">

</head>

<body onload="">

<div id="id1" class="userDetails">
    <?php
    $userName = $encrypPass = "";
    $username_err = $password_err = "";
    $query = "";

    $authLoaded = false; //used to determine if login loaded from file

    $remb = true; //boolean to remember login details or not

    error_reporting(E_ALL & ~E_NOTICE); //Hide error messages (e.g. notices on homepage, will only be turned on when releasing website)
    $url = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);

    //Check website navigating from before allowing post requests only if ftom the same server as this
    if ($url != "") { //If the referee is not an about:blank page or been entered from the URL bar or a first entry

        if ((array_key_exists('remember', $_POST))) {
            //&& (htmlspecialchars($_POST['remember']) != $remb)
            $rembtmp = htmlspecialchars($_POST['remember']);
            if ($rembtmp == 'checked') {
                $remb = true;
            }
            else {
                $remb = false;
            }
        }
        else if ((array_key_exists('userName', $_POST)) || (array_key_exists('encrypPass', $_POST))) {
            //if either of userName or encrypPass has been sent then remb must be blank
            $remb = false;
        }

        if (array_key_exists('logout', $_POST)) {
            $userName = $encrypPass = "";
            if ($remb) {
                setcookie("userName", " ");
                setcookie("encrypPass", " ");
            }

            //http://php.net/manual/en/function.session-destroy.php
            // Unset all of the session variables.
            session_start();
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
        }
        else {
            if ((array_key_exists('userName', $_POST) && (htmlspecialchars($_POST['userName']) != $userName))) {
                $userName = htmlspecialchars($_POST['userName']);
                if ($remb) {
                    setcookie("userName", $userName);
                }
            }

            if ((array_key_exists('encrypPass', $_POST) && (htmlspecialchars($_POST['encrypPass']) != $encrypPass))) {
                $encrypPass = htmlspecialchars($_POST['encrypPass']);
                if ($remb) {
                    setcookie("encrypPass", $encrypPass);
                }
            }

            if (array_key_exists('uncrypPass', $_POST)) {
                $uncrypPass = htmlspecialchars($_POST['uncrypPass']);
                if (strlen($uncrypPass) > 18) {
                    $uncrypPass = "";
                    $password_err = "Password too long";
                }
                else {
                    /**
                     * In this case, increase the default cost for BCRYPT to 12.
                     * Note that we also switched to BCRYPT, which will always be 60 characters.
                     */
                    $options = [
                        'cost' => 10,
                    ];

                    //https://secure.php.net/manual/en/function.password-hash.php
                    $encrypPass = password_hash($uncrypPass, PASSWORD_BCRYPT, $options);
                    if ($remb) {
                        setcookie("encrypPass", $encrypPass);
                    }
                }
            }
        }

    }

    //Destroy session if navigating
    session_start();
    //Reset session if coming from other website

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
    if (!array_key_exists('logout', $_POST)) {
        if ($userName == "") {
            if ((isset($_SESSION['userName'])) && !empty($_SESSION['userName'])) {
                $userName = $_SESSION["userName"];
                if ($userName == " ") {
                    $userName = "";
                }
            }
        }
        else {
            $_SESSION['userName'] = $userName;
        }

        if ($encrypPass == "") {
            if ((isset($_SESSION['encrypPass'])) && !empty($_SESSION['encrypPass'])) {
                $encrypPass = $_SESSION["encrypPass"];
                if ($encrypPass == " ") {
                    $encrypPass = "";
                }
            }
        }
        else {
            $_SESSION['encrypPass'] = $encrypPass;
        }

        if (($userName == "") && ($encrypPass == "")) {

            if (isset($_COOKIE["userName"])) {
                $userName = $_COOKIE["userName"];
                if ($userName == " ") {
                    $userName = "";
                }
                else {
                    $authLoaded = true;
                }
            }
            else if ($remb) {
                setcookie("userName", " ");
            }
            if (isset($_COOKIE["encrypPass"])) {
                $encrypPass = $_COOKIE["encrypPass"];
                if ($encrypPass == " ") {
                    $encrypPass = "";
                }
                else {
                    $authLoaded = true;
                }
            }
            else if ($remb) {
                setcookie("encrypPass", " ");
            }
        }
    }

    if (($userName != "") && ($encrypPass != "")) {
        $query = "login ";
    }

    if ($url != "") { //If the referee is not an about:blank page or been entered from the URL bar or a first entry
        if (array_key_exists('query', $_POST) || $query == "login") {
            if ($query == "") {
                $query = htmlspecialchars($_POST['query']);
            }
        }

        if (($userName != "") && ($encrypPass != "")) {
            if (strlen($userName) <= 18) {

                include_once("php/db_connect.php");
                if ($conn != false) {
                    $sql = "SELECT * FROM dbo.userDB WHERE userName='$userName'";

                    $resultsetLogin = sqlsrv_query($conn, $sql) or die(print_r(sqlsrv_errors(), true));

                    $pswVeris = "false"; //boolean for psw hints
                    $usrVeris = "false"; //boolean for psw hints
                    if (sqlsrv_has_rows($resultsetLogin) == 0) {
                        #user not found
                        $username_err = "Username not found.";
                    }
                    else {
                        $record = sqlsrv_fetch_array($resultsetLogin, SQLSRV_FETCH_ASSOC);
                        $usrVeris = "true";
                        //if ($record['userPassword'] == $uncrypPass) {   //from when pws stored in plain text
                        if (password_verify($uncrypPass, $record['userPassword'])) { // Verify stored hash encrypPass against plain-text password
                            $pswVeris = "true";
                            $userPassword = $record['userPassword']; //Set What the User Password Should be from the Database
                        }
                    }

                    if ($pswVeris == "true") {
                        //password was verfied and found valid
                    }
                    else {
                        $password_err = "Incorrect Password"; // $password not the same as the one in the database if here
                        //$uncrypPass = "";
                        $encrypPass = "";
                    }

                    //if username not found in login database
                    if ($usrVeris == "false") {
                        $username_err = "User Not Found";
                        $password_err = "";
                    }
                }
                else {
                    #DB connection error
                    $encrypPass = "";
                    die(print_r(sqlsrv_errors(), true));
                }
            }
            else {
                $username_err = "Username is too long";
                $encrypPass = "";
            }
        }
        else {
            #this shouldn't happen, due to front end validation
            $username_err = "User Name or Password Not Provided";
        }

        if ($username_err != "") {
            if ($remb) {
                setcookie("userName", " ");
            }
            if (isset($_COOKIE["userName"])) {
                unset($_SESSION['userName']);
            }
        }
        if ($password_err != "") {
            if ($remb) {
                setcookie("encrypPass", " ");
            }
            if (isset($_COOKIE["encrypPass"])) {
                unset($_SESSION['encrypPass']);
            }
        }
    }

    ?>
</div>


<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="index.php"><i class="fas fa-ambulance"></i> Compare Care</a>
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

<div id="id5" class="welcome mt-lg-1 mt-5">


    <?php
    echo '<h1 class="display-4 text-center"> Welcome ' . htmlentities($userName, ENT_QUOTES | ENT_IGNORE, "UTF-8") . " to Compare Care's Login Page </h1> <br>";
    if ($encrypPass !== " " && $encrypPass !== "") {
        //echo "<script>console.log('encrypted password is: |'.$encrypPass.substring(0, $encrypPass.length - 1));</script>";
    }
    if ($remb) {
        if (count($_COOKIE) == 0) {
            #if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') == FALSE){
            echo "Cookies are disabled! /or cookies have just been set <br>";
            echo "Enable cookies to remember script information / Refresh Page";
            #}
        }
    }

    ?>
</div>

<div id="id6" class="login">
    <form action="#" method="post">
        <div class="imgcontainer">
            <i class="material-icons" alt="Avatar" style="font-size: 50px">people</i>
        </div>

        <div class="container">
            <label for="uname"><b>Username</b></label>
            <span class="help-block">
					<?php echo $username_err; ?></span>
            <input readonly="true" id="id6.1" type="text" placeholder="Enter Username" name="userName" required
                   value=<?php echo htmlentities($userName,
                ENT_QUOTES | ENT_IGNORE, "UTF-8") ?>>

            <label for="psw"><b>Password</b></label>
            <span class="help-block">
					<?php echo $password_err; ?></span>
            <input readonly="true" id="id6.2" type="password" placeholder="Enter Password" name="uncrypPass" required>


            <button type="submit" class="btn">Login</button>
            <label>
                <?php
                if ($remb) {
                    echo "<input type='checkbox' name='remember' checked value='checked'> Remember me";
                }
                else {
                    echo "<input type='checkbox' name='remember' value='checked'> Remember me";
                }
                ?>

            </label>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <!--<span class="psw">Forgot <a href="#">password?</a></span>-->
            <!-- Link to regesterpage in form -->
            <span class="reg"><a href="register.php">Click Here</a> to Register</span>
        </div>
    </form>

</div>


<div id="id7" class="logout">
    <!-- <button type="button" class="logoutBtn" id="buttonLogout" onclick="logOutAccount()">Log Out</button> -->
    <!-- How to call the following -->

    <!--

        #if ($remb == true){
        #	setcookie("userName", " ");
        #	setcookie("encrypPass", " ");
        #}
        #location.reload(true); //force not to reload from cache
        ?>
        -->

    <form action="#" method="post">
        <div class="container">

            <input type='hidden' name="logout" value="true">
            <?php
            if ($remb) {
                echo "<input type='hidden' name='remember' value='checked'> ";
                //echo "<input type='hidden' name='remember' value='checked'>";
            }
            ?>
            <button type="submit" class="btn">Logout</button>

        </div>
    </form>


</div>

<button id="buttonLogin" onclick="loginToggle()">Hide/Show Login</button>

<!-- <button onclick="logoutToggle()">Toggle Logout</button> -->

<div id="id9" class="showHideElements">
    <?php

    if (($userName == "") || ($encrypPass == "")) {
        //Show Login
        echo '<script type="text/javascript">';
        echo 'var x = document.getElementById("id6");';
        echo 'x.style.display = "block";';
        echo 'document.getElementById("id6.1").readOnly = false;';
        echo 'document.getElementById("id6.2").readOnly = false;';
        echo '</script>';
        //header("refresh:5;url=http://thisinterestsme.com/php-forcing-https-over-http/");
    }
    else {
        // Show logout
        echo '<script type="text/javascript">';
        echo 'var x = document.getElementById("id7");';
        echo 'x.style.display = "block";';
        echo '</script>';

    }

    ?>

</div>

<div id="id6" class="login">
    <form action="#" method="post">
        <div class="imgcontainer">
            <i class="material-icons" alt="Avatar" style="font-size: 50px">people</i>
        </div>

        <div class="container">
            <label for="uname"><b>Username</b></label>
            <span class="help-block">
					<?php echo $username_err; ?></span>
            <input readonly="true" id="id6.1" type="text" placeholder="Enter Username" name="userName" required
                   value=<?php echo htmlentities($userName,
                ENT_QUOTES | ENT_IGNORE, "UTF-8") ?>>

            <label for="psw"><b>Password</b></label>
            <span class="help-block">
					<?php echo $password_err; ?></span>
            <input readonly="true" id="id6.2" type="password" placeholder="Enter Password" name="uncrypPass" required>


            <button type="submit">Login</button>
            <label>
                <?php
                if ($remb) {
                    echo "<input type='checkbox' name='remember' checked value='checked'> Remember me";
                }
                else {
                    echo "<input type='checkbox' name='remember' value='checked'> Remember me";
                }
                ?>

            </label>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" class="cancelbtn">Cancel</button>
            <!--<span class="psw">Forgot <a href="forgotPassword.php">password?</a></span>-->
            <!-- Link to regesterpage in form -->
            <span class="reg"><a href="register.php">Click Here</a> to Register</span>
        </div>
    </form>

</div>

<!-- Footer -->
<footer class="py-3 bg-dark fixed-bottom">
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

<script>
    function logoutToggle() {
        //alert("Toggle Logout");
        var x = document.getElementById("id5");
        //var x = document.getElementsByClassName("logout");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    function loginToggle() {
        //alert("Toggle Login");
        var x = document.getElementById("id6");
        //var x = document.getElementsByClassName("login");
        if (x.style.display === "none") {
            x.style.display = "block";
            document.getElementById("id6.1").readOnly = false;
            document.getElementById("id6.2").readOnly = false;
        } else {
            x.style.display = "none";
            document.getElementById("id6.1").readOnly = true;
            document.getElementById("id6.2").readOnly = true;
        }
    }

    function logoutOFF() {
        //alert("logoutOFF");
        var x = document.getElementById("id7");
        //var x = document.getElementsByClassName("logout");
        if (x.style.display != "none") {
            x.style.display = "none";
        }
    }

    function logoutON() {
        //alert("logoutON");
        var x = document.getElementById("id7");
        //var x = document.getElementsByClassName("logout");
        alert(x.style.display);
        if (x.style.display != "block") {
            x.style.display = "block";
        }
    }

    function loginOFF() {
        //alert("loginOFF");
        var x = document.getElementById("id6");
        //var x = document.getElementsByClassName("login");;
        if (x.style.display != "none") {
            x.style.display = "none";
        }
        document.getElementById("id6.1").readOnly = true;
        document.getElementById("id6.2").readOnly = true;
    }

    function loginON() {
        //alert("loginON");
        var x = document.getElementById("id6");
        //var x = document.getElementsByClassName("login");
        if (x.style.display != "block") {
            x.style.display = "block";
        }
        document.getElementById("id6.1").readOnly = false;
        document.getElementById("id6.2").readOnly = false;
    }
</script>
<?php
if ($authLoaded) {
    echo "<script type='text/javascript'>alert('Login loaded from perviously remembered authentication');</script>";
}
?>
</body>

</html>