<?php
require_once("../config/_dbconn.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/forumapp/public/bootstraps/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="/forumapp/public/css/index.css">
    <script src="/forumapp/public/bootstraps/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <title>Threads Categories</title>
</head>

<body>
    <?php include("../partials/_navbar.php") ?>
    <h1 class="text-center">Thread Categories</h1>
    <main class="container mt-5">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            $sql = "SELECT * FROM `thread_categories`";

            $res = $conn->query($sql);

            if ($res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    echo "<div class='col'>
                    <div  class='card ' style='min-height: 23rem;'>
                        <div class='card-body' >
                            <h5 class='card-title fw-bolder'>$row[category_name]</h5>
                            <p class='card-text flex-1'>$row[category_desc]</p>
                            <div class='px-6 pt-4 pb-2'>
                            <a href='thread/index.php?cat_id=$row[cat_id]' class='btn btn-primary rounded-full px-3 py-2 text-sm font-semibold mr-2 my-2'>
                            Browse Questions
                            </a>
                        </div>
                        </div>
                    </div>
                </div>";
                }
            } else {
                echo "No Caategories Found";
            }
            ?>
        </div>

    </main>

    </div>
    <?php include("../partials/_footer.php") ?>

</body>
<script src="/forumapp/public/js/index.js"></script>

</html>