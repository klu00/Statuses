<?php

namespace Model\Database;

use Model\FinderInterface;
use Model\Status;
use Model\User;

class StatusFinder implements FinderInterface {

    private $connection;

    private $userFinder;

    private $extra_parameters = [
        "orderBy" => " ORDER BY ",
        "limit" => " LIMIT 0, ",
        "user" => " WHERE status_user_id = '",
    ];

    public function __construct(Connection $connection) {
        $this->connection = $connection;
        $this->userFinder = new UserFinder($connection);
    }

    public function findAll(array $parameters = []) {
        $query = "SELECT * FROM STATUSES";
        if ($parameters !=null)
            $query .=  $this->constructExtraQuery($parameters);

        $statuses_array = [];
        $statuses = $this->connection->query($query);
        if (false === $statuses) {
            $statuses = $this->connection->query("SELECT * FROM STATUSES;");
        }

        foreach ($statuses as $status) {
            array_push($statuses_array,new Status($status["status_id"],
                                                  new \DateTime($status["status_date"]),
                                                  $this->findUser($status["status_user_id"]),
                                                  $status["status_message"]

            ));
        }
        return $statuses_array;
    }

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed $id
     * @return null|mixed
     */
    public function findOneById($id) {
        $query = "SELECT * FROM STATUSES WHERE status_id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':id',$id);
        $stmt->execute();
        $status = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (null === $status["status_id"])
            return null;

        return new Status($status["status_id"],
            new \DateTime($status["status_date"]),
            $this->findUser($status["status_user_id"]),
            $status["status_message"]
        );
    }

    /** Function to find the user associated to the status.
     * Returns a new Anonymous user if there is no user_id associated with the status.
     * @param $id
     * @return mixed|User|null
     */
    private function findUser($id) {
        $status_user = $this->userFinder->findOneById($id);
        if (null === $status_user) {
            $status_user = new User(null,"Anonymous",null);
        }
        return $status_user;
    }

    /** Function to build an extra query part when extra parameters are passed into the URL.
     * @param $parameters
     * @return string
     */
    private function constructExtraQuery($parameters) {
        $extra_query = "";
        $limit_query ="";
        foreach ($parameters as $name => $value) {
            if (array_key_exists($name , $this->extra_parameters)) {
                if ("orderBy" === $name) {
                    $values = explode('$', $value);
                    if (count($values)===1)
                        $values[1] = "";
                    $extra_query .= $this->extra_parameters[$name] . $values[0] ." ". $values[1];
                } else if ("limit" === $name) {
                    $values = explode('$', $value);
                    if (count($values)===1) {
                        $limit_query = $this->extra_parameters[$name] . $values[0];
                    } else {
                        $extra_query .= " LIMIT " . $values[0] .", " .$values[1];
                    }
                } else {
                    $extra_query .= $this->extra_parameters[$name] . $value ."'";
                }
            }
        }
        return $extra_query.$limit_query;
    }
}