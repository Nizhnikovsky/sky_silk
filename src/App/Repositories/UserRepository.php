<?php


namespace App\Repositories;


use App\Core\App;
use App\Core\Mail;
use App\Entity\User;
use App\Validators\UserValidator;

class UserRepository extends AbstractRepository
{

    const ACTIVE_USER = 1;
    const DISABLED_USER = 0;

    private $userModel;

    public function __construct()
    {
        $this->userModel = new User(App::getConnection());
    }


    public function authUser($login,$password)
    {
        $user = $this->userModel->getByLogin($login);
        $user = isset($user[0])? $user[0]: $user;
        if (!$user)
        {
            $this->setFlash("Incorrect login or password",'index');
        }

        if ($this->checkPassword($password,$user['password']))
        {
            $user['active']? $this->setSession($user['id']) :
                $this->setFlash("Account doesn't verified",'index');
        }
        $this->setFlash("Email or Password is incorrect",'index');
    }

    public function getUserById($userId)
    {
        return $this->userModel->getById($userId);
    }

    public function storeUser($userData)
    {
        $password = password_hash($userData['password'], PASSWORD_BCRYPT);
        $userData['password'] = $password;

        try{
            $userId = $this->userModel->save($userData);
            Mail::sendRegisterMail($userData['email'],$userId);

        }catch (\Exception $e)
        {
            throw new \Exception($e->getMessage(),$e->getCode());
        }
    }

    public function activateUser($userId)
    {
        $this->userModel->update(['active' => self::ACTIVE_USER],$userId);
        App::getSession()->addFlash("Account successfully activated");
        $this->setSession($userId);
    }

    public function editUser($userData,$userId)
    {
        $password = password_hash($userData['password'], PASSWORD_BCRYPT);
        $userData['password'] = $password;
        unset($userData['id']);

        try{
            $this->userModel->update($userData,$userId);
        }catch (\Exception $e)
        {
            throw new \Exception($e->getMessage(),$e->getCode());
        }
    }

    private function setFlash($message,$uri)
    {
        App::getSession()->addFlash($message);
        App::getRouter()->redirect(
            App::getRouter()->buildUri($uri)
        );
    }

    private function setSession($userId)
    {
        App::getSession()->set("user_id",$userId);
        App::getRouter()->redirect(
            App::getRouter()->buildUri('account.index')
        );
    }

    private function checkPassword($givenPassword,$userPassword)
    {
        return password_verify($givenPassword,$userPassword);
    }
}
