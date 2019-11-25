<?php


namespace App\Entity;


use App\Validators\UserValidator;

class User extends Base
{
    function getTableName()
    {
        return 'users';
    }

    function checkFields($data)
    {
        UserValidator::validateEmail($data['email']);
        UserValidator::validateUserName($data['login']);
    }

    function getFields()
    {
        return [
            'login',
            'email',
            'password',
            'active'
        ];
    }

}
