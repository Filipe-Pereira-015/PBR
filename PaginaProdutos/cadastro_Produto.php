<!--- PÁGINA PRODUTOS -->

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V-BR Produtos</title>
    <link rel="stylesheet" href="styleProdutos.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../img/logo.png"/>
</head>
<body>
    <div class="container">
        <img class="logo" src="../img/logo.png" alt="Logo">
        <h1>Cadastro de Produtos</h1>
        <form method="POST" action="processar_cadastro.php">
            <label for="nome">Nome do Produto:</label>
            <input type="text" name="nome" required>

            <label for="descricao">Descrição:</label>
            <textarea name="descricao"></textarea>

            <label for="preco">Preço:</label>
            <input type="text" name="preco" required>

            <label for="categoria_id">Categoria:</label>
            <select name="categoria_id">
                <option value="1">Lazer e Turismo</option>
                <option value="2">Viagens de Negócios</option>
                <option value="3">Aventura e Exploração</option>
                <option value="4">Férias em Família</option>
                <option value="5">Viagens Culturais</option>
                <option value="6">Vigem de Luxo e Relaxamento</option>
                <option value="7">Viagens Educativas</option>
                <option value="8">Viagens de Aventura e Gastrônomia</option>
            </select>

            <input type="submit" value="Cadastrar Produto">
            <a href="consulta.php" class="button">Consultar Produtos</a></br>
            <a href="../paginapainel/painel.php" class="button">Voltar ao Painel</a>
        </form>

        <?php
        // Verificação e exibição das mensagens.
        if (isset($_GET['sucesso'])) {
            echo '<p class="mensagem sucesso">Cadastro realizado com sucesso!</p>';
        } elseif (isset($_GET['erro'])) {
            echo '<p class="mensagem erro">Ocorreu um erro no cadastro.</p>';
        }
        ?>
    </div>
</body>
</html>