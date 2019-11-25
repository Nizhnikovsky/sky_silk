<?php

namespace App\Entity;


abstract class Base
{

    /** @var \App\Core\DB\IConnection */
    protected $conn;


    abstract function getTableName();

    abstract function checkFields($data);

    abstract function getFields();


    /**
     * Base constructor.
     * @param \App\Core\DB\IConnection $connection
     */
    public function __construct(\App\Core\DB\IConnection $connection)
    {
        $this->conn = $connection;
    }


    public function query(string $sql, array $params)
    {
        return $this->conn->query($sql, $params);
    }

    public function __call($name, $arguments)
    {
        $field = strtolower(substr($name, strlen($name) - 5));
        $whereValue = array_pop($arguments);

        $sql = "SELECT * FROM " . $this->getTableName() . " WHERE " . $field . " = '" . $whereValue . "'";

        return $this->conn->query($sql);
    }

    /**
     * @param array $filter
     * @return mixed
     */
    public function list($filter = [])
    {
        $fields = $this->getFields();
        $where = [];
        $strWhere = '';
        foreach ($filter as $fieldName => $value) {
            if (!in_array($fieldName, $fields)) {
                continue;
            }

            $value = $this->conn->escape($value);
            $where[] = "$fieldName = $value";
        }

        if (!empty($where)) {
            $strWhere = ' AND ' . implode(' AND ', $where);
        }


        $sql = 'SELECT * FROM ' . $this->getTableName() . ' WHERE 1 ' . $strWhere;

        return $this->conn->query($sql);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        $sql = 'SELECT * FROM ' . $this->getTableName() . ' WHERE id = ' . $this->conn->escape($id) . ' LIMIT 1';
        $result = $this->conn->query($sql);

        return isset($result[0]) ? $result[0] : $result;
    }


    /**
     * @param $data
     * @param null $id
     * @return mixed
     */
    public function save($data)
    {
        $this->checkFields($data);

        $values = [];
        foreach ($data as $key => $val) {
            if (!in_array($key, $this->getFields())) {
                unset($data[$key]);
                continue;
            }
            $this->conn->escape($val);
            $values[] = $val;
        }

        $cols = implode(',', array_keys($data));
        $vals = $this->prepareData($cols);
        $sql = "INSERT INTO " . $this->getTableName() . " ($cols) VALUES ($vals)";

        return $this->conn->query($sql, $data);
    }

    public function update(array $data, $id)
    {
        $values = [];

        foreach ($data as $key => $val) {
            if (!in_array($key, $this->getFields())) {
                unset($data[$key]);
                continue;
            }

            $this->conn->escape($val);
            $values[] = "$key = :".$key;
        }

        $values = implode(',', $values);
        $data['id'] = $id;
        $sql = "UPDATE " . $this->getTableName() . " SET $values WHERE id = :id";

        return $this->conn->query($sql, $data);
    }

    private function prepareData(string $data)
    {
        $data = explode(',', $data);
        $data = array_map(function ($el) {
            return ':' . $el;
        }, $data);

        return implode(',', $data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $id = intval($id);

        $sql = 'DELETE FROM ' . $this->getTableName()
            . ' WHERE id = ' . $this->conn->escape($id);

        return $this->conn->query($sql);
    }

}
