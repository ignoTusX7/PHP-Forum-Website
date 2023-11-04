<?php
// connecting to database 
require_once("../config/_dbconn.php");
?>

<?php
// Checking user existence
$err = "";
$msg = "";
$login = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    // check if any of the field is empty
    if (empty($username) || empty($password)) {
        $err = 'Please fill all the fields';
    } else {
        $existingUser = "SELECT * FROM `users` WHERE username = '$username' OR email = '$username'";

        $res = $conn->query($existingUser);
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                if (password_verify($password, $row['password'])) {
                    $login = true;
                    session_start();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $username;
                    header("location: /forumapp");
                } else {
                    $err = "Invalid Credentials";
                }
            }
        } else {
            $err = "Invalid Credentials";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/forumapp/public/bootstraps/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="/forumapp/public/css/index.css">
    <script src="/forumapp/public/bootstraps/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <title>Login</title>
</head>

<body>
    <?php include("../partials/_navbar.php") ?>

    <div class="container mt-2">
        <?php
        // redierct user to home if  it is already logged in
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            header('Location: /forumapp');
        }

        if (!empty($err)) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error! </strong> ' . $err . '
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
        } elseif ($msg) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success! </strong> ' . $msg . '
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        ?>
    </div>

    <main class="">
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-lg-5 col-md-6 col-sm-6">
                    <div class="card shadow">
                        <div class="card-title text-center border-bottom">
                            <h2 class="p-3">Login</h2>
                        </div>
                        <div class="card-body">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <div class="mb-4">
                                    <label for="username" class="form-label">Username/Email</label>
                                    <input type="text" name="username" class="form-control" id="username" />
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="password" />
                                </div>
                                <div class="mb-4">
                                    <p>Doesn't have an account? <a href="/forumapp/signup">Create new account</a></p>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn text-light main-bg">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include("/xampp/htdocs/forumapp/partials/_footer.php") ?>
</body>
<script src="/forumapp/public/js/index.js"></script>

</html>