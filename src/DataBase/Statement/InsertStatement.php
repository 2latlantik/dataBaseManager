<?php
namespace App\DataBase\Statement;

class InsertStatement extends Statement
{

    /**
     * Array of insert fields of table
     * @var array
     */
    private $insertKey = [];

    /**
     * Array of insert values of columns of table
     * @var array
     */
    private $insertRows = [];

    /**
     * Id of last insert
     * @var int
     */
    private $lastInsertId;

    /**
     * InsertStatement constructor.
     * @param array|null $fields
     */
    public function __construct(array $fields = null)
    {
        $this->setFields($fields);
        $this->queryStart = 'INSERT INTO';
    }

    /**
     * @param string $table
     * @return $this
     */
    public function into(string $table)
    {
        $this->setTable($table);
        return $this;
    }

    /**
     * @param array $values
     * @return $this
     */
    public function values(array $values)
    {
        $this->setInserted($values);
        $this->values = $this->setParamsInsert($values);
        return $this;
    }

    /**
     * Define array of column of table
     * @param array $values
     */
    public function setInserted(array $values):void
    {
        $firstLevelKeys = array_keys($values);
        if (is_numeric($firstLevelKeys[0])) {
            $this->insertKey = array_keys($values[$firstLevelKeys[0]]);
        } else {
            $this->insertKey = $firstLevelKeys;
        }
    }

    /**
     * @param array $values
     * @return array
     */
    public function setParamsInsert(array $values) :array
    {
        $firstLevelKeys = array_keys($values);
        if (is_numeric($firstLevelKeys[0])) {
            $toBind = [];
            $rows = [];
            foreach ($values as $keySet => $set) {
                $params = [];
                foreach ($set as $key => $value) {
                    $param = ':' . $key . $keySet;
                    $params[] = $param;
                    $toBind[$key . $keySet] = $value;
                }
                $rows[] = "(" . implode(", ", $params) . ")";
            }
        } else {
            $params = [];
            $toBind = [];
            $rows = [];
            foreach ($values as $key => $value) {
                $param = ':' . $key;
                $params[] = $param;
                $toBind[$key] = $value;
            }
            $rows[] = "(" . implode(", ", $params) . ")";
        }
        $this->insertRows = $rows;
        return $toBind;
    }

    /**
     * Get a last insert id of insert query
     * @param \PDO $pdo
     * @return int
     */
    public function getLastInsertId(\PDO $pdo) :int
    {
        $this->lastInsertId = $pdo->lastInsertId();
        return $this->lastInsertId;
    }

    /**
     * Return the formatted query
     * @return string
     */
    public function getString() :string
    {
        $result =
            $this->queryStart . ' ' .
            $this->getTable() .
            ' (' . implode(',', $this->insertKey) . ') VALUES ' .
            implode(',', $this->insertRows)
        ;
        return $result;
    }
}
