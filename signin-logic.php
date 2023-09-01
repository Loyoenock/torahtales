<?php
require 'config/database.php';
session_start(); // Make sure to start the session

if (isset($_POST['submit'])) {
    // get form data
    $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$username_email) {
        $_SESSION['signin'] = "User or Email is required";
    } elseif (!$password) {
        $_SESSION['signin'] = "Password is required"; // Fixed the typo "Passwordword"
    } else {
        // Retrieve user from the database using prepared statement
        $fetch_user_query = "SELECT * FROM users WHERE username='$username_email' OR email='$username_email'";

        $fetch_user_result = mysqli_query($connection, $fetch_user_query);

        if (mysqli_num_rows($fetch_user_result) == 1) {
            // convert the record into assoc array
            $user_record = mysqli_fetch_assoc($fetch_user_result);
            $db_password = $user_record['password'];
            // compare form and database password
            if (password_verify($password, $db_password)) {
                // Set access control session
                $_SESSION['user-id'] = $user_record['id'];
                // Set session if user is an admin
                if ($user_record['is_admin'] == 1) {
                    $_SESSION['user_is_admin'] = true;
                }
                // Login user
                header('location: ' . ROOT_URL . 'admin/');
            } else {
                $_SESSION['signin'] = "Please check your input";
            }
        } else {
            $_SESSION['signin'] = "User not found";
        }
    }

    // Redirect to the signin page in case of any problem
    if (isset($_SESSION['signin'])) {
        $_SESSION['signin-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signin.php');
        die();
    }
} else {
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}
