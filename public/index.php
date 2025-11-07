<?php

require_once __DIR__ . '/../app/config/Database.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/controllers/UserController.php';

// Database connection
$database = new Database();
$db = $database->getConnection();

// Determine controller and action
$controllerName = $_GET['controller'] ?? 'User';
$action = $_GET['action'] ?? 'showActiveProducts';

// Initialize correct controller object
switch ($controllerName) {
    case 'User':
        $controller = new UserController($db);
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
