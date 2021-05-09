<?php

namespace HCTorres02\QueryBuilder\Traits;

trait Query
{
    use Builder,
        Select,
        Insert,
        Update,
        Delete,
        Where;

    /** @var string */
    private $table;

    /** @var string */
    private $alias;

    /** @var array */
    private $columns;

    /** @var string */
    private $sql = null;

    /** @var array */
    private $params = [];

    /** @var string */
    private $commandType;

    /**
     * @param string $table
     * @param string $alias
     * 
     * @return HCTorres02\QueryBuilder\Database
     */
    public static function table($table, $alias = null)
    {
        return new self($table, $alias);
    }

    /**
     * @return string
     */
    public function getSql()
    {
        return $this->sql ?? $this->buildQuery();
    }

    /** @return array */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param string $column
     * @param string $value
     * 
     * @return string
     */
    private function appendParam($column, $value)
    {
        $param = ':' . (strtok(strtok($column, '.')) ?: $column);
        $this->params[$param] = $value;

        return $param;
    }

    /**
     * @param array $dataset
     */
    private function setDataset($dataset)
    {
        $this->columns = [];

        foreach ($dataset as $column => $value) {
            $this->columns[] = $column;
            $this->appendParam($column, $value);
        }
    }
}
