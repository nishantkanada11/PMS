<?php

require_once __DIR__ . '/../app/config/Database.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/controllers/UserController.php';
require_once __DIR__ . '/../app/controllers/ApiController.php';



$database = new Database();
$db = $database->getConnection();

$controllerName = $_GET['controller'] ?? 'User';
$action = $_GET['action'] ?? 'showActiveProducts';


switch ($controllerName) {
    case 'User':
        $controller = new UserController($db);
        break;
    case 'Api':
        $controller = new ApiController($db);
        break;

    default:
        die("404: Controller not found.");
}

// Check and call the action
if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    echo "404: Action not found.";
}
