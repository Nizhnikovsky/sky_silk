<?php

namespace App\Controllers;


use App\Entity\User;
use App\Core\App;
use App\Repositories\UserRepository;

class LoginController extends BaseController
{

    /** @var User */
    private $userRepository;

    public function __construct($params = [])
    {
        parent::__construct($params);

        $this->userRepository = new UserRepository();
    }


    public function indexAction()
    {
        $session = App::getSession();

        if ($session->get('user_id')) {
            App::getRouter()->redirect(
                App::getRouter()->buildUri('account.index')
            );
        }
    }

    public function authAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {

                $login = $_POST['login'];
                $password = $_POST['password'];
                $this->userRepository->authUser($login, $password);
            } catch (\Exception $e) {
                App::getSession()->addFlash($e->getMessage());
            }
        }
    }

    public function logoutAction()
    {
        $session = App::getSession();
        $session->unset('user_id');
        App::getRouter()->redirect(
            App::getRouter()->buildUri('index')
        );
    }
}
