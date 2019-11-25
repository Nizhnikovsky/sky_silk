<?php


namespace App\Controllers;


use App\Core\App;
use App\Entity\User;
use App\Repositories\UserRepository;
use App\Validators\UserValidator;

class RegisterController extends BaseController
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
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $this->validateInput();
                $this->userRepository->storeUser($this->data);
            } catch (\Exception $e) {
                App::getSession()->addFlash($e->getMessage());
            }
        }
    }

    public function activateAction()
    {
        $data = $_GET;
        $userHash = $data['code'];
        $hash = generate_code();
        $userId = $data['id'];
        if ($hash == $userHash)
        {
            $this->userRepository->activateUser($userId);
        }
        App::getSession()->addFlash("Given user data aren't valid");
        App::getRouter()->redirect(
            App::getRouter()->buildUri('index')
        );
    }

    private function validateInput()
    {
       if (!UserValidator::validateUserData())
       {
           App::getSession()->addFlash("Given user data aren't valid");
           App::getRouter()->redirect(
               App::getRouter()->buildUri('index')
           );
       }else{
           $this->data = UserValidator::validateUserData();
       }
    }
}
