<?php
// php/db.php

$DB_HOST = 'localhost';
$DB_NAME = 'bd_mundo';
$DB_USER = 'root';
$DB_PASS = '';
$DB_CHARSET = 'utf8mb4';

function getPDO() {
    global $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS, $DB_CHARSET;

    $dsn = "mysql:host={$DB_HOST};dbname={$DB_NAME};charset={$DB_CHARSET}";

    try {
        $pdo = new PDO($dsn, $DB_USER, $DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        // resposta JSON de erro e finaliza
        http_response_code(500);
        echo json_encode(['erro' => 'falha na conexão com o banco: ' . $e->getMessage()]);
        exit;
    }
}
