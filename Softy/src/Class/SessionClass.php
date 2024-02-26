<?php

namespace App\Class;

class SessionClass
{
    public function set($row) 
    {
        $_SESSION['user'] = [
            'id' => $row['id'],
            'username' => $row['username'],
            'email' => $row['email'],
            'isAdmin' => $row['isAdmin'],
        ];
    }

    public static function get() 
    {
        return $_SESSION['user'];
    }

    public function destroy()
    {
        unset($_SESSION['user']);
    }

    public function checkProfile()
    {
        if (!isset($_SESSION['user'])) {
            return new \Laminas\Diactoros\Response\RedirectResponse('/register');
        }
    }

    public function checkLogIn()
    {
        if (isset($_SESSION['user'])) {
            return new \Laminas\Diactoros\Response\RedirectResponse('/profile');
        }
    }

    public function checkAdmin()
    {
        if (!isset($_SESSION['user'])) {
            return new \Laminas\Diactoros\Response\RedirectResponse('/login');
        }

        if ($_SESSION['user']['isAdmin'] != 1) {
            return new \Laminas\Diactoros\Response\RedirectResponse('/profile');
        }
    }
    
}