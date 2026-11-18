<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Visitas - Sistema Prisional</title>
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
                <li><a href="celas.php">Celas</a></li>
                <li><a href="visitas.php" class="ativo">Visitas</a></li>
                <li class="sair"><a href="login.php">Sair</a></li>
            </ul>
        </nav>

        <main class="conteudo">
            <h1>Visitas</h1>

            <!-- form pra marcar uma visita -->
            <div class="caixa-form">
                <form action="salvar-visita.php" method="post">

                    <input type="hidden" name="id" id="id" value="">

                    <!-- esse select deveria vir do banco de presos, aqui ta fixo -->
                    <div class="campo">
                        <label for="preso_id">Detento</label>
                        <select name="preso_id" id="preso_id" required>
                            <option value="">Selecione</option>
                            <option value="1">Joao da Silva Souza</option>
                            <option value="2">Marcos Pereira Lima</option>
                            <option value="3">Carlos Eduardo Rocha</option>
                        </select>
                    </div>

                    <div class="linha-form">
                        <div class="campo">
                            <label for="visitante_nome">Nome do visitante</label>
                            <input type="text" name="visitante_nome" id="visitante_nome" required>
                        </div>

                        <div class="campo">
                            <label for="visitante_cpf">CPF do visitante</label>
                            <input type="text" name="visitante_cpf" id="visitante_cpf" maxlength="14"
                                placeholder="000.000.000-00" required>
                        </div>
                    </div>

                    <div class="linha-form">
                        <div class="campo">
                            <label for="parentesco">Parentesco</label>
                            <input type="text" name="parentesco" id="parentesco" placeholder="Ex: Mae, Esposa...">
                        </div>

                        <div class="campo">
                            <label for="data_visita">Data da visita</label>
                            <input type="date" name="data_visita" id="data_visita" required>
                        </div>

                        <!-- type time já da um relogio pro usuario escolher a hora -->
                        <div class="campo">
                            <label for="hora_visita">Hora da visita</label>
                            <input type="time" name="hora_visita" id="hora_visita" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primario">Salvar</button>
                    <a href="visitas.php" class="btn btn-cancelar">Cancelar</a>

                </form>
            </div>

            <br>

            <!-- tabela com as visitas marcadas -->
            <div class="caixa-tabela">
                <h2>Lista de visitas</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Detento</th>
                            <th>Visitante</th>
                            <th>CPF</th>
                            <th>Parentesco</th>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Acoes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Joao da Silva Souza</td>
                            <td>Maria Souza</td>
                            <td>111.222.333-44</td>
                            <td>Mae</td>
                            <td>20/11/2026</td>
                            <td>14:00</td>
                            <td class="acoes">
                                <a href="visitas.php?id=1" class="btn btn-editar">Editar</a>
                                <form action="excluir-visita.php" method="post">
                                    <input type="hidden" name="id" value="1">
                                    <button type="submit" class="btn btn-excluir">Excluir</button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>Marcos Pereira Lima</td>
                            <td>Ana Lima</td>
                            <td>222.333.444-55</td>
                            <td>Esposa</td>
                            <td>21/11/2026</td>
                            <td>10:30</td>
                            <td class="acoes">
                                <a href="visitas.php?id=2" class="btn btn-editar">Editar</a>
                                <form action="excluir-visita.php" method="post">
                                    <input type="hidden" name="id" value="2">
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