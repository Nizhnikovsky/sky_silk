<?php

namespace App\Core;


class Mail
{

    public static function sendRegisterMail($to,$userId)
    {
        $uri = $_SERVER['HTTP_HOST'].'/register/activate';
        $subject = "Заголовок письма";
        $code = generate_code();
        $fullUri = $uri.'?'.'code='.$code.'&id='.$userId;

        $message = ' <p>Для потдверждения регистрации перейдите посылке'.$fullUri.'</p>';

        $headers  = "Content-type: text/html; charset=UTF-8 \r\n";
        $headers .= "From:<admin@example.com>\r\n";
        $headers .= "Reply-To: admin@example.com\r\n";

        dd(mail($to, $subject, $message, $headers));
    }
}
