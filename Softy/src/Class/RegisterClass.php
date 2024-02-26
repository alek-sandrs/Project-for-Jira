<?php

namespace App\Class;

use App\DatabaseConnection;
use Laminas\Diactoros\Response\RedirectResponse;

class RegisterClass 
{
    public function register()
    {   
        if (!empty($_POST)) {
            $obj = new DatabaseConnection();
            $conn = $obj->getConnection();

            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            $sql = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";

            if (empty($username) && empty($password) && empty($confirm_password)) {
                $_SESSION['error'] = 'Please fill in all the fields!';
                return new RedirectResponse('/register');
                exit();
            }

            if (strlen($username) < 5) {
                $_SESSION['error'] = 'Username must be at least 5 characters long!';
                return new RedirectResponse('/register');
                exit();
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Invalid email format!';
                return new RedirectResponse('/register');
                exit();
            }
            
            if (strlen($password) < 8 || strlen($confirm_password) < 8) {
                $_SESSION['error'] = 'Password must be at least 8 characters long!';
                return new RedirectResponse('/register');
                exit();
            }

            if ($conn->query($sql)->rowCount() > 0){
                $_SESSION['error'] = 'Username already exists!';
                return new RedirectResponse('/register');
                exit();
            }

            if ($password === $confirm_password) {
                $obj = new DatabaseConnection();
                $conn = $obj->getConnection();
                
                $sql = "SELECT * FROM users";
                if ($conn->query($sql)->rowCount() === 0) {
                    $isAdmin = 1;
                } else {
                    $isAdmin = 0;
                }

                $password = password_hash($password, PASSWORD_DEFAULT);
                $registerDate = date('Y-m-d H:i:s');

                $sql = "INSERT INTO users (username, email, password, registrationDate, isAdmin) VALUES ('$username', '$email', '$password', '$registerDate', '$isAdmin')";
                $conn->exec($sql);

                $_SESSION['message'] = 'You have successfully registered!';
                return new RedirectResponse('/login');
            } else {
                $_SESSION['error'] = 'Passwords do not match!';
                return new RedirectResponse('/register');
                exit();
            }
        }
    }
}