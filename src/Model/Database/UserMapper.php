<?php

namespace Model\Database;


use Model\User;

class UserMapper {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function persist(User $user) {
        $query = "INSERT INTO USERS VALUES (:user_id, :user_name, :user_password)";

        return $this->connection->executeQuery($query, [
            ':user_id' => $user->getId(),
            ':user_name' => $user->getName(),
            ':user_password' => $user->getPassword(),
        ]);
    }

    public function remove($status_id) {
        $query = "DELETE FROM STATUSES WHERE status_id = :status_id";
        return $this->connection->executeQuery($query, [
            ':status_id' => $status_id,
        ]);
    }
} 