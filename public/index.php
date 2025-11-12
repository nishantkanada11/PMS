<?php
require_once __DIR__ . '/../app/config/Database.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/controllers/UserController.php';
require_once __DIR__ . '/../app/controllers/ApiController.php';

$database = new Database();
$db = $database->getConnection();

$basePath = '/PMS';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$path = str_replace($basePath, '', $requestUri);
$path = trim($path, '/');

if ($path === '' || $path === false) {
    $controllerName = 'User';
    $action = 'showActiveProducts';
    $param = null;
} else {
    $segments = explode('/', $path);
    $controllerName = ucfirst(strtolower($segments[0] ?? 'User'));
    $action = $segments[1] ?? 'showActiveProducts';
    $param = $segments[2] ?? null;
}

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

if (method_exists($controller, $action)) {
    if ($param)
        $_GET['id'] = $param;
    $controller->$action();
} else {
    echo "404: Action not found.";
}
