<?php
// require_once('./functions/functions.php');
// require_once('./functions/config.php');
// require_once('./functions/db.php');
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css" />
    <title>LAMP Authentication System</title>
</head>


<body>

<header>
        <h1 id="name"><a href="./"><span>LAMP</span> Authentication</a></h1>
    </header>



    <main>



<div id="nav"><a title="Register" id="registerbutton" href="./register">Register</a><strong>/</strong><a title="Login" id="loginbutton" href="./login">Log In</a></div></div>













        <div class="tab-pane fade show active container" id="home" role="tabpanel" aria-labelledby="home-tab">



            <p id="home-txt">Linux, Apache, MySQL, PHP Authentication System</p>




        </div>



    </main>

    <footer>
        <p id="footer">Copyright &copy; <span id="year"></span> <a title="Mojtaba Moradli" href="/">Mojtaba Moradli</a>. All Rights Reserved.</p>
    </footer>

    <script>document.getElementById("year").innerHTML = new Date().getFullYear()</script>




</body>

</html>