<?php
namespace App\DataBase\Statement;

class SelectStatement extends Statement
{

    /**
     * SelectStatement constructor.
     * @param array|null $fields
     */
    public function __construct(array $fields = null)
    {
        $this->setFields($fields);
        $this->queryStart = 'SELECT';
    }

    /**
     * Return the formatted query
     * @return string
     */
    public function getString()
    {
        $result =
            $this->queryStart . ' ' .
            $this->getFields() . ' ' .
            $this->getFrom() . ' ' .
            $this->getJoin() . ' ' .
            $this->getWhere() . ' ' .
            $this->getGroup() . ' ' .
            $this->getOrder() . ' ' .
            $this->getLimit()
        ;
        return trim($result);
    }

    /**
     * Add a max column to beginning of query
     * @param string $field
     * @param string $as
     * @return $this
     */
    public function max(string $field, string $as = '')
    {
        $this->fields[] = 'MAX(' . $field . ')' . $this->setAs($as);
        return $this;
    }

    /**
     * Add a min column to beginning of query
     * @param string $field
     * @param string $as
     * @return $this
     */
    public function min(string $field, string $as = '')
    {
        $this->fields[] = 'MIN(' . $field . ')' . $this->setAs($as);
        return $this;
    }

    /**
     * Add a counted field to the query
     * @param string $field
     * @param string $as
     * @param bool $distinct
     * @return $this
     */
    public function count(string $field, string $as = '', bool  $distinct = false)
    {
        $this->fields[] = 'COUNT(' . $this->setDistinct($distinct) . $field . ')' . $this->setAs($as);
        return $this;
    }

    /**
     * Add a distinct element to the query
     * @param string $field
     * @return $this
     */
    public function distinct(string $field)
    {
        $fields = ['DISTINCT ' . $field];
        foreach ($this->fields as $_field) {
            $fields[] = $_field;
        }
        $this->fields = $fields ;
        return $this;
    }

    /**
     * Return results of select query
     * @return array
     */
    public function getResults()
    {
        if (empty($this->statement)) {
            return [];
        }
        return $this->statement->fetchAll();
    }

    /**
     * Add key word 'DISTINCT' to the query
     * @param bool $distinct
     * @return null|string
     */
    private function setDistinct(bool $distinct = true)
    {
        if ($distinct) {
            return 'DISTINCT ';
        } else {
            return null;
        }
    }

    /**
     * Add an alias to a field of query select
     * @param string $as
     * @return null|string
     */
    private function setAs(string $as)
    {
        if (!empty($as)) {
            return ' AS '. $as;
        } else {
            return null;
        }
    }
}
