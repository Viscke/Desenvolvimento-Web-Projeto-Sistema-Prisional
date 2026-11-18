<?php
session_start();
require_once 'config/conexao.php';

// Busca os presos e a cela correspondente usando o LEFT JOIN que o grupo montou
try {
    $sql = "SELECT p.id, p.nome, p.cpf, p.regime, p.status, c.pavilhao, c.numero as cela_num 
            FROM presos p 
            LEFT JOIN celas c ON c.id = p.cela_id 
            ORDER BY p.id DESC";
    $stmt = $pdo->query($sql);
    $lista_presos = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log($e->getMessage());
    $lista_presos = []; // Array vazio em caso de erro para não quebrar a tela
}

// Função de segurança para neutralizar código malicioso
function limpar($texto) {
    return htmlspecialchars((string)$texto, ENT_QUOTES, 'UTF-8'); }
    
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
    <title>Detentos - Sistema Prisional</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="wrapper">

        <!-- menu lateral, igual nas outras paginas -->
        <nav class="menu-lateral">
            <h2>Sist. Prisional</h2>
            <ul>
                <li><a href="index.php">Painel</a></li>
                <li><a href="presos.php" class="ativo">Detentos</a></li>
                <li><a href="cadastro-preso.php">Cadastrar Detento</a></li>
                <li><a href="celas.php">Celas</a></li>
                <li><a href="visitas.php">Visitas</a></li>
                <li class="sair"><a href="login.php">Sair</a></li>
            </ul>
        </nav>

        <main class="conteudo">
            <h1>Detentos</h1>

            <!-- busca so manda pro php, nao tem get com filtro ainda -->
            <form action="buscar-preso.php" method="post" class="form-busca">
                <input type="text" name="busca" id="busca" placeholder="Buscar por nome ou CPF">
                <button type="submit" class="btn btn-primario">Buscar</button>
            </form>

            <!-- tabela com todos os presos cadastrados -->
            <div class="caixa-tabela">
                <h2>Lista de detentos</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Cela</th>
                            <th>Regime</th>
                            <th>Situacao</th>
                            <th>Acoes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($lista_presos)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">Nenhum detento cadastrado.</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($lista_presos as $preso): ?>
                            <tr>
                            <!-- Aplicação da função limpar() em todas as saídas -->
                            <td><?= limpar($preso['nome']) ?></td>
                            <td><?= formatarCPF(limpar($preso['cpf'])) ?></td>
                            <td>
                                <!-- Se tiver cela, formata "Pavilhão-Número", senão avisa -->
                                <?= $preso['pavilhao'] ? limpar($preso['pavilhao'] . '-' . $preso['cela_num']) : 'Sem cela' ?>
                            </td>
                            <td><?= ucfirst(limpar($preso['regime'])) ?></td>
                            <td>
                                <!-- A classe da tag muda a cor do CSS baseada no status -->
                                <span class="tag <?= limpar($preso['status']) ?>">
                                <?= ucfirst(limpar($preso['status'])) ?>
                                </span>
                            </td>
                            <td class="acoes">
                                <a href="cadastro-preso.php?id=<?= $preso['id'] ?>" class="btn btn-editar">Editar</a>
                                
                                <form action="excluir-preso.php" method="post" onsubmit="return confirm('Tem certeza que deseja excluir este registro?');">
                                <input type="hidden" name="id" value="<?= $preso['id'] ?>">
                                <button type="submit" class="btn btn-excluir">Excluir</button>
                                </form>
                            </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </main>

    </div>
    <script src="js/script.js"></script>
</body>
</html>