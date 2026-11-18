<?php
// ============================================================
//  Conexão com o banco de dados (MySQL) usando PDO.
//  Toda página PHP que precisar do banco começa com:
//      require_once __DIR__ . '/config/conexao.php';   (ajuste o caminho)
//  e depois usa a variável $pdo.
// ============================================================

// Dados de acesso. No XAMPP o padrão é usuário "root" sem senha.
$host    = 'localhost';
$banco   = 'sistema_prisional';
$usuario = 'root';
$senha   = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$banco;charset=utf8mb4",
        $usuario,
        $senha,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // erros de SQL viram exceção (mais fácil de achar o problema)
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // resultados vêm como array ['coluna' => valor]
            PDO::ATTR_EMULATE_PREPARES   => false,                  // prepared statements de verdade (protege contra SQL Injection)
        ]
    );
} catch (PDOException $e) {
    // Se não conectar, para a página com uma mensagem simples
    die('Erro ao conectar com o banco de dados. Verifique se o MySQL está ligado e se o banco foi importado.');
}

/* Exemplo de uso em outra página:

    $stmt = $pdo->prepare('SELECT * FROM presos WHERE id = ?');
    $stmt->execute([$id]);
    $preso = $stmt->fetch();
*/
