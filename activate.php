<?php
require_once('./functions/config.php');
require_once('./functions/functions.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
  <link rel="stylesheet" href="./assets/css/login-system-style.css" />
  <title>Account Activation</title>
</head>

<body>
  <header>
    <h1 id="name"><a href="./"><span>LAMP</span> Authentication</a></h1>
  </header>

  <main>

    <div id="nav"><a id="homebutton" href="./">Home</a>&nbsp&nbsp&nbsp&nbsp<a id="loginbutton" href="./login">Log In</a></div>



    <?php activation(); ?>


    <section class="vh-10">
      <div class=" py-3 h-100">
        <div class="row d-flex justify-content-center align-items-center h-10">
          <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card-body p-1 text-center">

            </div>
          </div>
        </div>
      </div>
    </section>

  </main>

  <footer>
    <p id="footer">Copyright &copy; <span id="year"></span> <a href="/">Mojtaba Moradli</a>. All Rights Reserved.</p>
  </footer>

  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
  <script>document.getElementById("year").innerHTML = new Date().getFullYear()</script>

</body>

</html>