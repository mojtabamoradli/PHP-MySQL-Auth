<?php 

        require_once('db.php');
        require_once('config.php');

?>

<?php

   // Clean String Values
   function clean ($string) {
       return htmlentities($string);
   }

   // Redirection
   function redirect($location) {
       return header("location:{$location}");
   }

   // Set Session Message
   function set_message($msg) {
       if(!empty($msg)) { $_SESSION['Message'] = $msg;
       } else { $msg="";
       }
   }

   // Display Message Function
   function display_message() {
       if(isset($_SESSION['Message'])) {
            echo $_SESSION['Message'];
            unset($_SESSION['Message']);
       }
   }

   // Generate Token
   function Token_Generator() {
       $token = $_SESSION['token']=md5(uniqid(mt_rand(),true));
       return $token;
   }

   // Send Email Function
   function send_email($email,$sub,$msg,$headers,$email_from) {
       return mail($email,$sub,$msg,$headers,$email_from);
   }

   //*********** User Validation Functions ***********//

   // Errors Function
   function Error_validation($Error) {
       return '<div class="alert alert-danger" style="text-align:center">'.$Error.'</div>';
   }
   



   // User Validation Function
   function user_validation() {
       if($_SERVER['REQUEST_METHOD']=='POST') {

           $FirstName = clean($_POST['FirstName']);
           $LastName = clean($_POST['LastName']);
           $UserName = clean($_POST['UserName']);
           $Email = clean($_POST['Email']);
           $Pass = clean($_POST['pass']);
           $CPass = clean($_POST['cpass']);

           $Errors = [];
           $Max = 20;
           $Min = 03;
           if(strlen($FirstName)<$Min) { $Errors[]= " First Name Cannot Be Less Than {$Min} Characters ";}
           if(strlen($FirstName)>$Max) { $Errors[]= " First Name Cannot Be More Than {$Max} Characters ";}
           if(strlen($LastName)<$Min) { $Errors[]= " Last Name Cannot Be Less Than {$Min} Characters ";}
           if(strlen($LastName)>$Max) { $Errors[]= " Last Name Cannot Be More Than {$Max} Characters ";}

           if(!preg_match("/^[a-zA-Z,0-9]*$/",$UserName)) { $Errors[]= " Username Cannot Contain Those(spaces,...) Characters ";}

           if(Email_Exists($Email)) { $Errors[]= " Email Already Registered! ";}
           if(User_Exists($UserName)) { $Errors[]= " Username Already Registered! ";}

           if($Pass!=$CPass) { $Errors[]= " Password Not Matched! ";}


           if(!empty($Errors)) {
               foreach($Errors as $Error) { echo Error_validation($Error);}
           } else {
                if(user_registration($FirstName,$LastName,$UserName,$Email,$Pass)) {
                    set_message('<div class="alert alert-success" style="text-align:center">Registeration Successful; Please Check Your Email to Activate Your Account.</div>');
                    redirect("./login");
                } else {
                    set_message('<div class="alert alert-danger" style="text-align:center">Registeration Failed! Please Try Again. In case of any problem, please contact contact@mojtabamoradli.ir</div>');
                    redirect("./register");
                }
           }
        }
   }

   // Email Exists Function
   function Email_Exists($email) {
        $sql = " select * from users where Email='$email'";
        $result = Query($sql);
        if(fatech_data($result)) { return true; } 
        else { return false; }
   }

   // User Exists Function
   function User_Exists($user) {
        $sql = " select * from users where UserName='$user'";
        $result = Query($sql);
        if(fatech_data($result)) { return true; }
        else { return false; }
   }

   // User Registration Function
   function user_registration($FName,$LName,$UName,$Email,$Pass) {
        $FirstName = escape($FName);
        $LastName = escape($LName);
        $UserName = escape($UName);
        $Email = escape($Email);
        $Pass = escape($Pass);

        if(Email_Exists($Email)) { return true; }
        else if(User_Exists($UserName)) { return true; }
        else {
            $Password = md5($Pass);
            $Validation_Code = md5($UserName + microtime());
            $sql = "insert into users (FirstName,LastName,UserName,Email,Password,Validation_Code,Active) values ('$FirstName','$LastName','$UserName','$Email','$Password','$Validation_Code','0')";
            $result = Query($sql);
            confirm($result);

            $email_from = 'contact@mojtabamoradli.ir';
            $subject = " Account Activation ";
            $msg = 
            '<html>
<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300;600&display=swap" rel="stylesheet">
<header style="text-align: center;"> <a
        style="  text-decoration: none;  font-family: Dosis;  color: black;font-size: 20px; "
        href="http://localhost">LAMP Authentication</a>

</header>



<body style="    background: radial-gradient(circle, #ffffff 0%, #ffffff 50%);">
    <link rel="stylesheet" href="https://mojtabamoradli.ir/projects/cfm/assets/bootstrap5.0.2/css/bootstrap.min.css">

    <main
        style="background: radial-gradient(circle, #ffffff 0%, #ffffff 50%); padding: 15px; margin: 0.8em auto; border-radius: 10px; box-shadow: 0 10px 30px #c6bebe; z-index: 0; width: 90%;">
        <p style=" font-family: Dosis; color: #000000; text-align: center; font-size: 25px;">Welcome. Click to Activate Your Account</p>
        <div class="row d-flex justify-content-center align-content-center"><a href="http://localhost.ir/activate.php?Email='.$Email."&Code=".$Validation_Code.'";
        style="font-family: Dosis; background-color: #0f1425; padding: 5px; border-width: 5px; border-radius: 8px; border-color: #0f1425; font-size: 20px; color: #0d6efd;"
                class="btn mb-1 btn-md btn-g3 col-md-3">Activate My Account</a>
    </main>
    </div>





</body>

</html>';

            $headers = "From: ".$email_from;
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers = "Content-type:text/html;charset=UTF-8" . "\r\n";

            send_email($Email,$subject,$msg,$headers, "-f$email_from");

            return true;
        }
   }

   //Activation Function
   function activation() {
       if($_SERVER['REQUEST_METHOD']=="GET") {
           $Email = $_GET['Email'];
           $Code = $_GET['Code'];

           $sql = " select * from users where Email='$Email' AND Validation_Code='$Code'";
           $result = Query($sql);
           confirm($result);

            if(fatech_data($result)) {
                $sqlquery = " update users set Active='1', Validation_Code='0' where Email='$Email' AND Validation_Code='$Code'";
                $result2 = Query($sqlquery);
                confirm($result2);
                set_message('<div class="alert alert-success" style="text-align:center">Account Activated Successfully. You can now login to your account.</div>');
                redirect('./login');
            } else {
                echo '<div class="alert alert-danger" style="text-align:center">Account Activation Failed. Please contact contact@mojtabamoradli.ir.</div>';

            }
       }
   }


   //User Login Validation Function
   function login_validation() {
       $Errors = [];

       if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $UserEmail = clean($_POST['UEmail']);
            $UserPass = clean($_POST['UPass']);
            $Remember = isset($_POST['remember']);

            if(empty($UserEmail)) { $Errors[] = " Please Enter Your Email. "; }
            if(empty($UserPass)) { $Errors[] = " Please Enter Your Password. "; }

            if(!empty($Errors)) {
                foreach ($Errors as $Error) { echo Error_validation($Error);
                }
            } else {
                if(user_login($UserEmail,$UserPass,$Remember)) {
                    redirect("./");
                } else {
                    echo Error_validation(" Please Enter Correct Email or Password.");
                }
            }
       }
   }

   // User Login Function
   function user_login($UEmail,$UPass,$Remember) {
        $query = "select * from users where Email='$UEmail' and Active='1'";
        $result = Query($query);

        if($row=fatech_data($result)) {
            $db_pass = $row['Password'];
            if(md5($UPass)==$db_pass) {
                if($Remember == true) {
                    setcookie('email',$UEmail, time() + 86400);
                }
                $_SESSION['Email']=$UEmail;
                return true;
            } else {
                return false;
            }
        }
   }

   //Logged in Function
   function logged_in() {
       if(isset($_SESSION['Email']) || isset($_COOKIE['email'])) {
           return true;
       } else {
           return false;
       }
   }


   //********* Recover Function *********//
   function recover_password() {
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            if(isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {
               $Email = $_POST['UEmail'];

               if(Email_Exists($Email)) {
                    $code = md5($Email.microtime());
                    setcookie('temp_code',$code,time()+300);

                    $sql = "update users set Validation_Code='$code' where Email='$Email'";
                    Query($sql);

                    $email_from = 'contact@mojtabamoradli.ir';
                    $Subject = "Account Recovery Code";
                    $Message = '<html>
<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300;600&display=swap" rel="stylesheet">

<header style="text-align: center;"> <a
        style="  text-decoration: none;  font-family: Dosis;  color: black;font-size: 20px; "
        href="http://localhost">LAMP Authentication</a>
    
</header>



<body style="    background: radial-gradient(circle, #ffffff 0%, #ffffff 50%);">
    <link rel="stylesheet" href="https://mojtabamoradli.ir/projects/cfm/assets/bootstrap5.0.2/css/bootstrap.min.css">

    <main
        style="background: radial-gradient(circle, #ffffff 0%, #ffffff 50%); padding: 15px; margin: 0.8em auto; border-radius: 10px; box-shadow: 0 10px 30px #c6bebe; z-index: 0; width: 90%;">
        <p style=" font-family: Dosis; color: #000000; text-align: center; font-size: 25px;">Please copy the following code and click the button to recover your account.<br></br>'.$code.'</p>
        <div class="row d-flex justify-content-center align-content-center"><a href="http://localhost/code.php?Email='.$Email."&Code=".$code.'";
        style="font-family: Dosis; background-color: #0f1425; padding: 5px; border-width: 5px; border-radius: 8px; border-color: #0f1425; font-size: 20px; color: #0d6efd;"
                class="btn mb-1 btn-md btn-g3 col-md-3">Recover My Account</a>
    </main>
    </div>





</body>

</html>';
                                $headers = "From: ".$email_from;
                                $headers = "MIME-Version: 1.0" . "\r\n";
                                $headers = "Content-type:text/html;charset=UTF-8" . "\r\n";

                    if(send_email($Email,$Subject,$Message,$headers, "-f$email_from")) {
                        echo '<div class="alert alert-success" style="text-align:center"> Please Check Your Email. </div>';
                    } else {
                        echo Error_validation("Recovery Email didn't go through, try again. ");
                    }
               } else {
                   echo Error_validation(" Email Not Found....");
               }
            } else {
                redirect("./");
            }
        }
   }


   // Validation Code Function
   function validation_code() {
       if(isset($_COOKIE['temp_code'])) {
            if(!isset($_GET['Email']) && !isset($_GET['Code'])) {
                redirect("./");
            } else if(empty($_GET['Email']) && empty($_GET['Code'])) {
                redirect("./");
            } else {
                if(isset($_POST['recover-code'])) {
                    $Code = $_POST['recover-code'];
                    $Email = $_GET['Email'];

                    $query = "select * from users where Validation_Code='$Code' and Email='$Email'";
                    $result = Query($query);

                    if(fatech_data($result)) {
                        setcookie('temp_code',$Code, time()+300);
                        redirect("./reset.php?Email=$Email&Code=$Code");
                    } else {
                        echo Error_validation("Wrong Code, try again.");
                    }
                }
            }
       } else {
            set_message('<div class="alert alert-danger" style="text-align:center">Code Expired, Try again.</div>');
           redirect("./recover");
       }
   }


   //********* Reset Password Function *********//

   function reset_password() {
       if(isset($_COOKIE['temp_code'])) {
            if(isset($_GET['Email']) && isset($_GET['Code'])) {
                if(isset($_SESSION['token']) && isset($_POST['token'])) {
                    if($_SESSION['token'] == $_POST['token']) {
                         if($_POST['reset-pass'] === $_POST['reset-c-pass']) {

                                $Password = md5($_POST['reset-pass']);
                                $query2 = "update users set Password='".$Password."', Validation_Code=0 where Email='".$_GET['Email']."'";
                                $result = Query($query2);

                                if($result) {
                                    $_SESSION['message'] = 'success';
                                    redirect('./login');

                                } else {
                                    set_message('<div class="alert alert-danger" style="text-align:center">Something Went Wrong, try again.</div>');

                                }
                         } else {
                            set_message('<div class="alert alert-danger" style="text-align:center">Password Not Matched.</div>');

                         }
                    }
                }
            } else {
                set_message('<div class="alert alert-danger" style="text-align:center">Recovery Code or Email Not Matched.</div>');

            }
       } else {
           set_message('<div class="alert alert-danger" style="text-align:center">Your Time Period Has Been Expired.</div>');

       }
   }
?>














