<?php
    $myemail = "masih@optt.ca";
    $mypass = "223";

    if(isset($_POST['login'])){
        $email = $_POST['email'];
        $pass = $_POST['password'];
        if ($email == $myemail and $pass == $mypass) {
            setcookie('email', $email, time()+60*60*24);
            session_start();
            $_SESSION['email'] = $email;
            header("location: welcome.php");

        } else{
            echo "Invalid Login. <br> Click here to 
            <a href='login.php'>
            retry</a>
            ";
        }

    }
    else{
        header("location: login.php");
    }
?>