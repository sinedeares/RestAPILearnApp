<?php

class UserGateway
{

    private PDO $connection;
    public function __construct(\Database $database)
    {
        $this->connection = $database->getConnection();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM restapi_user";

        $statement = $this->connection->query($sql);

        $data = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function get(string $id):array | false
    {

        $sql = "SELECT * FROM restapi_user WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data):string
    {

        $sql = "INSERT INTO restapi_user (name, email, password) VALUES (:name, :email, :password)";

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(":name", $data["name"]);
        $statement->bindValue(":email", $data["email"]);
        $statement->bindValue(":password", $data["password"]);
        $statement->execute();
        return$this->connection->lastInsertId();

    }

    public function update(array $current, array $new):int
    {
        $sql = "UPDATE restapi_user SET name = :name, email = :email, password = :password WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(":id", $current["id"], PDO::PARAM_INT);
        $statement->bindValue(":name", $new["name"] ?? $current["name"], PDO:: PARAM_STR);
        $statement->bindValue(":email", $new["email"] ?? $current["email"], PDO:: PARAM_STR);
        $statement->bindValue(":password", $new["password"] ?? $current["password"], PDO::PARAM_STR);
        $statement->execute();
        return $statement->rowCount();
    }

    public function delete(string $id):int
    {
        $sql = "DELETE FROM restapi_user WHERE id = :id";

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount();
    }
}