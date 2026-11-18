<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Painel - Sistema Prisional</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- wrapper junta o menu + conteudo lado a lado (flex) -->
    <div class="wrapper">

        <!-- menu lateral, é igual em toda pagina -->
        <nav class="menu-lateral">
            <h2>Sist. Prisional</h2> <!-- nome do sistema -->
            <ul>
                <!-- classe ativo marca em qual pagina a gnt esta -->
                <li><a href="index.php" class="ativo">Painel</a></li>
                <li><a href="presos.php">Detentos</a></li>
                <li><a href="cadastro-preso.php">Cadastrar Detento</a></li>
                <li><a href="celas.php">Celas</a></li>
                <li><a href="visitas.php">Visitas</a></li>
                <li class="sair"><a href="login.php">Sair</a></li> <!-- separado por uma linha no css -->
            </ul>
        </nav>

        <!-- conteudo principal da pagina -->
        <main class="conteudo">
            <h1>Painel</h1>

            <!-- div com os 4 cards de resumo -->
            <div class="cards">
                <div class="card">
                    <h3>Total de detentos</h3>
                    <div class="numero">134</div>
                </div>
                <div class="card vermelho"> <!-- card com borda vermelha, só visual -->
                    <h3>Celas ocupadas</h3>
                    <div class="numero">41</div>
                </div>
                <div class="card verde">
                    <h3>Vagas disponiveis</h3>
                    <div class="numero">9</div>
                </div>
                <div class="card amarelo">
                    <h3>Visitas hoje</h3>
                    <div class="numero">6</div>
                </div>
            </div>

            <!-- caixa com a tabela dos ultimos presos cadastrados -->
            <div class="caixa-tabela">
                <h2>Ultimos detentos cadastrados</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Cela</th>
                            <th>Regime</th>
                            <th>Situacao</th>
                        </tr>
                    </thead>
                    <!-- linhas de exemplo, dps o php preenche com o banco -->
                    <tbody>
                        <tr>
                            <td>Joao da Silva Souza</td>
                            <td>123.456.789-00</td>
                            <td>A-12</td>
                            <td>Fechado</td>
                            <td><span class="tag preso">Preso</span></td> <!-- tag colorida pela situacao -->
                        </tr>
                        <tr>
                            <td>Marcos Pereira Lima</td>
                            <td>987.654.321-00</td>
                            <td>B-04</td>
                            <td>Semiaberto</td>
                            <td><span class="tag transferido">Transferido</span></td>
                        </tr>
                        <tr>
                            <td>Carlos Eduardo Rocha</td>
                            <td>456.789.123-00</td>
                            <td>A-03</td>
                            <td>Fechado</td>
                            <td><span class="tag preso">Preso</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </main>

    </div>


    <script src="js/script.js"></script>
</body>
</html>