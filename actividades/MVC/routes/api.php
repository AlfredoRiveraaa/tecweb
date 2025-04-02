<?php
require_once '../Controllers/ProductController.php';

$controller = new ProductController();
$action = $_POST['action'] ?? '';

switch ($action) {
    case 'add':
        $input = $_POST['input'] ?? '';
        $controller->add($input);
        break;
    case 'delete':
        $id = $_POST['id'] ?? '';
        $controller->delete($id);
        break;
    case 'edit':
        $input = $_POST['input'] ?? '';
        $controller->edit($input);        
        break;
    case 'get':
        $id = $_POST['id'] ?? '';
        $controller->get($id);
        break;
    case 'list':
        $controller->list();
        break;
    case 'search':
        $search = $_POST['search'] ?? '';
        $controller->search($search);
        break;
    default:
        echo json_encode(["error" => "Acción no válida"]);
}
?>