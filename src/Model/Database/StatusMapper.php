<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 12/02/2014
 * Time: 20:32
 */

namespace Model\Database;


use Model\Status;

class StatusMapper {
    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function persist(Status $status) {
        $query = "INSERT INTO STATUSES VALUES (:status_id, :status_message, :status_user, :status_date)";

        return $this->connection->executeQuery($query, [
            ':status_id' => $status->getId(),
            ':status_user' => $status->getUser(),
            ':status_message' => $status->getMessage(),
            ':status_date' => $status->getDate()->format('Y-m-d H:i:s'),
        ]);
    }

    public function remove($status_id) {
        var_dump($status_id);
        $query = "DELETE FROM STATUSES WHERE status_id = :status_id";
        return $this->connection->executeQuery($query, [
            ':status_id' => $status_id,
        ]);
    }
} 