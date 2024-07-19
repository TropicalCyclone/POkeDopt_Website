<?php

    require '../config/db_connect.php';

    $errorMessage = '';
    $errors = array(
        'email' => '',
        'password' => '',
    );

    if (isset($_POST['signIn'])) {

        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
        }
        
        // Select Pokemon Data
        $query = "SELECT * FROM account WHERE email = '$email'";

        // SQL Check
        if (!mysqli_query($conn, $query)) {
            die('Query error: ' . mysqli_error($conn));
        } else {
            // Make Query & Get Result
            $result = mysqli_query($conn, $query);

            // Fetch the Resulting Rows as an Array
            $user = mysqli_fetch_all($result, MYSQLI_ASSOC);

            // Free results From Memory
            mysqli_free_result($result);
        }

        // Close Connection
        mysqli_close($conn);

        if (empty($user[0]['username'])) {
            $errors['username'] = 'Incorrect username\n';
        }

        if (!password_verify($password, $user[0]['password'])) {
            $errors['password'] = 'Incorrect password\n';
        }

        if (array_filter($errors)) {

            foreach (array_filter($errors) as $error) {
                $errorMessage .= $error;
            }

            if (isset($_SESSION['userID'])) {
                session_unset();
                session_destroy();
            }
    
            echo "<script>alert('$errorMessage');</script>";
            header('Refresh: 0; URL=../pages/guest.php');
            exit;

        } else {
    
            session_start();
        
            if(isset($_POST['remember'])) {
                setcookie("userID", $user['0']['id'], time()+30*24*60*60, "/", "");
            } else {
                $_SESSION['userID'] = $user['0']['id'];

            }

            header('Refresh: 0; URL=../pages/pokedopt.php');
            exit;

        }

    }

?>