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
    public function join($referene, $clause)
    {
        $this->join[] = "JOIN {$referene} ON {$clause}";

        return $this;
    }
}
