<?php

namespace HCTorres02\QueryBuilder\Traits;

trait Update
{
    /**
     * @param int $id
     * @param array $dataset
     * 
     * @return HCTorres02\QueryBuilder\Database
     */
    public function update($id, $dataset)
    {
        $this->commandType = 'update';
        $this->setDataset($dataset);
        $this->where('id', $id);

        return $this;
    }
}
