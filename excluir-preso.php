<?php
// excluir-preso.php
session_start();
require_once 'config/conexao.php';

// Bloqueia acesso direto via GET na URL
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Valida se o ID recebido é realmente um número inteiro
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($id) {
        try {
            // Prepared Statement para blindar contra SQL Injection
            $stmt = $pdo->prepare("DELETE FROM presos WHERE id = :id");
            $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            // Registra o erro no log interno do servidor, sem expor falhas ao usuário
            error_log("Erro ao excluir preso: " . $e->getMessage());
        }
    }
}

// Volta para a tela de listagem
header("Location: presos.php");
exit;
?>