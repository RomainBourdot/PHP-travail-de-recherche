<?php
/**
 * Front Controller - Point d'entrée unique de l'application
 */

// Démarrage de la session
session_start();

// Autoload simple
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

// Système de routage simple
$action = $_GET['action'] ?? 'index';

// Instanciation du contrôleur
$controller = new TaskController();

// Routage des actions
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
        // Page 404
        http_response_code(404);
        echo "<h1>404 - Page non trouvée</h1>";
        break;
}
