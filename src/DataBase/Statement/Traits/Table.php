<?php
namespace App\DataBase\Statement\Traits;

trait Table
{

    /**
     * @var string
     */
    protected $table;

    /**
     * @param string $table
     * @param string $alias
     */
    public function setTable(string $table, $alias = ''): void
    {
        if (empty($alias)) {
            $this->table = $table;
        } else {
            $this->table = $alias . '.' . $table;
        }
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }
}
