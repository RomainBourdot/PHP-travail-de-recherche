<?php

session_start();

spl_autoload_register(function ($class) {
    $paths = [
        'config/',
        'controllers/',
        'models/'
    ];
    
    foreach ($paths as $path) {
        $file = __DIR__ . '/' . $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$action = $_GET['action'] ?? 'index';

$controller = new TaskController();

switch ($action) {
    case 'index':
        $controller->index();
        break;
    
    case 'create':
        $controller->create();
        break;
    
    case 'store':
        $controller->store();
        break;
    
    case 'edit':
        $id = $_GET['id'] ?? null;
        $controller->edit($id);
        break;
    
    case 'update':
        $controller->update();
        break;
    
    case 'toggle':
        $id = $_GET['id'] ?? null;
        $controller->toggle($id);
        break;
    
    case 'delete':
        $id = $_GET['id'] ?? null;
        $controller->delete($id);
        break;
    
    default:
        http_response_code(404);
        echo "<h1>404 - Page non trouvée</h1>";
        break;
}
