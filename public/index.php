<?php
require '../db.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $stmt = $pdo->query('SELECT * FROM users');
        $users = $stmt->fetchAll();
        echo json_encode($users);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $sql = "INSERT INTO users (name, email) VALUES (?, ?)";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$input['name'], $input['email']]);
        echo json_encode(['id' => $pdo->lastInsertId()]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}
?>
