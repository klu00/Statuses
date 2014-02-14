<?php

namespace Model;

class InMemoryFinder implements FinderInterface {

    private $statuses = array();

    public function  __construct() {
        $this->statuses[0] = new Status(0,"Status0", new \DateTime(),"Toto");
        $this->statuses[1] = new Status(1,"Status1", new \DateTime(),"Aurelien");
        $this->statuses[2] = new Status(2,"Status2", new \DateTime(),"Lucas");
    }
    
    public function findAll() {
        return $this->statuses;
    }

    public function findOneById($id) {
        return $this->statuses[$id];
    }
}
