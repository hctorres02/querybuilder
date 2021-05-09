<?php

namespace HCTorres02\QueryBuilder\Traits;

trait Select
{
    use Join;

    /** @var string */
    private $groupBy = null;

    /** @var string */
    private $orderBy = null;

    /**
     * @param string[] $columns 
     * 
     * @return HCTorres02\QueryBuilder\Database
     */
    public function select(...$columns)
    {
        $this->commandType = 'select';
        $this->columns = $columns;

        return $this;
    }

    /**
     * @param string[] $columns 
     * 
     * @return HCTorres02\QueryBuilder\Database
     */
    public function addColumns(...$columns)
    {
        array_push($this->columns, ...$columns);

        return $this;
    }

    /**
     * @param string[] $columns
     * 
     * @return HCTorres02\QueryBuilder\Database
     */
    public function orderBy(...$columns)
    {
        $this->orderBy = implode(', ', $columns);

        return $this;
    }

    /**
     * @param string[] $columns
     * 
     * @return HCTorres02\QueryBuilder\Database
     */
    public function groupBy(...$columns)
    {
        $this->groupBy = implode(', ', $columns);

        return $this;
    }
}
