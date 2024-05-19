<?php


spl_autoload_register(function ($className) {
    require __DIR__ . "/src/$className.php";
});

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-Type: application/json; charset=utf-8");

$parts = explode("/", $_SERVER["REQUEST_URI"]);

if($parts[1] != "users") {
    http_response_code(404);
    exit();
}

$id = $parts[2] ?? null;

$database = new Database("localhost", "restapi_learn_db", "root", "");

$gateway = new UserGateway($database);

$controller = new UserController($gateway);

$controller->processRequest($_SERVER["REQUEST_METHOD"], $id);