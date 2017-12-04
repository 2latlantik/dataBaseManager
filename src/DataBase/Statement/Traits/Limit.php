<?php
namespace App\DataBase\Statement\Traits;

trait Limit
{

    /**
     * @var int
     */
    protected $start;

    /**
     * @var int
     */
    protected $length;

    /**
     * @param int $start
     * @param int $length
     * @return $this
     */
    public function limit(int $start, int $length)
    {
        $this->start = $start;
        $this->length = $length;
        return $this;
    }

    /**
     * @return string
     */
    public function getLimit() :string
    {
        return (!empty($this->start)) ? 'LIMIT ' . $this->start . ', ' . $this->length : '';
    }
}
