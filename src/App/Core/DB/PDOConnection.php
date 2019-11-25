<?php


namespace App\Core\DB;

use App\Core\Config;
use \PDO;

class PDOConnection implements IConnection
{

    private $conn;

    public function __construct()
    {
        $host = Config::get('mysql.host');
        $dbName = Config::get('mysql.name');
        $user = Config::get('mysql.user');
        $pass = Config::get('mysql.password');
        $dsn = "mysql:host=$host;dbname=$dbName";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->conn = new PDO($dsn, $user, $pass, $opt);
    }

    /**
     * @param $sql
     * @param array $data
     * @return array|bool
     */
    public function query($sql, $data = [])
    {
        if (!empty($data)) {
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute($data);
        } else {
            $result = $this->conn->query($sql);
        }

        if (is_bool($result) || !$result->columnCount()) {
            return $result;
        }

        return $result->fetchAll();
    }

    /**
     * @param $data
     * @return string
     */
    public function escape($data)
    {
        return $this->conn->quote($data);
    }
}
