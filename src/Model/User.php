<?php

namespace Model;


class User {
    private $id;

    private $name;

    private $password;

    public function __construct($id = null, $name, $password) {
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPassword() {
        return $this->password;
    }
} 