<?php

use Model\Database\UserMapper;
use Model\User;

class UserMapperTest extends \PHPUnit_Framework_TestCase
{

    public function testPersist()
    {
        $user = new \Model\User(1, "Toto", "totoTest");

        $mock = $this->getMock('MockConnection', array('executeQuery'));
        $mock
            ->expects($this->any())
            ->method('executeQuery')
            ->will($this->returnValue(true));
        $userMapper = new UserMapper($mock);
        $this->assertTrue($userMapper->persist($user));
    }

    public function testRemove()
    {
        $mock = $this->getMock('MockConnection',array('executeQuery'));
        $mock
            ->expects($this->once())
            ->method('executeQuery')
            ->will($this->returnValue(true));
        $userMapper = new UserMapper($mock);
        $this->assertTrue($userMapper->remove(1));
    }
}