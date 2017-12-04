<?php
namespace App\DataBase\Statement\Traits;

use App\DataBase\Clause\Where as WhereClause;

trait Where
{

    /**
     * @var WhereClause
     */
    public $where;

    /**
     * @param string|array $condition
     * @return $this
     */
    public function where($condition)
    {
        if (isset($this->where)) {
            $this->where->and($condition);
        } else {
            $where = new WhereClause($this, $condition);
            $this->where = $where;
        }
        return $this;
    }

    /**
     * @param string|array $condition
     * @return $this
     */
    public function andWhere($condition)
    {
        $this->where->and($condition);
        return $this;
    }

    /**
     * @param string|array $condition
     * @return $this
     */
    public function orWhere($condition)
    {
        $this->where->or($condition);
        return $this;
    }

    /**
     * @return null|string
     */
    public function getWhere()
    {
        if (!$this->where instanceof WhereClause) {
            return null;
        }
        return 'WHERE ' .
            $this->where->getAnds() . ' ' .
            $this->where->getOrs();
    }
}
