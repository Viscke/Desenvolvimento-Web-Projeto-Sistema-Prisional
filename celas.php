<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Celas - Sistema Prisional</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="wrapper">

        <nav class="menu-lateral">
            <h2>Sist. Prisional</h2>
            <ul>
                <li><a href="index.php">Painel</a></li>
                <li><a href="presos.php">Detentos</a></li>
                <li><a href="cadastro-preso.php">Cadastrar Detento</a></li>
                <li><a href="celas.php" class="ativo">Celas</a></li>
                <li><a href="visitas.php">Visitas</a></li>
                <li class="sair"><a href="login.php">Sair</a></li>
            </ul>
        </nav>

        <main class="conteudo">
            <h1>Celas</h1>

            <!-- form pra cadastrar ou editar uma cela -->
            <div class="caixa-form">
                <form action="salvar-cela.php" method="post">

                    <input type="hidden" name="id" id="id" value=""> <!-- vazio = cadastro novo -->

                    <div class="linha-form">
                        <div class="campo">
                            <label for="bloco">Bloco</label>
                            <input type="text" name="bloco" id="bloco" placeholder="Ex: A" required>
                        </div>

                        <div class="campo">
                            <label for="numero">Numero</label>
                            <input type="text" name="numero" id="numero" placeholder="Ex: 12" required>
                        </div>
                    </div>

                    <div class="linha-form">
                        <!-- quantas pessoas cabe na cela -->
                        <div class="campo">
                            <label for="capacidade">Capacidade</label>
                            <input type="number" name="capacidade" id="capacidade" min="1" required>
                        </div>

                        <div class="campo">
                            <label for="tipo">Tipo</label>
                            <select name="tipo" id="tipo">
                                <option value="individual">Individual</option>
                                <option value="coletiva">Coletiva</option>
                                <option value="isolamento">Isolamento</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primario">Salvar</button>
                    <a href="celas.php" class="btn btn-cancelar">Cancelar</a>

                </form>
            </div>

            <br>

            <!-- tabela com as celas ja cadastradas -->
            <div class="caixa-tabela">
                <h2>Lista de celas</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Bloco</th>
                            <th>Numero</th>
                            <th>Capacidade</th>
                            <th>Tipo</th>
                            <th>Acoes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>A</td>
                            <td>12</td>
                            <td>4</td>
                            <td>Coletiva</td>
                            <td class="acoes">
                                <a href="celas.php?id=1" class="btn btn-editar">Editar</a>
                                <form action="excluir-cela.php" method="post">
                                    <input type="hidden" name="id" value="1">
                                    <button type="submit" class="btn btn-excluir">Excluir</button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>B</td>
                            <td>04</td>
                            <td>2</td>
                            <td>Individual</td>
                            <td class="acoes">
                                <a href="celas.php?id=2" class="btn btn-editar">Editar</a>
                                <form action="excluir-cela.php" method="post">
                                    <input type="hidden" name="id" value="2">
                                    <button type="submit" class="btn btn-excluir">Excluir</button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>03</td>
                            <td>1</td>
                            <td>Isolamento</td>
                            <td class="acoes">
                                <a href="celas.php?id=3" class="btn btn-editar">Editar</a>
                                <form action="excluir-cela.php" method="post">
                                    <input type="hidden" name="id" value="3">
                                    <button type="submit" class="btn btn-excluir">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </main>

    </div>
    <script src="js/script.js"></script>
</body>

</html>