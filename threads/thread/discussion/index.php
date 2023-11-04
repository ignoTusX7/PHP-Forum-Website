<?php
require("/xampp/htdocs/forumapp/config/_dbconn.php");
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
    <style>
        .custom-callout {
            background-color: rgb(245, 200, 116);
            color: #fff;
            padding: 10px;
            border-left: solid rgb(241, 180, 66);
        }

        .callout-title {
            font-size: 18px;
        }

        .callout-text {
            font-size: 14px;
        }
    </style>
</head>

<body>
    <?php include("/xampp/htdocs/forumapp/partials/_navbar.php") ?>

    <?php
    $err = "";
    $msg = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_REQUEST['responce'])) {
            $responce = $_REQUEST['responce'];
            $thread_id = $_REQUEST['thread_id'];
            $username = $_SESSION['username'];

            // check if any of the field is empty
            if (empty($username) || empty($responce) || empty($thread_id)) {
                $err = 'Please fill all the fields';
            } else {
                $sql = "INSERT INTO `threads_comments` (`comment_desc`,`createdBy`, `thread_id`)
              VALUES ('$responce', '$username', '$thread_id')";
                if ($conn->query($sql) === TRUE) {
                    $msg = "Successfully Posted Problem";
                    header("Location:  /forumapp/threads/thread/discussion/index.php?thread_id=$thread_id");
                } else {
                    $err = "Failed to Post Responce";
                }
            }
        }
    }

    ?>

    <main class="container mt-5">
        <h2 class="text-center">Discussion</h2>
        <h3>Share your responce: </h3>

        <?php
        if (!$loggedin) {
            echo '<div class="bd-callout bd-callout-info custom-callout">
            <p class="callout-text">Please Login to post Responce</p>
        </div>';
        } else {
            echo "
                <form method='POST' action=$_SERVER[PHP_SELF]>
                <div class='mb-3'>
                    <textarea class='form-control' placeholder='Enter your responce here' name='responce' id='responce' rows='3' style='border-radius: 0;'></textarea>
                </div>
                <input type='text' hidden name='thread_id' value='$_REQUEST[thread_id]'>
                <button type='submit' class='btn btn-primary'>Post</button>
            </form>
                ";
        }
        ?>
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <div class="border-bottom">
                <h6 class="pb-2 mb-0">Problem: </h6>
                <?php
                $sql = "SELECT * FROM `threads` WHERE thread_id=$_REQUEST[thread_id]";

                $res = $conn->query($sql);

                if ($res->num_rows > 0) {
                    while ($row = $res->fetch_assoc()) {
                        echo "<div class='d-flex text-body-secondary pt-3 border-bottom'>
                                <img src='/forumapp/public/img/user.png' alt='' width='32' height='32'>
                                <div class='pb-3 pt-1 ms-2 mb-0 small lh-sm'>
                                    <h5>$row[thread_title]</h5>
                                    <pre class=''>$row[thread_desc]</pre>
                                <p class='text-secondary'>$row[createdAt]</p>

                                </div>    
                            </div>";
                    }
                }
                ?>
            </div>
            <div class="ms-5">

                <?php

                if (isset($_POST['delete-btn'])) {
                    $sql = "DELETE FROM `threads_comments` WHERE comment_id=$_REQUEST[comment_id]";
                    if ($conn->query($sql) === TRUE) {
                    } else {
                        echo  "Failed to Post Responce";
                    }
                }

                $sql = "SELECT * FROM `threads_comments` WHERE thread_id=$_REQUEST[thread_id] ORDER BY createdAt DESC";

                $res = $conn->query($sql);

                if ($res->num_rows > 0) {
                    while ($row = $res->fetch_assoc()) {
                        // var_dump($row);
                        echo "
                        <strong>Responces: </strong>
                        <div class='text-body-secondary pt-3 border-bottom'>
                            <div class='d-flex gap-2'>
                                <img src='/forumapp/public/img/user.png' alt='' width='32' height='32'>
                                <strong class='d-block text-gray-dark'>@$row[createdBy]</strong>";
                        if ($loggedin) {
                            if ($row['createdBy'] == $_SESSION['username']) {
                                echo "<form method='post' class='ms-auto'>
                                        <input type='text' value='$row[comment_id]' hidden name='comment_id'>
                                     <input type='submit' value='delete' class='delete-btn ms-auto' id='delete-btn' name='delete-btn'/>
                                </form>";
                            }
                        }
                        echo "</div>
                            <div class='pb-3 pt-1 ms-5 mb-0 small lh-sm'>
                                <pre class='text-muted'>$row[comment_desc]</pre>
                                <p class='text-secondary'>$row[createdAt]</p>
                            </div>    
                      </div>";
                    }
                } else {
                    echo '<div class="bd-callout bd-callout-info custom-callout">
                    <p class="callout-text">No Discussion Found</p>
                </div>';
                }
                ?>
            </div>
        </div>
    </main>
    </div>
    <?php include("/xampp/htdocs/forumapp/partials/_footer.php") ?>

</body>
<script src="/forumapp/public/js/index.js"></script>

</html>