<?php

namespace HCTorres02\QueryBuilder\Traits;

trait Where
{
    /** @var array */
    private $where = [];

    private function getWhere($sql)
    {
        if ($this->where) {
            $where = implode(' ', $this->where);
            $sql = "{$sql} WHERE {$where}";
        }

        return $sql;
    }

    /**
     * @param string $column
     * @param mixed $value
     * @param string $op
     * @param string $type
     * 
     * @return HCTorres02\QueryBuilder\Database
     */
    public function where($column, $value, $op = '=', $type = null)
    {
        if (is_bool($value)) {
            $value = $value ?: '0';
        } elseif (is_null($value)) {
            $value = 'NULL';
        }

        $param = $this->appendParam($column, $value);
        $this->where[] = trim("{$type} {$column} {$op} {$param}");

        return $this;
    }

    /**
     * @param string $column
     * @param mixed $value
     * @param string $op
     * 
     * @return HCTorres02\QueryBuilder\Database
     */
    public function andWhere($column, $value, $op = '=')
    {
        return $this->where($column, $value, $op, 'AND');
    }

    /**
     * @param string $column
     * @param mixed $value
     * @param string $op
     * 
     * @return HCTorres02\QueryBuilder\Database
     */
    public function orWhere($column, $value, $op = '=')
    {
        return $this->where($column, $value, $op, 'OR');
    }
}
