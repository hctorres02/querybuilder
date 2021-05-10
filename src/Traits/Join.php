<?php

namespace HCTorres02\QueryBuilder\Traits;

trait Join
{
    /** @var array */
    private $join = [];

    /**
     * @param string $referene
     * @param string $clause
     *  
     * @return HCTorres02\QueryBuilder\Database
     */
    public function join($reference, $clause)
    {
        $this->join[] = "JOIN {$reference} ON {$clause}";

        return $this;
    }
}
