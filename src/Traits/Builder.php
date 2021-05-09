<?php

namespace HCTorres02\QueryBuilder\Traits;

trait Builder
{
    /**
     * @return string
     */
    private function buildQuery()
    {
        switch ($this->commandType) {
            case 'select':
                return $this->buildSelect();
                break;

            case 'insert':
                return $this->buildInsert();
                break;

            case 'update':
                return $this->buildUpdate();
                break;

            case 'delete':
                return $this->buildDelete();
                break;
        }

        return null;
    }

    /**
     * @return string
     */
    private function buildSelect()
    {
        $params = '';
        $columns = implode(', ', $this->columns);

        if ($this->alias) {
            $this->table = "{$this->table} {$this->alias}";
        }

        if ($this->join) {
            $joins = implode(' ', $this->join);
            $this->table = "{$this->table} {$joins}";
        }

        $params = $this->getWhere($params);

        if ($this->groupBy) {
            $params = trim("{$params} GROUP BY {$this->groupBy}");
        }

        if ($this->orderBy) {
            $params = trim("{$params} ORDER BY {$this->orderBy}");
        }

        return trim("SELECT {$columns} FROM {$this->table} {$params}");
    }

    /**
     * @return string
     */
    private function buildInsert()
    {
        $columns = implode(', ', $this->columns);
        $values = implode(', ', array_keys($this->params));

        return trim("INSERT INTO {$this->table} ({$columns}) VALUES ({$values})");
    }

    /**
     * @return string
     */
    private function buildUpdate()
    {
        foreach ($this->columns as $column) {
            $columns[] = "{$column} = :{$column}";
        }

        $dataset = implode(', ', $columns);
        $sql = "UPDATE {$this->table} SET {$dataset}";
        $sql = $this->getWhere($sql);

        return $sql;
    }

    /**
     * @return string
     */
    private function buildDelete()
    {
        $sql = "DELETE FROM {$this->table}";
        $sql = $this->getWhere($sql);

        return $sql;
    }
}
