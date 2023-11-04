<?php
require_once("/xampp/htdocs/forumapp/config/_dbconn.php");

session_start();
$loggedin = false;
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  $loggedin = true;
} else {
  $loggedin = false;
}

echo '<nav class="navbar navbar-expand-lg bg-dark border-bottom border-bod" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/forumapp">Forum App</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/forumapp">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/forumapp/threads">Threads</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Thread Categories
          </a>
          <ul class="dropdown-menu">';
$sql = "SELECT * FROM `thread_categories`";
$res = $conn->query($sql);
if ($res->num_rows > 0) {
  while ($row = $res->fetch_assoc()) {
    echo "<li><a class='dropdown-item' href='/forumapp/threads/thread/index.php?cat_id=$row[cat_id]'>$row[category_name]</a></li>";
  }
}
echo '</ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/forumapp/about">About</a>
        </li>
      </ul>';
if ($loggedin == true) {
  echo '<div class="mx-2 flex">
 <a class="btn btn-primary" href="/forumapp/logout">
     Loogout
 </a>
</div>';
} else {
  echo '<div class="mx-2 flex">
        <a class="btn btn-primary" href="/forumapp/login">
            Login
        </a>
        <a class="btn btn-primary" href="/forumapp/signup">
            Sign Up
        </a>
      </div>';
}
echo '</div>
  </div>
</nav>';
