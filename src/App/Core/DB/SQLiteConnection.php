<?php


namespace App\Core\DB;

use App\Core\Config;

class SQLiteConnection implements IConnection
{

    private $conn;

    public function __construct()
    {
        $this->conn = new \SQLite3(Config::get('sqlite.filename'));
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

            foreach ($data as $key => $value)
            {
                $stmt->bindValue(':'.$key,$value);
            }

            $result = $stmt->execute()->finalize();
        } else {
            $result = $this->conn->query($sql);
        }

        if (is_bool($result) || !$result->numColumns()) {
            return $this->conn->lastInsertRowID();
        }

        return $result->fetchArray(SQLITE3_ASSOC);
    }

    /**
     * @param $data
     * @return string
     */
    public function escape($data)
    {
        return $this->conn::escapeString($data);
    }

}
