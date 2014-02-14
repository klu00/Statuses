<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 14/02/2014
 * Time: 18:42
 */

namespace Model\Database;


use Model\FinderInterface;
use Model\User;

class UserFinder implements FinderInterface{

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    /**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll() {
        $query = "SELECT * FROM USERS";
        $users = $this->connection->query($query);
        $users_array = [];
        foreach ($users as $user) {
            array_push($users_array,new Status($user["user_id"],
                $user["user_name"],
                $user["user_password"]
            ));
        }
        return $users_array;
    }

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed $id
     * @return null|mixed
     */
    public function findOneById($id) {
        $query = "SELECT * FROM USERS WHERE user_id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':id',$id);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (null === $user["user_id"])
            return null;
        return new User($user["user_id"],
            $user["user_name"],
            $user["user_password"]
        );
    }

    public function findOneByName($name) {
        $query = "SELECT * FROM USERS WHERE user_name = :name";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':name',$name);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (null === $user["user_id"])
            return null;
        return new User($user["user_id"],
            $user["user_name"],
            $user["user_password"]
        );
    }
}