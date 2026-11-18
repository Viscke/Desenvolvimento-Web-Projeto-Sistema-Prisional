<?php
session_start();
require_once 'config/conexao.php';

$presoEdicao = null;
$penaAnos = '';

// Se vier um ID na URL, significa que o usuário clicou em "Editar"
if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($id) {
        $stmt = $pdo->prepare("SELECT * FROM presos WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $presoEdicao = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Converte a pena que está em meses no banco de volta para anos no formulário
        if ($presoEdicao && $presoEdicao['pena_meses']) {
            $penaAnos = $presoEdicao['pena_meses'] / 12;
        }
    }
}

// Função para evitar que códigos maliciosos quebrem o HTML (XSS)
function limpar($texto) {
    return htmlspecialchars((string)$texto, ENT_QUOTES, 'UTF-8');
}

// Função para exibir o CPF com a máscara visual
function formatarCPF($cpf) {
    // Remove tudo que não for número (por garantia)
    $cpfLimpo = preg_replace('/[^0-9]/', '', $cpf);
    
    // Se tiver exatamente 11 dígitos, aplica a máscara
    if (strlen($cpfLimpo) === 11) {
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cpfLimpo);
    }
    
    // Se for um CPF quebrado antigo (como o 0354), retorna como está
    return $cpfLimpo;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title><?= $presoEdicao ? 'Editar' : 'Cadastrar' ?> Detento - Sistema Prisional</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <div class="wrapper">

    <nav class="menu-lateral">
      <h2>Sist. Prisional</h2>
      <ul>
        <li><a href="index.php">Painel</a></li>
        <li><a href="presos.php">Detentos</a></li>
        <li><a href="cadastro-preso.php" class="ativo">Cadastrar Detento</a></li>
        <li><a href="celas.php">Celas</a></li>
        <li><a href="visitas.php">Visitas</a></li>
        <li class="sair"><a href="login.php">Sair</a></li>
      </ul>
    </nav>

    <main class="conteudo">
      <h1><?= $presoEdicao ? 'Editar Detento' : 'Cadastrar Detento' ?></h1>

      <div class="caixa-form">
        <form action="salvar-preso.php" method="post" id="form-cadastro">

          <!-- O ID preenchido aqui é o que diz pro salvar-preso.php fazer um UPDATE em vez de INSERT -->
          <input type="hidden" name="id" id="id" value="<?= limpar($presoEdicao['id'] ?? '') ?>">

          <div class="campo">
            <label for="nome">Nome completo</label>
            <input type="text" name="nome" id="nome" required value="<?= limpar($presoEdicao['nome'] ?? '') ?>">
          </div>

          <div class="linha-form">
            <div class="campo">
              <label for="cpf">CPF</label>
              <input type="text" name="cpf" id="cpf" maxlength="14" placeholder="000.000.000-00" required value="<?= formatarCPF(limpar($presoEdicao['cpf'] ?? '')) ?>">
            </div>

            <div class="campo">
              <label for="data_nascimento">Data de nascimento</label>
              <input type="date" name="data_nascimento" id="data_nascimento" required value="<?= limpar($presoEdicao['data_nascimento'] ?? '') ?>">
            </div>
          </div>

          <div class="campo">
            <label for="nome_mae">Nome da mae</label>
            <!-- Nota: A tabela do banco não possui coluna 'nome_mae', deixei o campo vazio -->
            <input type="text" name="nome_mae" id="nome_mae">
          </div>

          <div class="linha-form">
            <div class="campo">
              <label for="sexo">Sexo</label>
              <select name="sexo" id="sexo" required>
                <option value="">Selecione</option>
                <option value="M" <?= ($presoEdicao['sexo'] ?? '') === 'M' ? 'selected' : '' ?>>Masculino</option>
                <option value="F" <?= ($presoEdicao['sexo'] ?? '') === 'F' ? 'selected' : '' ?>>Feminino</option>
              </select>
            </div>

            <div class="campo">
              <label for="artigo">Artigo (crime)</label>
              <!-- A coluna no banco se chama 'crime' -->
              <input type="text" name="artigo" id="artigo" placeholder="Ex: Art. 157" value="<?= limpar($presoEdicao['crime'] ?? '') ?>">
            </div>

            <div class="campo">
              <label for="pena_anos">Pena (anos)</label>
              <input type="number" name="pena_anos" id="pena_anos" min="0" step="1" value="<?= limpar($penaAnos) ?>">
            </div>
          </div>

          <div class="linha-form">
            <div class="campo">
              <label for="data_entrada">Data de entrada</label>
              <input type="date" name="data_entrada" id="data_entrada" required value="<?= limpar($presoEdicao['data_entrada'] ?? '') ?>">
            </div>

            <div class="campo">
              <label for="cela_id">Cela</label>
              <select name="cela_id" id="cela_id">
                <option value="">Selecione</option>
                <option value="1" <?= ($presoEdicao['cela_id'] ?? '') == '1' ? 'selected' : '' ?>>A-12</option>
                <option value="2" <?= ($presoEdicao['cela_id'] ?? '') == '2' ? 'selected' : '' ?>>B-04</option>
                <option value="3" <?= ($presoEdicao['cela_id'] ?? '') == '3' ? 'selected' : '' ?>>A-03</option>
              </select>
            </div>
          </div>

          <div class="linha-form">
            <div class="campo">
              <label for="regime">Regime</label>
              <select name="regime" id="regime">
                <option value="fechado" <?= ($presoEdicao['regime'] ?? '') === 'fechado' ? 'selected' : '' ?>>Fechado</option>
                <option value="semiaberto" <?= ($presoEdicao['regime'] ?? '') === 'semiaberto' ? 'selected' : '' ?>>Semiaberto</option>
                <option value="aberto" <?= ($presoEdicao['regime'] ?? '') === 'aberto' ? 'selected' : '' ?>>Aberto</option>
              </select>
            </div>

            <div class="campo">
              <label for="situacao">Situacao</label>
              <select name="situacao" id="situacao">
                <option value="preso" <?= ($presoEdicao['status'] ?? '') === 'preso' ? 'selected' : '' ?>>Preso</option>
                <option value="transferido" <?= ($presoEdicao['status'] ?? '') === 'transferido' ? 'selected' : '' ?>>Transferido</option>
                <option value="liberado" <?= ($presoEdicao['status'] ?? '') === 'liberado' ? 'selected' : '' ?>>Solto/Liberado</option>
              </select>
            </div>
          </div>

          <div class="campo">
            <label for="observacoes">Observacoes</label>
            <textarea name="observacoes" id="observacoes"><?= limpar($presoEdicao['observacoes'] ?? '') ?></textarea>
          </div>

          <button type="submit" class="btn btn-primario">Salvar</button>
          <a href="presos.php" class="btn btn-cancelar">Cancelar</a>

        </form>
      </div>

    </main>
  </div>

  <script src="js/script.js"></script>
</body>
</html>