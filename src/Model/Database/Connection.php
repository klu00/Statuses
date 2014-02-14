<?php


namespace Model\Database;


class Connection extends \PDO {
    public function __construct($dsn, $user, $password) {
        parent::__construct($dsn, $user, $password);
    }

    public function executeQuery($query, array $parameters = []) {
        $stmt = $this->prepare($query);
        foreach ($parameters as $name => $value) {
            $stmt->bindValue($name, $value);
        }
        return $stmt->execute();
    }
} 