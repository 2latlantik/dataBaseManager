<?php
namespace Tests\Database\Statement;

use App\DataBase\Config;
use App\DataBase\MyPDO;
use PHPUnit\Framework\TestCase;
use App\DataBase\Statement\InsertStatement;

class InsertStatementTest extends TestCase
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


    public function testInsertSimple() {
        $values = [
            'date'          =>  date('Y-m-d'),
            'emetteur_nom'  =>  'aaaaa',
            'emetteur_mail' =>  'a@a.fr',
            'objet'         =>  'a-objet',
            'message'       =>  'a-message',
            'repondu'       => 0
        ];
        $insert = (new InsertStatement())
            ->into('contact')
            ->values($values);
        $this->myPdo->beginTransaction();
        if($insert->run($this->myPdo)){
            $id = $insert->getLastInsertId($this->myPdo);
            $this->assertInternalType('int', $id);
            $this->myPdo->rollBack();
        }
    }

    public function testInsertWithManyData() {
        $values = [];
        for($i = 1 ; $i <= 2 ; $i++) {
            $values[] = [
                'date' => date('Y-m-d'),
                'emetteur_nom' => 'aaaaa' . $i,
                'emetteur_mail' => 'a' . $i . '@a.fr',
                'objet' => 'a-objet',
                'message' => 'a-message',
                'repondu' => 0
            ];
        }
        $insert = (new InsertStatement())
            ->into('contact')
            ->values($values);
        $this->myPdo->beginTransaction();
        if($insert->run($this->myPdo)){
            $id = $insert->getLastInsertId($this->myPdo);
            $this->assertInternalType('int', $id);
            $this->myPdo->rollBack();
        }
    }

}