<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Team 3">

    <title>Compare Care | Profile</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
        crossorigin="anonymous">

    <!-- Custom CSS -->
    <link href="css/dash.css" rel="stylesheet">

    <!-- Connect to the database -->
    <?php include_once "../php/db_connect.php"; ?>
    <?php include_once "php/display.php"; ?>
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
        <a class="navbar-brand" href="../index.php"><i class="fas fa-ambulance"></i> Compare Care</a>
        <button class="navbar-toggler my-1" type="button" data-toggle="collapse" data-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
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
                    <input readonly="true" id="id3.1" class="form-control mr-2" type="text" placeholder="Username" name="userName"
                        required>
                    <input readonly="true" id="id3.2" class="form-control mr-2" type="password" placeholder="Password"
                        name="uncrypPass" required>
                        <input class="form-control" type="hidden" name="remember" value="checked">
                    <button class="btn btn-outline-success login-btn my-2 my-sm-0 mr-2" type="submit">Log In</button>
                    <button class="btn btn-outline-success login-btn my-2 my-sm-0 mr-2" type="register" onclick="location.href='register.php';">Register</button>
                </div>
            </form>
            <div id="id4" class="logout">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active account" href="../dashboard.php">
                            <?php
if ($userName != "") {
    echo "$userName" . "'s ";
}
?>Account
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
                        if ($userName != "") {
                            echo "$userName" . "'s ";
                        }
                    ?>Dashboard</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="dash">
        <div class="container">
            <div class="row justify-content-around mt-5">
                <div class="col-sm-4 m-auto">
                    <button class="btn back-btn" onclick="location.href='../dashboard.php';" type="back"><i class="fas fa-long-arrow-alt-left"></i>
                        Back to Dash</button>
                </div>
                <div class="col-sm-8 m-auto text-center">
                    <h1><i class="fas fa-address-book"></i> Profile</h1>
                    <?php
                    if (isset($_GET['cancel'])) {
                        echo '<h4 style="color: grey;"><i class="fas fa-ban" style="color: var(--accent)"></i> Cancelled Action!</h4>';
                        echo '<br/>';
                    } else if (isset($_GET['removed'])) {
                        echo '<h4 style="color: grey;"><i class="fas fa-user-minus" style="color: green"></i> Successful Deletion!</h4>';
                        echo '<br/>';
                    } else if (isset($_GET['added'])) {
                        echo '<h4 style="color: grey;"><i class="fas fa-user-plus" style="color: green"></i> Successful Addition!</h4>';
                        echo '<br/>';
                    } else if (isset($_GET['updated'])) {
                        echo '<h4 style="color: grey;"><i class="fas fa-user-edit" style="color: green"></i> Successful Modification!</h4>';
                        echo '<br/>';
                    }
                    ?>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-sm-4 buttonlist">
                    <button id="update" class="btn crud-btn my-1" onclick="showHideCRUD(this.id)" type="back">Update Profile Info</button>
                    <button id="remove" class="btn crud-btn my-1" onclick="showHideCRUD(this.id)" type="back">Delete Account</button>
                </div>
                <div class="col-sm-8">
                    <div id="view_all_div">
                        <div class="table-responsive-xl">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">User Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Zip Code</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php tableCustomersShow($conn); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="update_div">
                    <?php
                        if (!isset($_GET['update_customer_id_select'])) { ?>
                        <form action="" method="GET">
                            <div class="form-group">
                                <label for="update_customer_select">Select Customer to Modify:</label>
                                <select class="form-control" id="update_customer_select" name="update_customer_id_select">
                                    <?php
                                        $sql = "SELECT * FROM customers";
                                        $resultset = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
                                        while ($record = mysqli_fetch_assoc($resultset)) {
                                            unset($id, $name);
                                            $id = $record['customer_id'];
                                            $desc = $record['customer_first_name'] . " " . $record['customer_last_name'];
                                            ?>
                                    <option value="<?php echo $id; ?>">
                                        <?php echo $id . " - " . $desc ?>
                                    </option>';
                                    <?php }?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary" name="select" value="select">Select</button>
                        </form> 
                    <?php } ?>
                        <div id="update_details">
                            <?php
                                if (isset($_GET['update_customer_id_select'])) {
                                    $usr = $_GET['update_customer_id_select'];
                                    $sql = "SELECT * FROM dbo.user.DB WHERE userID = $usr";
                                    $resultset = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
                                    while ($record = mysqli_fetch_assoc($resultset)) {
                            ?>
                            <form action="php/customers/update.php" method="GET">
                                <input name="id_update" class="form-control" type="hidden" value="<?php echo $record['userIf']; ?>" required />
                                <div class="form-group form-inline my-1">
                                    <label class="mx-3">First Name:</label>
                                    <input name="first_name" class="form-control" type="text" value="<?php echo $record['customer_first_name']; ?>" required />
                                </div>
                                <div class="form-group form-inline my-1">
                                    <label class="mx-3">Last Name:</label>
                                    <input name="last_name" class="form-control" type="text" value="<?php echo $record['customer_last_name']; ?>" required />
                                </div>
                                <div class="form-group form-inline my-1">
                                    <label class="mx-3">Phone:</label>
                                    <input name="phone" class="form-control" type="text" value="<?php echo $record['customer_phone']; ?>" required />
                                </div>
                                <div class="form-group form-inline my-1">
                                    <label class="mx-3">Email:</label>
                                    <input name="email" class="form-control" type="text" value="<?php echo $record['customer_email']; ?>" required />
                                </div>
                                <div class="form-group form-inline my-1">
                                    <label class="mx-3">Age:</label>
                                    <input name="age" class="form-control" type="text" value="<?php echo $record['customer_age']; ?>" required />
                                </div>
                                <div class="form-group form-inline my-1">
                                    <label class="mx-3">Gender:</label>
                                    <input name="gender" class="form-control" type="text" value="<?php echo $record['customer_gender']; ?>" required />
                                </div>
                                <div class="form-group form-inline my-1">
                                    <label class="mx-3">Nationality:</label>
                                    <input name="nation" class="form-control" type="text" value="<?php echo $record['customer_nationality']; ?>" required />
                                </div>
                                <div class="form-group form-inline my-1">
                                    <label class="mx-3">Address ID:</label>
                                    <select name="address_id" class="form-control" required>
                                    <?php
                                        $sql_address = "SELECT * FROM address";
                                        $resultset_address = mysqli_query($conn, $sql_address) or die("database error:" . mysqli_error($conn));
                                        while ($record_address = mysqli_fetch_assoc($resultset_address)) {
                                            unset($address_id, $address_desc);
                                            $address_id = $record_address['address_id'];
                                            $address_desc = $record_address['address_no'] . " " . $record_address['address_street'] . " " . $record_address['address_city'];
                                            ?>
                                    <option value="<?php echo $address_id; 
                                    if ($record['address_id'] == $record_address['address_id']) {
                                        echo "\" selected=\"selected";
                                    }
                                    ?>">
                                        <?php echo $address_id . " - " . $address_desc ?>
                                    </option>';
                                    <?php }?>
                                </select>
                                </div>
                                <div class="form-group form-inline my-4">
                                    <button type="submit" class="btn btn-danger mx-2" name="update" value="update">Update</button>
                                    <button type="submit" class="btn btn-secondary" name="cancel" value="cancel" formnovalidate>Cancel</button>
                                </div>
                            </form>
                                    <?php } }?> 
                        </div>
                    </div>
                    <div id="remove_div">
                    <?php
                        if (!isset($_GET['remove_customer_id_select'])) { ?>
                        <form action="" method="GET">
                            <div class="form-group">
                                <label for="remove_customer_select">Select Customer to Remove:</label>
                                <select class="form-control" id="remove_customer_select" name="remove_customer_id_select">
                                    <?php
                                        $sql = "SELECT * FROM customers";
                                        $resultset = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
                                        while ($record = mysqli_fetch_assoc($resultset)) {
                                            unset($id, $name);
                                            $id = $record['customer_id'];
                                            $desc = $record['customer_first_name'] . " " . $record['customer_last_name'];
                                            ?>
                                    <option value="<?php echo $id; ?>">
                                        <?php echo $id . " - " . $desc ?>
                                    </option>';
                                    <?php }?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary" name="select" value="select">Select</button>
                        </form> 
                    <?php } ?>
                        <div id="remove_details">
                            <?php
                                if (isset($_GET['remove_customer_id_select'])) {
                                    $usr = $_GET['remove_customer_id_select'];
                                    $sql = "SELECT * FROM customers WHERE customer_id = $usr";
                                    $resultset = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
                                    while ($record = mysqli_fetch_assoc($resultset)) {
                            ?>
                            <form>
                                <div class="form-group form-inline my-1">
                                    <label class="mx-3">First Name:</label>
                                    <input class="form-control" type="text" value="<?php echo $record['customer_first_name']; ?>" readonly />
                                </div>
                                <div class="form-group form-inline my-1">
                                    <label class="mx-3">Last Name:</label>
                                    <input class="form-control" type="text" value="<?php echo $record['customer_last_name']; ?>" readonly />
                                </div>
                                <div class="form-group form-inline my-1">
                                    <label class="mx-3">Phone:</label>
                                    <input class="form-control" type="text" value="<?php echo $record['customer_phone']; ?>" readonly />
                                </div>
                                <div class="form-group form-inline my-1">
                                    <label class="mx-3">Email:</label>
                                    <input class="form-control" type="text" value="<?php echo $record['customer_email']; ?>" readonly />
                                </div>
                                <div class="form-group form-inline my-1">
                                    <label class="mx-3">Age:</label>
                                    <input class="form-control" type="text" value="<?php echo $record['customer_age']; ?>" readonly />
                                </div>
                                <div class="form-group form-inline my-1">
                                    <label class="mx-3">Gender:</label>
                                    <input class="form-control" type="text" value="<?php echo $record['customer_gender']; ?>" readonly />
                                </div>
                                <div class="form-group form-inline my-1">
                                    <label class="mx-3">Nationality:</label>
                                    <input class="form-control" type="text" value="<?php echo $record['customer_nationality']; ?>" readonly />
                                </div>
                                <div class="form-group form-inline my-1">
                                    <label class="mx-3">Address ID:</label>
                                    <input class="form-control" type="text" value="<?php echo $record['address_address_id']; ?>" readonly />
                                </div>
                                <div class="form-group form-inline mt-4 mb-2">
                                    <button type="submit" class="btn btn-secondary mx-2" name="cancel" value="cancel" formnovalidate>Cancel</button>
                                </div>
                            </form>
                            <form action="php/customers/remove.php" method="GET">
                                <div class="form-group form-inline m-0">
                                    <input name="id_delete" class="form-control" type="hidden" value="<?php echo $record['customer_id']; ?>" readonly />
                                </div>
                                <div class="form-group form-inline mb-4">
                                    <button type="submit" class="btn btn-danger mx-2" name="remove" value="remove">Remove</button>
                                </div>
                            </form>
                                    <?php } }?> 
                        </div>
                    </div>
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

        <script type="text/javascript">
            function showHideCRUD(clicked_id) {
                var u = document.getElementById("update_div");
                var r = document.getElementById("remove_div");
                if (clicked_id == "update") {
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