<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Class\SessionClass;
use App\Class\RegisterClass;
use App\Class\LoginClass;
use Laminas\Diactoros\Response\RedirectResponse;

class HomeController extends DefaultController
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return $this->renderTemplate('index.php', []);
    }

    public function error(ServerRequestInterface $request): ResponseInterface
    {
        return $this->renderTemplate('404.php', []);
    }

    public function register(ServerRequestInterface $request): ResponseInterface
    {
        $obj = new SessionClass();
        $redirectResponse = $obj->checkLogin();
        
        if ($redirectResponse instanceof \Laminas\Diactoros\Response\RedirectResponse) {
            return $redirectResponse;
        }

        if (!empty($_POST)) {
            $obj = new RegisterClass();
            
            $obj = new RegisterClass();
            $res = $obj->register($request);

            if (isset($_SESSION['message'])) {
                // If registration was successful, redirect to login
                return new RedirectResponse('/login');
            } else {
                // If registration was unsuccessful, redirect to register
                return new RedirectResponse('/register');
            }
        }

        return $this->renderTemplate('Sign-Up.php', []);
    }

    public function login(ServerRequestInterface $request): ResponseInterface
    {
        $obj = new SessionClass();
        $redirectResponse = $obj->checkLogin();

        if ($redirectResponse instanceof \Laminas\Diactoros\Response\RedirectResponse) {
            return $redirectResponse;
        }

        if (!empty($_POST)) {
            $obj = new LoginClass();
            $obj->login();

            if (isset($_SESSION['user'])) {
                return new \Laminas\Diactoros\Response\RedirectResponse('/profile');
                exit();
            }

            return new \Laminas\Diactoros\Response\RedirectResponse('/login');
        }

        return $this->renderTemplate('Log-In.php', []);
    }

    public function profile(ServerRequestInterface $request): ResponseInterface
    {
        $obj = new SessionClass();
        $redirectResponse = $obj->checkProfile();
        
        if ($redirectResponse instanceof \Laminas\Diactoros\Response\RedirectResponse) {
            return $redirectResponse;
        }

        $user = $obj->get();

        return $this->renderTemplate('Profile.php', ['user' => $user]);
    }

    public function logout(ServerRequestInterface $request): ResponseInterface
    {
        $obj = new SessionClass();
        $obj->destroy();

        return new \Laminas\Diactoros\Response\RedirectResponse('/login');
    }

   
}