


<?php 



    $con = mysqli_connect('localhost','YOUR_MYSQL_DB_USER_NAME','YOUR_MYSQL_DB_PASSWORD','YOUR_MYSQL_DB_NAME');




    // Function Clean String Values
    function escape($string) {
        global $con;
        return mysqli_real_escape_string($con,$string);
    }

    // Query Function
    function Query($query) {
        global $con;
        return mysqli_query($con,$query);
    }

    // Confirmation Function
    function confirm($result) {
        global $con;
        if(!$result) { die('Query Failed'.mysqli_error($con));
        }
    }

    // Fatech Data From Database
    function fatech_data($result){
        return mysqli_fetch_assoc($result);
    }

    // Row Values From Database
    function row_count($count) {
        return mysqli_num_rows($count);
    }



?>
