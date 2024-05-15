<?php 
session_start();
include('includes/functions.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!empty($_POST)){
    $uname = mysqli_real_escape_string($db, $_POST['uname']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if(empty($uname) || empty($password)){
        echo 'Please provide all fields';
    }else{
        $where = [
            'username'=>$uname
        ];

        $result = fetchData('users', '*', $where,$db);
        if(!empty($result)){
            $db_pass = $result[0]['passwd'];
            if (password_verify($password, $db_pass)) {
                echo 1;
            }else{
                echo 'Sorry your password is wrong for username '.$uname;
            }
        }else{
            echo 'Sorry your username is invalid please enter valid username';
        }
    }

    }else{
    echo 'Something Went Wrong';
    }

    }else{
    $_SESSION['error'] = 'You are not allow to access';
    header('location:'.site_url);
}

?>