<?php

namespace Model;

class Status {
    private $id;

    private $message;

    private $date;

    private $user;

    public function __construct($id = null, \DateTime $date,User $user, $message) {
        $this->id = $id;
        $this->message = $message;
        $this->date = $date;
        $this->user = $user;
    }

    public function getId() {
        return $this->id;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getDate() {
        return $this->date;
    }

    public function getUser() {
        return $this->user;
    }
}

