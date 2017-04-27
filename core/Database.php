<?php

namespace Core;

use Exception;
use PDO;

class Database
{
    private $_pdo;

    private $_query;

    private $_sql;

    private $_error = false;

    private $_results;

    private $_count = 0;

    private $_by = '';

    private $_order = 'ASC';

    private $_limit = 0;

    private $_offset = 0;

    public function __construct($dbinfo = [])
    {
        if (is_null($this->_pdo)) {
            if (!empty($dbinfo)) {
                $this->_pdo = new PDO('mysql:host='.$dbinfo['host'].
                    ';dbname='.$dbinfo['dbname'],
                    $dbinfo['user'], $dbinfo['pass']);
            } else {
                $this->_pdo = new PDO('mysql:host='.env('DB_HOST').
                    ';dbname='.env('DB_NAME'),
                    env('DB_USER'), env('DB_PASS'));
            }
        }
    }

    public function setLimit($limit)
    {
        $this->_limit = $limit;

        return $this;
    }

    public function setOffset($offset)
    {
        $this->_offset = $offset;

        return $this;
    }

    public function orderBy($by, $order = 'ASC')
    {
        $this->_by = $by;
        $this->_order = $order;

        return $this;
    }

    public function query($sql, array $values = [])
    {
        $this->_error = false;
        $this->_query = $this->_pdo->prepare($sql);
        $this->_query->setFetchMode(PDO::FETCH_OBJ);

        $x = 1;
        if (count($values)) {
            foreach ($values as $value) {
                $this->_query->bindValue($x, $value);
                $x++;
            }
        }

        $this->_sql = $sql;

        if ($this->_query->execute()) {
            $this->_results = $this->_query->fetchAll();
            $this->_count = $this->_query->rowCount();
        } else {
            $this->_error = true;
        }

        return $this;
    }

    public function select($table, array $params = [])
    {
        return $this->action('SELECT *', $table, $params);
    }

    public function action($action, $table, array $params = [])
    {
        $append = '';
        switch ($action) {
            case 'SELECT *':
            if (!empty($this->_by)) {
                $append .= ' ORDER BY `'.$this->_by.'` '.$this->_order;
            }

            if ($this->_limit > 0) {
                $append .= ' LIMIT '.$this->_limit;
                $append .= ' OFFSET '.$this->_offset;
            }
            break;
        }

        if (count($params) == 3) {
            $ops = ['=', '>', '<', '>=', '<=', 'LIKE'];

            $field = $params[0];
            $op = $params[1];
            $value = $params[2];

            if (in_array($op, $ops)) {
                $sql = "$action FROM `$table` WHERE $field $op ?$append";

                if (!$this->query($sql, [$value])->error()) {
                    return $this;
                }
            }
        } elseif (count($params) == 0) {
            $sql = "$action FROM `$table`$append";

            if (!$this->query($sql)->error()) {
                return $this;
            }
        }

        return false;
    }

    public function count()
    {
        return $this->_count;
    }

    public function all()
    {
        return $this->_results;
    }

    public function first()
    {
        return $this->_results[0];
    }

    public function error()
    {
        return $this->_error;
    }
}
