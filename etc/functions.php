<?php


function __($code, $default = '')
{
    return \App\Core\Localization::get($code, $default);
}

function pre($data)
{
    echo '<pre>', print_r($data, 1), '</pre>';
}

function dd($data)
{
    var_dump($data);
    die();
}

function generate_code()
{
    return md5(date('Y-m-d').\App\Core\Config::get('hash'));
}
