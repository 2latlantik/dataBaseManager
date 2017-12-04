<?php
namespace App\DataBase\Statement\Traits;

trait Having
{

    /**
     * @var string
     */
    protected $having;

    /**
     * @param string $having
     * @return $this
     */
    public function having(string $having)
    {
        $this->having = $having;
        return $this;
    }

    /**
     * @return string
     */
    public function getHaving() :string
    {
        return (!empty($this->having)) ? 'HAVING ' . $this->having : '';
    }
}
