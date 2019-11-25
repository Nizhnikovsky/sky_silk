<?php

namespace App\Controllers;


use App\Core\App;
use App\Entity\User;
use App\Repositories\UserRepository;

class AccountController extends BaseController
{

    /** @var User */
    private $userRepository;

    private $session;

    private $userId;

    public function __construct($params = [])
    {
        parent::__construct($params);

        $this->userRepository = new UserRepository();
        $this->session = App::getSession();
        $this->userId = $this->session->get('user_id');
    }


    public function indexAction()
    {
        $this->redirectIfNotLogged();
        $user = $this->userRepository->getUserById($this->userId);
        $this->data = $user;
    }


    public function editAction()
    {
        $this->redirectIfNotLogged();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $this->data = [
                    'login' => $_POST['login'],
                    'password' => $_POST['password'],
                    'email' => $_POST['email'],
                ];

                $this->userRepository->editUser($this->data, $this->userId);

                App::getSession()->addFlash('User has been edited successfully');
                App::getRouter()->redirect(
                    App::getRouter()->buildUri('index')
                );

            } catch (\Exception $e) {
                App::getSession()->addFlash($e->getMessage());
            }
        }

        if ($this->userId) {
            $this->data = $this->userRepository->getUserById($this->userId);
        }
    }

    private function redirectIfNotLogged()
    {
        if (!$this->userId)
        {
            App::getSession()->addFlash('You are not logged in. Please log in or register');
            App::getRouter()->redirect(
                App::getRouter()->buildUri('login.index')
            );
        }
    }
}
