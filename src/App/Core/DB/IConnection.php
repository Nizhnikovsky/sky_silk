<?php

namespace App\Core\DB;

interface IConnection
{
    public function query($sql, $data = []);

    public function escape($data);
}
