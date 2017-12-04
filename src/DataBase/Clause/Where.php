<?php
namespace App\DataBase\Clause;

use App\DataBase\Statement\Statement;

/**
 * Class Where
 * Define the elements of Clause where in query
 * @package App\DataBase\Clause
 */
class Where
{

    public $statement;

    /**
     * @var array of ands sequence
     */
    private $ands = [];

    /**
     * @var array of or sequence
     */
    private $ors = [];

    /**
     * Where constructor.
     * @param Statement $statement
     * @param string|array $condition
     *      [
     *          'left'  => string,
     *          'right' => [
     *                  'scalar|value' =>
     *                  ],
     *          'operator'  => string
     *     ]
     */
    public function __construct(Statement $statement, $condition)
    {
        $this->statement = $statement;
        $this->and($condition);
    }

    /**
     * @param string|array $condition
     * @return Where
     */
    public function and($condition): Where
    {
        $this->ands[] = $this->describeCondition($condition);
        return $this;
    }

    /**
     * @param string|array $condition
     * @return Where
     */
    public function or($condition): Where
    {
        $this->ors[] = $this->describeCondition($condition);
        return $this;
    }

    /**
     * @param string|array $condition
     * @return string
     */
    private function describeCondition($condition) :string
    {
        if (is_array($condition)) {
            $return = $condition['left'];
            if ($condition['operator'] == 'LIKE') {
                $return .= ' LIKE ';
            } else {
                $return .= ' ' . $condition['operator'] . ' ';
            }
            if (isset($condition['right']['scalar'])) {
                $return .= $this->setParam($condition['right']['scalar']);
            } else {
                $return .= $condition['right']['value'];
            }
            return $return;
        } else {
            return $condition;
        }
    }

    /**
     * @param string $param
     * @return string
     */
    private function setParam(string $param): string
    {
        return ':'.$param;
    }

    /**
     * @param string $format
     * @return array|null|string
     */
    public function getAnds($format = 'string')
    {
        if (empty($this->ands)) {
            return null;
        }
        if ($format == 'string') {
            return implode(' AND ', $this->ands);
        } else {
            return $this->ands;
        }
    }

    /**
     * @param string $format
     * @return array|null|string
     */
    public function getOrs($format = 'string')
    {
        if (empty($this->ors)) {
            return null;
        }
        if (true === empty($this->ands)) {
            $prefix_return = false;
        } else {
            $prefix_return = true;
        }
        if ($format == 'string') {
            return ($prefix_return ? 'OR (' : '') . implode(' OR ', $this->ors) . ($prefix_return ? ')' : '');
        } else {
            return $this->ors;
        }
    }
}
