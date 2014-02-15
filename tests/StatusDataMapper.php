<?php

use Model\Database\StatusMapper;
use Model\Database\StatusFinder;
use Model\Status;
use Model\Database\Connection;

class StatusDataMapperTest extends TestCase {
	/*private $finder;
    private $con;

    public function setUp() {
        $this->con = new Connection('sqlite::memory:',null,null);
        $this->con->exec(<<<SQL
CREATE TABLE IF NOT EXISTS STATUSES(
  status_id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
  status_message VARCHAR(500) NOT NULL,
  status_user_id INTEGER,
  status_date DATETIME NOT NULL,
  FOREIGN KEY (status_user_id) REFERENCES USERS(user_id) ON DELETE CASCADE
);
SQL
        );
        var_dump("allo");
        $this->finder = new StatusFinder($this->con);
    }

    public function testPersist() {
        var_dump("allo2");
        $mapper = new StatusMapper($this->con);
        var_dump("allo3");
		$mapper->persist(new Status(1, new DateTime("01-05-2014 12:45:30"), new \Model\User(1,"Lucas","lucas"), "Hello"));
        var_dump("allo4");
		$mapper->persist(new Status(2, new DateTime("02-08-2014 19:25:40"), new \Model\User(2,"Aurelien","aurelien"), "Buenos Dias"));

        $rows = $this->con->query('SELECT COUNT(*) FROM STATUSES')->fetch(\PDO::FETCH_NUM);
        $this->assertCount(2, count($rows));
    }

    public function testFindAll() {
		$statuses = $this->finder->findAll();
		$this->assertEquals(2, count($statuses));
    }/*
/*
    public function testFindOneById() {
		$status = $this->finder->findOneById(1);
		$this->assertEquals("Hello", $status->getMessage());
    }*/


}