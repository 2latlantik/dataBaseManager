<?php
namespace Tests\Database\Statement;


use App\DataBase\Config;
use App\DataBase\MyPDO;
use App\DataBase\Statement\SelectStatement;
use PHPUnit\Framework\TestCase;

class SelectStatementTest extends TestCase
{

    /**
     * @var MyPDO
     */
    private $myPdo;

    public function setUp()
    {
        $configs = [
            'mysql'    =>  [
                'dsn'       => 'mysql',
                'dbname'    => 'test',
                'host'      => 'localhost',
                'username'  => 'root',
                'password'  => '',
            ]
        ];
        $config = new Config($configs['mysql']);
        try {
            $this->myPdo = MyPDO::getConnection('mysql', $config);
        } catch (\PDOException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testSelectSimple() {
        $this->assertTrue(true, 'Connection established');
        $select = (new SelectStatement())
            ->from('contact')
            ->where('1 = 1')
            ->andWhere('2 = 2')
            ->orWhere('3 = 3')
            ->group('emetteur_nom')
            ->order('date', 'DESC')
            ->limit(0, 2);
        $attempt = "SELECT * FROM contact  WHERE 1 = 1 AND 2 = 2 OR (3 = 3) GROUP BY emetteur_nom ORDER BY date DESC";
        $this->assertEquals($select->getString(), $attempt);
    }

    public function testSelectWithJoin(){
        $this->assertTrue(true, 'Connection established');
        $select = (new SelectStatement())
            ->from('contact c1')
            ->innerJoin('contact c2', 'c1.id' , '=', 'c2.id');

        if($select->run($this->myPdo)) {

        }
    }

    public function testSelectWithParams() {
        $select = (new SelectStatement())
            ->from('contact')
            ->where([
                'left'      => 'emetteur_nom',
                'right'     => ['scalar'    =>  'emetteur_nom'],
                'operator'  => '='

            ])
            ->limit(0,1)
            ->values([
                'emetteur_nom'  => 'aaaaa'
            ]);
        if($select->run($this->myPdo)) {
            $results = $select->getResults();
        } else {
            $results = [];
        }
        $this->assertNotEquals(0, count($results));
    }

    public function  testSelectWithMax()
    {
        $select = (new SelectStatement())
            ->from('contact')
            ->max('date', 'max_date');
        if($select->run($this->myPdo)) {
            $results = $select->getResults();
        }
        $this->assertEquals(count($results), 1);
    }

    public function testSelectWithDistinct()
    {
        $select = (new SelectStatement(['date']))
            ->from('contact')
            ->distinct('emetteur_nom');
        if($select->run($this->myPdo)) {
            $results = $select->getResults();
        }
        $this->assertNotEquals(0, count($results));
    }
}