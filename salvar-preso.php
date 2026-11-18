<?php
// salvar-preso.php
session_start();
require_once 'config/conexao.php';

// Bloqueia acesso direto via URL
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: presos.php");
    exit;
}

// Sanitização básica das entradas
$id              = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$nome            = trim($_POST['nome'] ?? '');
// Remove pontos e traços do CPF para salvar apenas os 11 números, como no banco
$cpf             = preg_replace('/[^0-9]/', '', $_POST['cpf'] ?? ''); 
$data_nascimento = $_POST['data_nascimento'] ?? '';
$sexo            = $_POST['sexo'] ?? '';
$crime           = trim($_POST['artigo'] ?? '');
$pena_meses      = filter_input(INPUT_POST, 'pena_anos', FILTER_VALIDATE_INT) * 12; // Converte anos p/ meses
$data_entrada    = $_POST['data_entrada'] ?? '';
$cela_id         = filter_input(INPUT_POST, 'cela_id', FILTER_VALIDATE_INT) ?: null;
$regime          = $_POST['regime'] ?? 'fechado';
$status          = $_POST['situacao'] ?? 'preso';
$observacoes     = trim($_POST['observacoes'] ?? '');

// Pega o ID do usuário que fez o login (se existir), senão usa 1 (admin padrão) para teste
$cadastrado_por = $_SESSION['usuario_id'] ?? 1;

try {
    if ($id) {
        // UPDATE (Editar Detento)
        $sql = "UPDATE presos SET 
                nome = :nome, cpf = :cpf, data_nascimento = :data_nascimento, sexo = :sexo, 
                crime = :crime, regime = :regime, pena_meses = :pena_meses, data_entrada = :data_entrada, 
                status = :status, cela_id = :cela_id, observacoes = :observacoes 
                WHERE id = :id";
                
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nome' => $nome, ':cpf' => $cpf, ':data_nascimento' => $data_nascimento,
            ':sexo' => $sexo, ':crime' => $crime, ':regime' => $regime, 
            ':pena_meses' => $pena_meses, ':data_entrada' => $data_entrada, 
            ':status' => $status, ':cela_id' => $cela_id, ':observacoes' => $observacoes, 
            ':id' => $id
        ]);
        
    } else {
        // INSERT (Novo Detento)
        $sql = "INSERT INTO presos 
                (nome, cpf, data_nascimento, sexo, crime, regime, pena_meses, data_entrada, status, cela_id, cadastrado_por, observacoes) 
                VALUES 
                (:nome, :cpf, :data_nascimento, :sexo, :crime, :regime, :pena_meses, :data_entrada, :status, :cela_id, :cadastrado_por, :observacoes)";
                
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nome' => $nome, ':cpf' => $cpf, ':data_nascimento' => $data_nascimento,
            ':sexo' => $sexo, ':crime' => $crime, ':regime' => $regime, 
            ':pena_meses' => $pena_meses, ':data_entrada' => $data_entrada, 
            ':status' => $status, ':cela_id' => $cela_id, 
            ':cadastrado_por' => $cadastrado_por, ':observacoes' => $observacoes
        ]);
    }

    // Redireciona de volta para a lista
    header("Location: presos.php");
    exit;

} catch (PDOException $e) {
    // Exibe um erro básico se o CPF já existir
    error_log($e->getMessage());
    echo "<script>alert('Erro ao salvar. Verifique se o CPF já está cadastrado.'); window.location='cadastro-preso.php';</script>";
}
?>