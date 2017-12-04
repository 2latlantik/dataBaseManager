<?php
namespace App\DataBase\Statement\Traits;

use App\DataBase\Clause\Join as JoinClause;

trait Join
{

    /**
     * @var JoinClause
     */
    protected $join;

    /**
     * @param string $table
     * @param string $leftSide
     * @param string $operator
     * @param string $rightSide
     * @param string $type
     * @return $this
     */
    public function join(string $table, string $leftSide, string $operator, string $rightSide, $type = 'INNER')
    {
        if (isset($this->join)) {
            $this->join->join($table, $leftSide, $operator, $rightSide, $type);
        } else {
            $this->join = new JoinClause($table, $leftSide, $operator, $rightSide, $type);
        }
        return $this;
    }

    /**
     * @param string $table
     * @param string $leftSide
     * @param string $operator
     * @param string $rightSide
     * @return $this
     */
    public function innerJoin(string $table, string $leftSide, string $operator, string $rightSide)
    {
        $this->join($table, $leftSide, $operator, $rightSide, 'INNER');
        return $this;
    }

    /**
     * @param string $table
     * @param string $leftSide
     * @param string $operator
     * @param string $rightSide
     * @return $this
     */
    public function leftJoin(string $table, string $leftSide, string $operator, string $rightSide)
    {
        $this->join($table, $leftSide, $operator, $rightSide, 'LEFT');
        return $this;
    }

    /**
     * @return null|string
     */
    public function getJoin()
    {
        if (!$this->join instanceof JoinClause) {
            return null;
        }
        return ' ' . $this->join->getJoins();
    }
}
