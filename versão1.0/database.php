<?php
mb_internal_encoding("UTF-8");

require_once 'config.php';

function connectDatabase() {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        // Adicione esta linha para garantir a compatibilidade de caracteres
        $pdo->exec("SET NAMES utf8mb4");
        return $pdo;
    } catch (\PDOException $e) {
        // Loga o erro detalhado para depuração, sem expô-lo ao usuário
        error_log("Erro de conexão PDO: " . $e->getMessage());
        return null;
    }
}

function executeQuery(PDO $conn, $sql, $params = []) {
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (\PDOException $e) {
        // Loga o erro da consulta para depuração
        error_log("Erro na consulta PDO: " . $e->getMessage());
        return [];
    }
}