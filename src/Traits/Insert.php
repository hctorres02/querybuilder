<?php

namespace HCTorres02\QueryBuilder\Traits;

trait Insert
{
    /**
     * @param array $dataset
     * 
     * @return HCTorres02\QueryBuilder\Database
     */
    public function insert($dataset)
    {
        $this->commandType = 'insert';
        $this->setDataset($dataset);

        return $this;
    }
}
