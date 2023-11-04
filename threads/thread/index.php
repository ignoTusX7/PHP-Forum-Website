<?php
require("/xampp/htdocs/forumapp/config/_dbconn.php");

$cat_id = $_REQUEST["cat_id"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/forumapp/public/bootstraps/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="/forumapp/public/css/index.css">
    <script src="/forumapp/public/bootstraps/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <style>
        :root {
            --main-bg: #1e4de9;
        }

        .main-bg {
            background: var(--main-bg) !important;
        }

        input:focus,
        button:focus,
        textarea:focus {
            border: 1px solid var(--main-bg) !important;
            box-shadow: none !important;
        }

        .form-check-input:checked {
            background-color: var(--main-bg) !important;
            border-color: var(--main-bg) !important;
        }

        .card,
        .btn,
        input {
            border-radius: 0 !important;
        }

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
        if (isset($_REQUEST['problem']) && isset($_REQUEST['problem_desc'])) {
            $problem = $_REQUEST['problem'];
            $problem_desc = $_REQUEST['problem_desc'];
            $category = $_REQUEST['cat_id'];
            $username = $_SESSION['username'];

            // check if any of the field is empty
            if (empty($username) || empty($problem) || empty($problem_desc)) {
                $err = 'Please fill all the fields';
            } else {
                $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `createdBy`, `cat_id`)
                  VALUES ('$problem', '$problem_desc', '$username', '$category')";

                if ($conn->query($sql) === TRUE) {
                    $msg = "Successfully Posted Problem";
                    header("Location:  /forumapp/threads/thread/index.php?cat_id=$category");
                } else {
                    echo "Failed to Post Problem";
                }
            }
        }
    }

    ?>

    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
        <div class="container-fluid py-5">
            <?php
            $sql = "SELECT category_name from `thread_categories` WHERE cat_id = $cat_id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // var_dump($row);
                    echo "<h1 class='display-5 fw-bold text-center'>Threads About $row[category_name]</h1>";
                }
            } else {
                echo "No Threads Found";
            }
            ?>

            <p class="col-md-8 fs-4">Forum rules and posting guidelines:
            <ul>
                <li> Keep it friendly.</li>
                <li>Be courteous and respectful.</li>
                <li>Appreciate that others may have an opinion different from yours.</li>
                <li>Stay on topic. ...</li>
                <li>Share your knowledge. ...</li>
                <li>Refrain from demeaning, discriminatory, or harassing behaviour and speech.</li>
            </ul>
            </p>
        </div>
    </div>

    <main class="container mt-5">

        <!-- form for post thread -->
        <h3>Share your Problem: </h3>
        

        <?php
        if (!$loggedin) {
            echo '<div class="bd-callout bd-callout-info custom-callout">
            <p class="callout-text">Please Login to post Problems.</p>
        </div>';
        } else {

            if (isset($_POST['delete-btn'])) {
                $thread_id =  $_REQUEST['thread_id'];
                $sql = "DELETE FROM `threads` WHERE thread_id=$thread_id";
                if ($conn->query($sql) === TRUE) {
                } else {
                    echo  "Failed to Delete Thread";
                }
            }


            echo "
                <form method='POST' action=$_SERVER[PHP_SELF]>
                <div class='mb-3'>
                    <label for='problem' class='form-label'>Problem: </label>
                    <input type='text' class='form-control' name='problem' id='problem'>
                </div>
                <div class='mb-3'>
                    <label for='problem_desc' class='form-label'>Problem Description: </label>
                    <textarea class='form-control' name='problem_desc' id='problem_desc' rows='3' style='border-radius: 0;'></textarea>
                </div>
                <input type='text' hidden name='cat_id' value='$cat_id'>
                <button type='submit' class='btn btn-primary'>Post</button>
            </form>
                ";
        }
        ?>



        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h6 class="border-bottom pb-2 mb-0 fw-bold">Problems: </h6>
            <?php

            $sql = "SELECT * FROM `threads` WHERE cat_id=$_REQUEST[cat_id] ORDER BY createdAt DESC";

            $res = $conn->query($sql);

            if ($res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    // var_dump($row);
                    echo "<div class='text-body-secondary pt-3 border-bottom'>
                            <div class='d-flex gap-2'>
                                <img src='/forumapp/public/img/user.png' alt='' width='32' height='32'>
                                <strong class='d-block text-gray-dark'>@$row[createdBy]</strong>";
                    if ($loggedin) {
                        if ($row['createdBy'] == $_SESSION['username']) {
                            echo "<form method='post' class='ms-auto'>
                                                <input type='text' value='$row[thread_id]' hidden name='thread_id'>
                                             <input type='submit' value='delete' class='delete-btn ms-auto' id='delete-btn' name='delete-btn'/>
                                        </form>";
                        }
                    }
                    echo "</div>
                            <div class='pb-3 pt-1 ms-5 mb-0 small lh-sm'>
                                <h5><a href='discussion/index.php?thread_id=$row[thread_id]' class='text-dark'>$row[thread_title]</a></h5>
                                <p class='text-secondary'>$row[thread_desc]</p>
                                <p class='text-secondary'>$row[createdAt]</p>

                            </div>    
                      </div>";
                }
            } else {
                echo '<div class="bd-callout bd-callout-info custom-callout">
                <p class="callout-text">No Threads Found</p>
            </div>';
            }
            ?>
            <!-- <small class="d-block text-end mt-3">
                <a href="#">All updates</a>
            </small> -->
        </div>
    </main>

    </div>
    <?php include("/xampp/htdocs/forumapp/partials/_footer.php") ?>

</body>
<script src="/forumapp/public/js/index.js"></script>

</html>