<?php

use Model\Database\StatusMapper;
use Model\User;

class StatusMapperTest extends \PHPUnit_Framework_TestCase
{
	public function testPersist()
	{
		$status = new \Model\Status(1, new DateTime(), new User(1, "Toto", "totoTest"),"Hello");

        $mock = $this->getMock('MockConnection', array('executeQuery'));
        $mock
            ->expects($this->any())
            ->method('executeQuery')
            ->will($this->returnValue(true));
        $statusMapper = new StatusMapper($mock);
        $this->assertTrue($statusMapper->persist($status));
	}

	public function testRemove()
	{
		$mock = $this->getMock('MockConnection',array('executeQuery'));
        $mock
            ->expects($this->once())
            ->method('executeQuery')
            ->will($this->returnValue(true));
        $statusMapper = new StatusMapper($mock);
        $this->assertTrue($statusMapper->remove(1));
	}
}