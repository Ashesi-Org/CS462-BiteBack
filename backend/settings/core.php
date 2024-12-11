<?php 

session_start();

if (!function_exists('login')) {
    function login() {
        if (!isset($_SESSION['user_id'])) {
            // If session is not set then redirect to Login Page
            header('Location: ../login/login.php');
            exit();
        }
    }
}

if (!function_exists('getUserRole')) {
    function getUserRole() {
        if (isset($_SESSION['user_role'])) {
            // Return the user role ID
            return $_SESSION['user_role'];
        } else {
            return FALSE;
        }
    }
}

// Call the login function to ensure user is logged in
login();


// session_start();

// function login(){
//     if(!isset($_SESSION['user_id'])) {
//         $rid =$_SESSION['user_id'];
//         echo $rid;// debugging

//         // If session is not set then redirect to Login Page
//         header('Location:../login/login.php');
//         die();
//     }
// }

// login();

// function getUserRole() {
//     if (isset($_SESSION['user_role'])) {
//         // Return the user role ID
//         return $_SESSION['user_role'];
//     } else {
//         return FALSE;
//     }
// }

// // Echo the user role
// $userRole = getUserRole();
// if ($userRole !== FALSE) {
//     echo $userRole;
// }

// ?>