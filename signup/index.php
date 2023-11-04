<?php
// connecting to  database 
require_once("../config/_dbconn.php");
?>

<?php
// Performing post data
$err = "";
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_REQUEST['username'];
  $email = $_REQUEST['email'];
  $password = $_REQUEST['password'];
  $cpassword = $_REQUEST['cpassword'];
  // check if any of the field is empty
  if (empty($username) || empty($email) || empty($password) || empty($cpassword)) {
    $err = 'Please fill all the fields';
  } else {
    // check if password and confirm password match
    if ($password != $cpassword) {
      $err = 'Password and Confirm Password do not match';
    } else {

      // check if user already exist
      $existingUser = "SELECT username, email FROM `users` WHERE username = '$username' OR email = '$email'";
      $res = $conn->query($existingUser);
      if ($res->num_rows > 0) {
        $err = "User already exists";
      } else {
        // hashing password
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO `users` (`username`, `email`, `password`)
                VALUES ('$username', '$email', '$hash')";

        if ($conn->query($sql) === TRUE) {
          $msg = "Account Created successfully";
          header("Location: /forumapp/login");
        } else {
          $err = "Failed to create an account";
        }
      }
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
  <title>Sign Up</title>
</head>

<body>
  <?php include("../partials/_navbar.php") ?>
  <div class="container mt-2">
    <?php
    // redierct user to home if  it is already logged in
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
      header('Location: /forumapp/');
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
              <h2 class="p-3">Create a New Account</h2>
            </div>
            <div class="card-body">
              <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="mb-4">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" required name="username" class="form-control" id="username" />
                </div>
                <div class="mb-4">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" required name="email" class="form-control" id="email" />
                </div>
                <div class="mb-4">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" required name="password" class="form-control" id="password" />
                </div>
                <div class="mb-4">
                  <label for="cpassword" class="form-label">Confirm Password</label>
                  <input type="password" required name="cpassword" class="form-control" id="cpassword" />
                </div>
                <div class="mb-4">
                  <p>Already have an account? <a href="/forumapp/login">Login</a></p>
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