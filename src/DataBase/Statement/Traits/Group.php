<?php
namespace App\DataBase\Statement\Traits;

trait Group
{

    /**
     * @var array
     */
    protected $group = [];

    /**
     * @param string $group
     * @return $this
     */
    public function group(string  $group)
    {
        $this->group[] = $group;
        return $this;
    }

    /**
     * @return string
     */
    public function getGroup()
    {
        return (count($this->group) > 0) ? 'GROUP BY ' . implode(', ', $this->group) : '';
    }
}
