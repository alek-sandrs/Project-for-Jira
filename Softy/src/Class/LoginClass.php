<?php

namespace App\Class;

use App\DatabaseConnection;
use App\Class\SessionClass;

class LoginClass
{
    public function login() 
    {
        $obj = new DatabaseConnection();
        $conn = $obj->getConnection();

        $username = $_POST['username'];
        $email = isset($_POST['email']) ? $_POST['email'] : $_POST['username'];
        $password = $_POST['password'];

        if (!empty($username) && !empty($email) && !empty($password)) {
            $sql = "SELECT * FROM users WHERE username = '$username' OR email = '$username'";

            if ($conn->query($sql)->rowCount() > 0) {
                if ($row = $conn->query($sql)->fetch()) {
                    if (password_verify($password, $row['password'])) {
                        $obj = new SessionClass();
                        $obj->set($row);

                        $_SESSION['message'] = 'You are now logged in!';

                        return new \Laminas\Diactoros\Response\RedirectResponse('/profile');
                    } else {
                        $_SESSION['error'] = 'Wrong password!';

                        return new \Laminas\Diactoros\Response\RedirectResponse('/login');
                    }
                }
            } else {
                $_SESSION['error'] = 'There is no such user!';

                return new \Laminas\Diactoros\Response\RedirectResponse('/login');
            }
        } else {
            $_SESSION['error'] = 'Please fill in all the fields!';

            return new \Laminas\Diactoros\Response\RedirectResponse('/login');
        }
    }
}