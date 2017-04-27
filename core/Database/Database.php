<?php

namespace Core\Database;

use Exception;
use PDO;

class Database
{
    /**
     * PDO instance.
     *
     * @var \PDO
     */
    private $_pdo;

    /**
     * Prepared query object.
     *
     * @var \PDOStatement
     */
    private $_query;

    /**
     * SQL string.
     *
     * @var string
     */
    private $_sql;

    /**
     * Last error.
     *
     * @var bool
     */
    private $_error = false;

    /**
     * Array of query results.
     *
     * @var array
     */
    private $_results;

    /**
     * Result count.
     *
     * @var int
     */
    private $_count = 0;

    /**
     * What key to order a result by.
     *
     * @var string
     */
    private $_by = '';

    /**
     * What order to order results by.
     *
     * @var string
     */
    private $_order = 'ASC';

    /**
     * Query limit.
     *
     * @var int
     */
    private $_limit = 0;

    /**
     * Query offset.
     *
     * @var int
     */
    private $_offset = 0;

    /**
     * Ctor.
     *
     * @return void
     */
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

    /**
     * Sets a query limit.
     *
     * @param int $limit
     *
     * @return \Core\Database
     */
    public function setLimit($limit)
    {
        $this->_limit = $limit;

        return $this;
    }

    /**
     * Sets query offset.
     *
     * @param int $offset
     *
     * @return \Core\Database
     */
    public function setOffset($offset)
    {
        $this->_offset = $offset;

        return $this;
    }

    /**
     * Sets what to order results by and it's order.
     *
     * @param string $by
     * @param string $order
     *
     * @return \Core\Database
     */
    public function orderBy($by, $order = 'ASC')
    {
        $this->_by = $by;
        $this->_order = $order;

        return $this;
    }

    /**
     * Runs a SQL query.
     *
     * @param string $sql
     * @param array  $values
     *
     * @return mixed
     */
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

    /**
     * Runs an insert query.
     *
     * @param string $table
     * @param array  $fields
     *
     * @return bool
     */
    public function insert($table, array $fields = [])
    {
        $keys = array_keys($fields);
        $values = '';

        foreach ($fields as $field) {
            $values .= '?, ';
        }

        $values = rtrim($values, ', ');
        $sql = "INSERT INTO `$table` (`".implode('`, ', $keys)."`) VALUES ($values)";

        if (!$this->query($sql, $fields)->error()) {
            return true;
        }

        return false;
    }

    /**
     * Runs a select query.
     *
     * @param string $table
     * @param array  $params
     *
     * @return mixed
     */
    public function select($table, array $params = [])
    {
        return $this->action('SELECT *', $table, $params);
    }

    /**
     * Updates a row within the table.
     *
     * @param string $table
     * @param array  $where
     * @param array  $fields
     *
     * @return bool
     */
    public function update($table, array $where, array $fields = [])
    {
        $set = '';
        foreach ($fields as $key => $value) {
            $set .= "$key = ?, ";
        }

        $set = rtrim($set, ', ');
        $sql = "UPDATE `$table` SET $set WHERE `{$where[0]}` = {$where[1]}";

        if (!$this->query($sql, $fields)->error()) {
            return true;
        }

        return false;
    }

    /**
     * Deletes a row.
     *
     * @param string $table
     * @param array  $params
     *
     * @return mixed
     */
    public function delete($table, array $params)
    {
        return $this->action('DELETE', $table, $params);
    }

    /**
     * Generates a SQL action to be executed by query().
     *
     * @param string $action
     * @param string $table
     * @param array  $params
     *
     * @return mixed
     */
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

    /**
     * Gets the number of results
     *
     * @return int
     */
    public function count()
    {
        return $this->_count;
    }

    /**
     * Gets all the results from the query.
     *
     * @return array
     */
    public function all()
    {
        return $this->_results;
    }

    /**
     * Gets the first item in results array.
     *
     * @return mixed
     */
    public function first()
    {
        return $this->_results[0];
    }

    /**
     * Gets the error of the last sql call.
     *
     * @return bool
     */
    public function error()
    {
        return $this->_error;
    }
}
