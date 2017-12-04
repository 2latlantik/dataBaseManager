<?php
namespace App\DataBase;

use \PDO;
use App\DataBase\Statement\SelectStatement;

/**
 * Class MyPDO
 * @package App\DataBase
 */
class MyPDO extends PDO
{
    /**
     * @var MyPDO[]
     */
    private static $connections = [];

    /**
     * @var Config
     */
    private $config;

    /**
     * MyPDO constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        try {
            parent::__construct(
                $config->getDsn(),
                $config->getUsername(),
                $config->getPassword(),
                $config->getOptions()
            );
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        $this->config = $config;
    }

    /**
     * Provide a unique connection by type to a database
     *
     * @param string $type
     * @param Config $config
     * @return MyPDO
     */
    public static function getConnection(string $type, Config $config)
    {
        if (false === isset(self::$connections[$type])) {
            self::$connections[$type] = new MyPDO($config);
        }
        return self::$connections[$type];
    }

    /**
     * First step to execute a select statement
     *
     * @return SelectStatement
     */
    public function select()
    {
        $select = new SelectStatement();
        return $select;
    }
}
