<!--- PAGINA DE LOGIN VINCULADA AO PAINEL, LOGINPAINEL.PHP -->

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V-BR Private</title>
    <link rel="stylesheet" href="stylelogin.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../img/logo.png"/>
</head>
<body>
    <div class="centered">
        <img src="../img/logo.png" alt="Logo" class="logo">
        <h1 class="text-3d">V-BR Private</h1>
        <div class="card">
            <?php
            session_start();
            
            if (isset($_SESSION['mensagem_erro'])) {
                echo '<div class="alert alert-danger" role="alert">' . $_SESSION['mensagem_erro'] . '</div>';
                unset($_SESSION['mensagem_erro']); // Irá Limpar a mensagem de erro para que não seja exibida novamente.
            }
            ?>
            <form method="post" action="processar_loginPainel.php">
                <div class="form-group">
                    <label for="cpf"></label>
                    <input type="text" id="cpf" name="cpf" placeholder="CPF" required>
                </div>
                <div class="form-group">
                    <label for="senha"></label>
                    <input type="password" id="senha" name="senha" placeholder="Senha" required>
                </div>
                <div class="button-group">
                    <input type="submit" value="Login" class="btn">
                    <a href="../paginapainel/painel.php" class="btn" style="display: none;">Catálogo</a>
                    <a href="../index.html" class="btn">Página Inicial</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>