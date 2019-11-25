<?php

namespace App\Core\DB;



use App\Core\Config;

class Connection
{

    public static function getConnection()
    {
        switch (Config::get('db')) {
            case 'sqlite':
                return new SQLiteConnection();
                break;
            case 'mysql':
                return new PDOConnection();
                break;
            default :
                return new PDOConnection();
        }
    }

}
