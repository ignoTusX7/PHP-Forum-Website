<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="/forumapp/public/bootstraps/css/bootstrap.min.css"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="/forumapp/public/css/index.css" />
    <script
      src="/forumapp/public/bootstraps/js/bootstrap.bundle.min.js"
      crossorigin="anonymous"
    ></script>
    <title>Forum App</title>
    <style>
      .hero {
        position: relative;
        height: 100vh;
        width: 100%;
        /* display: flex; */
        align-items: center;
        justify-content: center;
      }
      .hero::before {
        content: "";
        background-image: url("public/img/hero-bg.png");
        background-size: cover;
        position: absolute;
        top: 0px;
        right: 0px;
        bottom: 0px;
        left: 0px;
        opacity: 0.75;
      }
      h1 {
        position: relative;
        color: #ffffff;
        font-size: 14rem;
        line-height: 0.9;
        text-align: center;
      }
      p {
        position: relative;
        color: #ffffff;
        font-size: 1.5rem;
        line-height: 2;
        text-align: center;
      }
    </style>
  </head>

  <body>
    <?php include("partials/_navbar.php") ?>
    <main class="hero">
      <h1 class="text-center pt-5 fw-bold fs-1">Forum App</h1>
      <div class="container mt-5">
        <p class="text-dark">
          Welcome to our community-driven forum app website, where users can
          share their problems and seek solutions from a supportive online
          community. Whether you're facing a technical issue, looking for
          advice, or just want to discuss various topics, our platform provides
          a space for open dialogue and problem-solving. Join us and tap into
          the collective wisdom of our members, who are eager to help you find
          answers and support you on your journey towards solutions.
        </p>
      </div>
    </main>
    <?php include("partials/_footer.php") ?>
  </body>
  <script src="/forumapp/public/js/index.js"></script>
</html>
