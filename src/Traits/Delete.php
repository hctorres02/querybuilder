<?php

namespace HCTorres02\QueryBuilder\Traits;

trait Delete
{
    /**
     * @param int $id
     * 
     * @return HCTorres02\QueryBuilder\Database
     */
    public function delete($id)
    {
        $this->commandType = 'delete';
        $this->where('id', $id);

        return $this;
    }
}
