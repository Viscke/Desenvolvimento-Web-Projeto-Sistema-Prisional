<?php
// autenticar.php
session_start();
require_once 'config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // O formulário usa 'usuario', mas no banco a coluna é 'email'
    $email = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'] ?? '';

    if ($email && $senha) {
        // Prepared Statement para evitar SQL Injection no login
        $stmt = $pdo->prepare("SELECT id, nome, senha, perfil FROM usuarios WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch();

        // Valida a senha usando password_verify (compara com o Hash do banco)
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Autenticado com sucesso
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['perfil'] = $usuario['perfil'];
            
            header("Location: index.php");
            exit;
        }
    }
    
    // Se falhar, volta para a tela de login visual
    echo "<script>alert('Usuário ou senha inválidos!'); window.location='login.php';</script>";
    exit;
}
?>