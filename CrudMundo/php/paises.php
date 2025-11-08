<?php
// php/paises.php
// api rest simples para gerir países
// métodos: GET (listar / buscar por id), POST (criar), PUT (atualizar), DELETE (excluir)
// comentários em português, minúsculos

header('Content-Type: application/json; charset=utf-8');
// permitir requests do frontend (ajuste origin conforme precisa)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // preflight
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/db.php';
$pdo = getPDO();

// helper: ler corpo json
function getJsonInput() {
    $data = json_decode(file_get_contents('php://input'), true);
    return is_array($data) ? $data : [];
}

// rota básica
$method = $_SERVER['REQUEST_METHOD'];
// quando ?id=xx ou /paises.php?id=xx
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

try {
    if ($method === 'GET') {
        if ($id) {
            // buscar país por id
            $stmt = $pdo->prepare('SELECT * FROM paises WHERE id_pais = ?');
            $stmt->execute([$id]);
            $pais = $stmt->fetch();
            if ($pais) {
                echo json_encode($pais);
            } else {
                http_response_code(404);
                echo json_encode(['erro' => 'país não encontrado']);
            }
        } else {
            // listar todos os países (ordenar por nome)
            $stmt = $pdo->query('SELECT * FROM paises ORDER BY nome_oficial ASC');
            $paises = $stmt->fetchAll();
            echo json_encode($paises);
        }
        exit;
    }

    if ($method === 'POST') {
        $data = getJsonInput();
        // validação básica
        if (empty($data['nome_oficial']) || empty($data['continente']) || !isset($data['populacao']) || empty($data['idioma'])) {
            http_response_code(400);
            echo json_encode(['erro' => 'campos obrigatórios faltando']);
            exit;
        }
        // inserir
        $stmt = $pdo->prepare('INSERT INTO paises (nome_oficial, continente, populacao, idioma) VALUES (?, ?, ?, ?)');
        $stmt->execute([
            $data['nome_oficial'],
            $data['continente'],
            intval($data['populacao']),
            $data['idioma']
        ]);
        $novoId = $pdo->lastInsertId();
        http_response_code(201);
        echo json_encode(['mensagem' => 'país criado', 'id_pais' => (int)$novoId]);
        exit;
    }

    if ($method === 'PUT') {
        if (!$id) {
            http_response_code(400);
            echo json_encode(['erro' => 'id do país é obrigatório para atualizar']);
            exit;
        }
        $data = getJsonInput();
        // validação
        if (empty($data['nome_oficial']) || empty($data['continente']) || !isset($data['populacao']) || empty($data['idioma'])) {
            http_response_code(400);
            echo json_encode(['erro' => 'campos obrigatórios faltando']);
            exit;
        }
        // atualizar
        $stmt = $pdo->prepare('UPDATE paises SET nome_oficial = ?, continente = ?, populacao = ?, idioma = ? WHERE id_pais = ?');
        $stmt->execute([
            $data['nome_oficial'],
            $data['continente'],
            intval($data['populacao']),
            $data['idioma'],
            $id
        ]);

        echo json_encode(['mensagem' => 'país atualizado']);
        exit;
    }

    if ($method === 'DELETE') {
        if (!$id) {
            http_response_code(400);
            echo json_encode(['erro' => 'id do país é obrigatório para excluir']);
            exit;
        }

        // verificar se país tem cidades associadas
        $stmt = $pdo->prepare('SELECT COUNT(*) as total FROM cidades WHERE id_pais = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        $totalCidades = $row ? intval($row['total']) : 0;

        // se tiver cidades, só pode excluir se ?cascade=1 for enviado
        $cascade = isset($_GET['cascade']) && $_GET['cascade'] === '1';

        if ($totalCidades > 0 && !$cascade) {
            http_response_code(409); // conflito
            echo json_encode(['erro' => 'país possui cidades associadas', 'cidades' => $totalCidades, 'aviso' => 'use ?cascade=1 para apagar também as cidades']);
            exit;
        }

        // se cascade, apagar cidades primeiro (transação)
        $pdo->beginTransaction();
        try {
            if ($cascade && $totalCidades > 0) {
                $stmt = $pdo->prepare('DELETE FROM cidades WHERE id_pais = ?');
                $stmt->execute([$id]);
            }

            $stmt = $pdo->prepare('DELETE FROM paises WHERE id_pais = ?');
            $stmt->execute([$id]);

            $pdo->commit();
            echo json_encode(['mensagem' => 'país excluído com sucesso', 'cidades_removidas' => $cascade ? $totalCidades : 0]);
        } catch (Exception $e) {
            $pdo->rollBack();
            http_response_code(500);
            echo json_encode(['erro' => 'falha ao excluir país', 'detalhes' => $e->getMessage()]);
        }
        exit;
    }

    // método não permitido
    http_response_code(405);
    echo json_encode(['erro' => 'método não suportado']);
    exit;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'erro inesperado', 'detalhes' => $e->getMessage()]);
    exit;
}
