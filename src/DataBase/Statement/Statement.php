<?php
namespace App\DataBase\Statement;

use App\DataBase\Statement\Traits\Fields;
use App\DataBase\Statement\Traits\Join;
use App\DataBase\Statement\Traits\Limit;
use App\DataBase\Statement\Traits\Order;
use App\DataBase\Statement\Traits\Table;
use App\DataBase\Statement\Traits\Where;
use App\DataBase\Statement\Traits\Group;
use App\DataBase\Statement\Traits\Having;

abstract class Statement
{

    /**
     * @var string
     */
    protected $queryStart;

    /**
     * @var \PDOStatement
     */
    protected $statement;

    /**
     * @var array
     */
    protected $values = [];

    use Fields;
    use Table;
    use Where;
    use Join;
    use Group;
    use Order;
    use Limit;
    use Having;

    abstract public function getString();

    /**
     * @param \PDO $pdo
     * @return bool
     */
    public function run(\PDO $pdo): bool
    {
        $sql = $this->getString();
        $statement = $pdo->prepare($sql);
        $this->statement = $statement;
        $this->bindValues();
        return $statement->execute();
    }

    /**
     * @param string $table
     * @return $this
     */
    public function from(string $table)
    {
        $this->setTable($table);
        return $this;
    }

    /**
     * @return string
     */
    public function getFrom() :string
    {
        return 'FROM ' . $this->getTable();
    }

    public function values($values)
    {
        if (!is_array($values)) {
            return $this;
        }
        $this->values = array_merge($this->values, $values);
        return $this;
    }

    private function bindValues()
    {
        foreach ($this->values as $key => $value) {
            $this->statement->bindValue(':' . $key, $value);
        }
    }
}
