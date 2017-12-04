<?php
namespace App\DataBase\Statement\Traits;

trait Order
{

    /**
     * @var array
     */
    protected $order = [];

    /**
     * @param string $order
     * @param string $direction
     * @return $this
     */
    public function order(string $order, $direction = 'ASC')
    {
        $this->order[] = $order . ' ' . $direction;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrder()
    {
        return (count($this->order) > 0) ? 'ORDER BY ' . implode(', ', $this->order) : '';
    }
}
