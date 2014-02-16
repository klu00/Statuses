<?php

use Model\Database\UserMapper;
use Model\Database\UserFinder;
use Model\User;
use Model\Database\Connection;

/*
class UserDataMapperTest extends \PHPUnit_Framework_TestCase {
	private $finder;

    public function setUp() {
        $this->con = new Connection('sqlite::memory:',null,null);
        $this->con->exec(<<<SQL
  CREATE TABLE IF NOT EXISTS USERS(
    user_id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    user_name VARCHAR(100) NOT NULL,
    user_password VARCHAR(100) NOT NULL
);
SQL
        );
        $this->finder = new UserFinder($this->con);
    }

    public function testPersist() {
        $mapper = new UserMapper($this->con);
		$mapper->persist(new User("42","Lucas", "kBlock9"));
		$mapper->persist(new User("23", "Aurelien", "doudouGalaq9"));

        $rows = $this->con->query('SELECT COUNT(*) FROM USERS')->fetch(\PDO::FETCH_NUM);
        $this->assertCount(2, count($rows));
    }

    public function testFindAll() {
		$users = $this->finder->findAll();
		$this->assertEquals(2, count($users));
    }

    public function testFindOneById() {
		$users = $this->finder->findOneById('23');
		$this->assertEquals("Aurelien", $users->getName());
    }

    public function testFindOneByName() {
        $users = $this->finder->findOneByName('Aurelien');
        $this->assertEquals("23", $users->getId());
    }
}
*/