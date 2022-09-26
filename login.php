<?php
require_once('./functions/config.php');
require_once('./functions/functions.php');
require_once('./functions/db.php');
?>


<?php
if (logged_in()) {
  session_start();
  $Email = $_POST['Email'];
  $Pass = $_POST['pass'];
  $query = mysqli_query($con, "SELECT * FROM `users` WHERE `Email` = '$Email' AND `pass` = '$Pass'");
  $_SESSION['FirstName'] = $fetch['FirstName'];
  $_SESSION['LastName'] = $fetch['LastName'];
} else {
}
?>

<?php
if (logged_in()) {
  redirect('./');
} else {
}
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
  <title>Login</title>
</head>

<body>
  <header>
    <h1 id="name"><a href="./"><span>LAMP</span> Authentication</a></h1>
  </header>

  <main>



    <div id="nav"><a id="homebutton" href="./">Home</a>&nbsp&nbsp&nbsp&nbsp <a id="registerbutton" href="./register"><span style="color:black" ;>Don't have an account?</span> Register</a></div>


    <?php

    // if (!empty($_SESSION['message'])) {
    //   echo "<div class='alert alert-success' style='text-align:center'>Password Updated.</div>";
    //   unset($_SESSION['message']);
    // }

    // display_message();
    // login_validation();
    ?>

    <section class="vh-10 ">
      <div class=" py-3 h-80">
        <div class="row d-flex justify-content-center align-items-center h-10">
          <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card-body p-1 text-center">

              <h3 class="mb-1  text-uppercase">Login</h3>
              <h5 class="mb-5 ">Please enter your email and password.</h5>
              <form method="POST">
                <div class="form-outline mb-2">
                  <input type="email" name="UEmail" class="form-control form-control-lg" placeholder="Email" />
                </div>

                <div class="form-outline mb-4">
                  <input type="password" name="UPass" class="form-control form-control-lg" placeholder="Password" />
                </div>

                <div class="form-check d-flex justify-content-start mb-4">
                  <input class="form-check-input" type="checkbox" name="remember" id="rememberme" />
                  <label class="form-check-label" for="rememberme"> Remember Me </label>
                </div>

                <button id="btn-dark" class="btn float-right mb-5">Login</button>
                <p id="forget"><a href="./recover">Forget Password</a></p>
              </form>
            </div>
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