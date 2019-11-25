<?php


namespace App\Validators;


class UserValidator
{
    const USER_ARRAY = [
        'login'   => FILTER_SANITIZE_ENCODED,
        'email'     => FILTER_VALIDATE_EMAIL,
        'password' => FILTER_SANITIZE_ENCODED,
    ];


    public static function validateUserName($userName)
    {
        if (!is_string($userName) || !strlen($userName) ) {
            throw new \Exception('Username field can\'t be empty');
        }
        return true;
    }

    public static function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Email field can\'t be empty');
        }

        return true;
    }

    public static function validateUserData()
    {
        $data = filter_input_array(INPUT_POST, self::USER_ARRAY);

        return in_array(false,$data)? false : $data;
    }
}
