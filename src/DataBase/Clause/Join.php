<?php
namespace App\DataBase\Clause;

/**
 * Class Join
 * Define the joined table
 * @package App\DataBase\Clause
 */
class Join
{

    /**
     * @var array
     */
    private $joins = [];

    /**
     * Join constructor.
     * @param string $table
     * @param string $leftSide
     * @param string $operator
     * @param string $rightSide
     * @param string $type
     */
    public function __construct(string $table, string $leftSide, string $operator, string $rightSide, $type = 'INNER')
    {
        $this->join($table, $leftSide, $operator, $rightSide, $type);
    }

    /**
     * @param string $table
     * @param string $leftSide
     * @param string $operator
     * @param string $rightSide
     * @param string $type
     */
    public function join(string $table, string $leftSide, string $operator, string $rightSide, $type = 'INNER') :void
    {
        $this->joins[] =  $type . ' JOIN ' . $table . ' ON ' . $leftSide . ' ' . $operator  . ' ' . $rightSide;
    }

    /**
     * @param string $table
     * @param string $leftSide
     * @param string $operator
     * @param string $rightSide
     */
    public function left(string $table, string $leftSide, string $operator, string $rightSide) :void
    {
        $this->join($table, $leftSide, $operator, $rightSide, 'LEFT');
    }

    /**
     * @param string $table
     * @param string $leftSide
     * @param string $operator
     * @param string $rightSide
     */
    public function right(string $table, string $leftSide, string $operator, string $rightSide) :void
    {
        $this->join($table, $leftSide, $operator, $rightSide, 'RIGHT');
    }

    /**
     * @return string
     */
    public function getJoins() :string
    {
        return implode(' ', $this->joins);
    }
}
