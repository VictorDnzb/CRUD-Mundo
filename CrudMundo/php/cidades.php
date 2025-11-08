<?php
// php/cidades.php
// api rest para gerir cidades

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/db.php';
$pdo = getPDO();

function getJsonInput() {
    $data = json_decode(file_get_contents('php://input'), true);
    return is_array($data) ? $data : [];
}

$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

try {
    if ($method === 'GET') {
        if ($id) {
            $stmt = $pdo->prepare('SELECT c.*, p.nome_oficial AS pais_nome FROM cidades c LEFT JOIN paises p ON c.id_pais = p.id_pais WHERE c.id_cidade = ?');
            $stmt->execute([$id]);
            $cidade = $stmt->fetch();
            if ($cidade) {
                echo json_encode($cidade);
            } else {
                http_response_code(404);
                echo json_encode(['erro' => 'cidade não encontrada']);
            }
        } else {
            // listar todas as cidades com nome do país
            $stmt = $pdo->query('SELECT c.id_cidade, c.nome, c.populacao, c.id_pais, p.nome_oficial AS pais_nome
                                 FROM cidades c
                                 LEFT JOIN paises p ON c.id_pais = p.id_pais
                                 ORDER BY c.nome ASC');
            $cidades = $stmt->fetchAll();
            echo json_encode($cidades);
        }
        exit;
    }

    if ($method === 'POST') {
        $data = getJsonInput();
        if (empty($data['nome']) || !isset($data['populacao']) || !isset($data['id_pais'])) {
            http_response_code(400);
            echo json_encode(['erro' => 'campos obrigatórios faltando']);
            exit;
        }

        // verificar se país existe
        $stmt = $pdo->prepare('SELECT id_pais FROM paises WHERE id_pais = ?');
        $stmt->execute([intval($data['id_pais'])]);
        if (!$stmt->fetch()) {
            http_response_code(400);
            echo json_encode(['erro' => 'país informado não existe']);
            exit;
        }

        $stmt = $pdo->prepare('INSERT INTO cidades (nome, populacao, id_pais) VALUES (?, ?, ?)');
        $stmt->execute([
            $data['nome'],
            intval($data['populacao']),
            intval($data['id_pais'])
        ]);

        http_response_code(201);
        echo json_encode(['mensagem' => 'cidade criada', 'id_cidade' => (int)$pdo->lastInsertId()]);
        exit;
    }

    if ($method === 'PUT') {
        if (!$id) {
            http_response_code(400);
            echo json_encode(['erro' => 'id da cidade é obrigatório para atualizar']);
            exit;
        }
        $data = getJsonInput();
        if (empty($data['nome']) || !isset($data['populacao']) || !isset($data['id_pais'])) {
            http_response_code(400);
            echo json_encode(['erro' => 'campos obrigatórios faltando']);
            exit;
        }

        // verificar se país existe
        $stmt = $pdo->prepare('SELECT id_pais FROM paises WHERE id_pais = ?');
        $stmt->execute([intval($data['id_pais'])]);
        if (!$stmt->fetch()) {
            http_response_code(400);
            echo json_encode(['erro' => 'país informado não existe']);
            exit;
        }

        $stmt = $pdo->prepare('UPDATE cidades SET nome = ?, populacao = ?, id_pais = ? WHERE id_cidade = ?');
        $stmt->execute([
            $data['nome'],
            intval($data['populacao']),
            intval($data['id_pais']),
            $id
        ]);
        echo json_encode(['mensagem' => 'cidade atualizada']);
        exit;
    }

    if ($method === 'DELETE') {
        if (!$id) {
            http_response_code(400);
            echo json_encode(['erro' => 'id da cidade é obrigatório para excluir']);
            exit;
        }
        $stmt = $pdo->prepare('DELETE FROM cidades WHERE id_cidade = ?');
        $stmt->execute([$id]);
        echo json_encode(['mensagem' => 'cidade excluída']);
        exit;
    }

    http_response_code(405);
    echo json_encode(['erro' => 'método não suportado']);
    exit;

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'erro inesperado', 'detalhes' => $e->getMessage()]);
    exit;
}
