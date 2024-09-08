<?php
session_start();

// Verifica se o usuário está logado.
if (!isset($_SESSION['usuario_cpf'])) {
    header("Location: ../login/login.php");
    exit();
}

require_once("../bancodados/conexao.php");

// Verifica se a variável de sessão carrinho não existe; se não existir, irá criá-la.
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Verifica se foi enviado um ID de produto.
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT); // Validar o ID

    if ($id !== false && $id > 0) {
        $sql = "SELECT produto_id, nome, preco FROM Produtos WHERE produto_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result !== false && $result->num_rows > 0) {
            $produto = $result->fetch_assoc();

            // Adiciona o Produto ao Carrinho.
            $_SESSION['carrinho'][] = $produto;

            // Mensagem de feedback
            $mensagem = "Produto adicionado ao carrinho com sucesso!";
        } else {
            $mensagem = "Produto não encontrado.";
        }
    } else {
        $mensagem = "ID de produto inválido.";
    }
}
?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V-BR Carrinho</title>
    <link rel="stylesheet" href="stylePedidos.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../img/logo.png"/>
</head>
<body>
    <div class="container">
        <h1>Carrinho de Compras</h1>

        <!-- Mensagem de Feedback -->
        <?php if (isset($mensagem)) : ?>
            <div class="alert alert-info" role="alert">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>

        <!-- Produtos no carrinho -->
        <div class="cart-container">
            <h2>Seu Carrinho</h2>
            <div class="cart-items">
                <table>
                    <tr>
                        <th>Produto Escolhido</th>
                        <th>Preço</th>
                    </tr>
                    <?php
                    $subtotal = 0;
                    foreach ($_SESSION['carrinho'] as $produto) {
                        echo "<tr>";
                        echo "<td>{$produto['nome']}</td>";
                        echo "<td>R$ {$produto['preco']}</td>";
                        echo "</tr>";
                        $subtotal += $produto['preco'];
                    }
                    ?>
                    <tr>
                        <td><strong>Subtotal</strong></td>
                        <td><strong>R$ <?php echo number_format($subtotal, 2); ?></strong></td>
                    </tr>
                </table>
            </div>
            <a href="gerar_boleto.php" class="finalize-button">Gerar Boleto</a>
        </div>
    </div>
</body>
</html>