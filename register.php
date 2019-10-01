<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Team 3">

    <title>Compare Care | Register</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
        crossorigin="anonymous">

    <!-- Custom CSS -->
    <link href="css/register.css" rel="stylesheet">

    <!-- Connect to the database -->
    <?php include_once "php/db_connect.php"; ?>
</head>

<body>
    <div id="id1" class="userDetails">
        <?php
error_reporting(E_ALL & ~E_NOTICE); //Hide error messages (e.g. notices on homepage, will only be turned on when releasing website)
$url = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
$message = "REFERER is: " . parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
//echo "<script type='text/javascript'>alert('$message');</script>";

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
        <a class="navbar-brand" href="index.php"><i class="fas fa-ambulance" title="Compare care logo. Vehicle with medical cross symbol on side"></i> Compare Care</a>
        <button class="navbar-toggler my-1" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive" role="banner">
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
                    <input readonly="true" id="id3.1" class="form-control mr-2" type="text" placeholder="Username" name="userName" required>
                    <input readonly="true" id="id3.2" class="form-control mr-2" type="password" placeholder="Password" name="uncrypPass" required>
                    <input class="form-control" type="hidden" name="remember" value="checked">
                    <button class="btn btn-outline-success login-btn my-2 my-sm-0 mr-2" type="submit">Log In</button>
                </div>
            </form>
            <div id="id4" class="logout">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active account" href="dashboard.php">
                            <?php
if ($userName != "") {
    echo "$userName" . "'s ";
}
?>Account
                        </a>
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

    <div class="header">
        <div class="container">
            <div class="row">
                <div class="text-center mx-auto mb-4">
                    <h1 class="my-5">
                        <?php
                        if ($userName != "") {
                            echo "$userName" . "'s ";
                        }
                    ?>Register
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container" role="main">
        <div class="card my-4">
            <div class="card-body mx-3">
                <div id="register">
                    <form action="php/register.php" method="GET">
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                                <input id="username" name="username" class="form-control" type="text" placeholder="e.g. jCena" value="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input id="password" name="password" class="form-control" type="password" placeholder="e.g. SomePassword11" value="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input id="name" name="name" class="form-control" type="text" placeholder="e.g. John" value="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input id="email" name="email" class="form-control" type="text" placeholder="e.g. yourName@provider.com" value="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="zip" class="col-sm-2 col-form-label">Zip Code</label>
                            <div class="col-sm-10">
                                <input id="zip" name="zip" class="form-control" type="text" placeholder="e.g. 10001" value="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn search-btn" name="register" value="register">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>

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

        <script type="text/javascript">
            function showHideCRUD(clicked_id) {
                var v = document.getElementById("view_all_div");
                var a = document.getElementById("add_div");
                var u = document.getElementById("update_div");
                var r = document.getElementById("remove_div");
                if (clicked_id == "view") {
                    a.style.display = "none";
                    u.style.display = "none";
                    r.style.display = "none";
                    v.style.display = "block";
                } else if (clicked_id == "add") {
                    v.style.display = "none";
                    u.style.display = "none";
                    r.style.display = "none";
                    a.style.display = "block";
                } else if (clicked_id == "update") {
                    a.style.display = "none";
                    v.style.display = "none";
                    r.style.display = "none";
                    u.style.display = "block";
                } else {
                    a.style.display = "none";
                    u.style.display = "none";
                    v.style.display = "none";
                    r.style.display = "block";
                }
            }
        </script>
        <script type="text/javascript">
            var v = document.getElementById("view_all_div");
            var a = document.getElementById("add_div");
            var u = document.getElementById("update_div");
            var r = document.getElementById("remove_div");

                <?php
                if (isset($_GET['select'])) {
                if (isset($_GET['update_customer_id_select'])) {
                    echo 'u.style.display = "block";';
                } else if (isset($_GET['remove_customer_id_select'])) {
                    echo 'r.style.display = "block";';
                } else {
                    echo 'v.style.display = "block";';
                }
            } else {
                echo 'v.style.display = "block";';
            }
                ?>
        </script>
    </div>
</body>

</html>