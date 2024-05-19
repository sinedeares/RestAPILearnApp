<?php

class UserController
{

    public function __construct (private UserGateway $gateway)
    {

    }
    public function processRequest(string $method, ?string $id):void
    {
        if($id){
            $this->processResourceRequest($method, $id);
        }
        else{
            $this->processCollectionRequest($method);
        }
    }

    //метод запроса ресурсов
    private function processResourceRequest(string$method, ?string $id):void
    {
        $user = $this->gateway->get($id);

        if (!$user) {
            http_response_code(404);
            echo json_encode(["message" => "User not found"]);
            return;
        }

        switch ($method) {
            case "GET":
                echo json_encode($user);
                break;
            case "PATCH":
                $data = ["name"=>"Tanya", "email"=>"Tanya@mail.ru", "password"=>"tanya789"];

                if ( ! empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                $rows = $this->gateway->update($user, $data);

                echo json_encode([
                    "message" => "User $id updated",
                    "rows" => $rows
                ]);
                break;

            case "DELETE":
                $rows = $this->gateway->delete($id);

                echo json_encode([
                    "message" => "User $id deleted",
                    "rows" => $rows
                ]);
                break;

            default:
                http_response_code(405);
                header("Allow: GET, PATCH, DELETE");
        }
    }

    //метод запроса коллекции ресурсов
    private function processCollectionRequest(string $method):void
    {
        switch ($method) {
            case "GET":
                echo  json_encode($this->gateway->getAll());
                break;
            case "POST":
                $data = ["name"=>"Sasha", "email"=>"Sasha@mail.ru", "password"=>"sasha789"];
                $id = $this->gateway->create($data);

                echo json_encode([
                    "message" => "User created",
                    "id" => $id
                ]);
                break;
            default:
                http_response_code(405);
                header("Allow: GET, POST");
        }
    }
}