<?php
namespace Tests\Database;

use PHPUnit\Framework\TestCase;
use App\DataBase\Config;

class ConfigTest extends TestCase
{

    /**
     * Check the good instantiation/configuration of Config Class and its variables
     */
    public function testInstantiationMysql()
    {
        $params = array(
            'dsn'       => 'mysql',
            'dbname'    => 'test',
            'host'      => 'localhost',
            'username'  => 'root',
            'password'  => '',
        );
        $config = new Config($params);
        $this->assertInstanceOf(Config::class, $config);
        $this->assertEquals($config->getDsn(), 'mysql:dbname=' . $params['dbname'] . ';host=' . $params['host']);
    }

}