<?php
namespace App\DataBase\Statement\Traits;

trait Fields
{
    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @param $fields
     */
    public function setFields($fields) :void
    {
        if (true === empty($fields)) {
            $fields = array('*');
        }
        $this->fields = $fields;
    }

    /**
     * @param string $field
     */
    public function addFields(string $field) :void
    {
        $this->fields[] = $field;
    }

    /**
     * @return string
     */
    public function getFields() :string
    {
        return implode(', ', $this->fields);
    }
}
