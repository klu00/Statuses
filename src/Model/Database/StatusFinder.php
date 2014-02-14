<?php

namespace Model\Database;

use Exception\HttpException;
use Model\FinderInterface;
use Model\Status;

class StatusFinder implements FinderInterface {

    private $connection;

    private $extra_parameters = [
        "orderBy" => " ORDER BY ",
        "limit" => " LIMIT 0, ",
        "userName" => " WHERE status_user = '",
    ];

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function findAll(array $parameters = []) {
        $query = "SELECT * FROM STATUSES";
        if ($parameters !=null)
            $query .=  $this->constructExtraQuery($parameters);

        $statuses_array = [];
        var_dump($query);
        $statuses = $this->connection->query($query);
        if (false === $statuses) {
            $statuses = $this->connection->query("SELECT * FROM STATUSES;");
        }

        foreach ($statuses as $status) {
            array_push($statuses_array,new Status($status["status_id"],
                                                  new \DateTime($status["status_date"]),
                                                  $status["status_user"],
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
            $status["status_user"],
            $status["status_message"]
        );
    }

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