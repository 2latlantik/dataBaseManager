<?php
namespace Tests\Database;

use PHPUnit\Framework\TestCase;
use App\DataBase\MyPDO;
use App\DataBase\Config;

class MyPDOTest extends TestCase
{

    private $configs = [];

    public function setUp()
    {
        $this->configs = [
            'mysql'    =>  [
                'dsn'       => 'mysql',
                'dbname'    => 'test',
                'host'      => 'localhost',
                'username'  => 'root',
                'password'  => '',
            ]
        ];
    }

    public function testConnectionToMysql()
    {
        $config = new Config($this->configs['mysql']);
        try {
            MyPDO::getConnection('mysql', $config);
        } catch (\PDOException $e) {
            $this->fail($e->getMessage());
        }
        $this->assertTrue(true, 'Connection established');
    }
}