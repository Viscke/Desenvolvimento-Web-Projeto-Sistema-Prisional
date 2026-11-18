<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Login - Sistema Prisional</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<!-- essa pagina n tem menu lateral, é só a tela de login mesmo -->

<body class="login-pagina">

  <!-- caixa branca centralizada na tela -->
  <div class="login-caixa">
    <h1>Sistema Prisional</h1> <!-- titulo -->
    <p class="sub">entre com seu usuario</p> <!-- subtitulo -->

    <!-- pq post: senha n aparece na url -->
    <form action="autenticar.php" method="post">
      <!-- campo usuario -->
      <div class="campo">
        <label for="usuario">Usuario</label>
        <input type="text" name="usuario" id="usuario" required>
      </div>

      <!-- campo senha, type password esconde o que digita -->
      <div class="campo">
        <label for="senha">Senha</label>
        <input type="password" name="senha" id="senha" required>
      </div>

      <button type="submit" class="btn btn-primario" style="width:100%;">Entrar</button>
    </form>
  </div>

</body>

</html>