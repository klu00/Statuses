<?php


namespace Model\Database;


class Connection extends \PDO {
    public function __construct($dsn, $user, $password) {
        parent::__construct($dsn, $user, $password);
    }

    public function executeQuery($query, array $parameters = []) {
        var_dump($query);
        $stmt = $this->prepare($query);
        var_dump($stmt);
        var_dump($parameters);
        foreach ($parameters as $name => $value) {
            var_dump($name);
            var_dump($value);
            $stmt->bindValue($name, $value);
        }
        var_dump($stmt);
        return $stmt->execute();
    }
} 