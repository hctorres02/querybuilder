<?php

namespace HCTorres02\QueryBuilder;

use HCTorres02\QueryBuilder\Traits\Query;
use PDO;
use PDOStatement;

/**
 * @method static Database execute(string $sql, array $params = [])
 * @method static Database table(string $table, string $alias = '')
 * @method Database select(string ...$columns)
 * @method Database insert(array $dataset)
 * @method Database update(array $dataset)
 * @method Database delete(int $id)
 * @method Database join(string $reference, string $clause)
 * @method Database where(string $column, string $value, $op = '', $type = null)
 * @method Database andWhere(string $column, string $value, $op = '')
 * @method Database orWhere(string $column, string $value, $op = '')
 * @method Database groupBy(string ...$columns)
 * @method Database orderBy(string ...$columns)
 * @method object|null fetch()
 * @method object|null fetchObject(string $className)
 * @method array|null fetchAll()
 * @method int lastInsertId()
 * @method int rowCount()
 * @method string getSql()
 * @method array getParams()
 */

class Database
{
    use Query;

    /** @var PDO */
    private $pdo;

    /** @var PDOStatement */
    private $stmt;

    /**
     * @param string $table
     * @param string $alias
     */
    public function __construct($table, $alias = '')
    {
        $this->table = $table;
        $this->alias = $alias;
        $this->commandType = 'select';
        $this->columns = [$alias ? "{$alias}.*" : '*'];
    }

    /** 
     * @param string $sql
     * @param array $params
     * 
     * @return HCTorres02\QueryBuilder\Database
     */
    public static function execute($sql, $params = [])
    {
        $db = new self(null);
        $db->sql = $sql;
        $db->params = $params;

        return $db->run();
    }

    /** @return array|null  */
    public function fetchAll()
    {
        if (!$this->stmt) {
            $this->run();
        }

        return $this->stmt->fetchAll();
    }

    /** @return object|null */
    public function fetch()
    {
        if (!$this->stmt) {
            $this->run();
        }

        return $this->stmt->fetch();
    }

    /**
     * @param string $className
     * @return object|null
     */
    public function fetchObject($className)
    {
        if (!$this->stmt) {
            $this->run();
        }

        return $this->stmt->fetchObject($className);
    }

    /** @return int */
    public function rowCount()
    {
        if (!$this->stmt) {
            $this->run();
        }

        return (int) $this->stmt->rowCount();
    }

    /** @return int */
    public function lastInsertId()
    {
        if (!$this->stmt) {
            $this->run();
        }

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * @return Database
     */
    private function run()
    {
        $sql = $this->getSql();
        $params = $this->getParams();

        $this->pdo = self::getPDO();
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute($params);

        return $this;
    }

    /**
     * @return PDO
     */
    private static function getPDO(): PDO
    {
        $db = (object) $_ENV['database'];

        $dsn = "mysql:host={$db->host};dbname={$db->dbname};charset={$db->charset}";
        $options = [
            PDO::MYSQL_ATTR_FOUND_ROWS => TRUE,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];

        return new PDO($dsn, $db->user, $db->password, $options);
    }
}
