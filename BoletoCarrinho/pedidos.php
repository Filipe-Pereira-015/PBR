<?php
session_start();

// Verifica se o usuário está logado.
if (!isset($_SESSION['usuario_cpf'])) {
    header("Location: ../login/login.php");
    exit();
}

?>

<?php
require_once("../bancodados/conexao.php"); 

// Verificar se a variável de sessão carrinho não existe; se não existir, vai criar.
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Verificar se foi enviado um ID de produto para adicionar ao carrinho.
if (isset($_GET['add'])) {
    // Recuperar as informações do produto do banco de dados usando o ID
    $id = $_GET['add'];
    $sql = "SELECT produto_id, nome, preco FROM Produtos WHERE produto_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result !== false && $result->num_rows > 0) {
        $produto = $result->fetch_assoc();


        $_SESSION['carrinho'][] = $produto;
    }

    // Redirecionar de volta para a página pedidos.php
    header("Location: pedidos.php");
    exit;
}

// Verificar se foi enviado um ID de produto para remover do carrinho
if (isset($_GET['remove'])) {
    // O ID do produto a ser removido
    $id = $_GET['remove'];

    // Percorrer o carrinho e remover o produto com o ID correspondente.
    foreach ($_SESSION['carrinho'] as $chave => $produto) {
        if ($produto['produto_id'] == $id) {
            unset($_SESSION['carrinho'][$chave]);
        }
    }

    // Redirecionar de volta para a página pedidos.php
    header("Location: pedidos.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V-BR Pedidos</title>
    <link rel="stylesheet" href="stylePedidos.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../img/logo.png"/>
</head>
<body>
    <div class="container">
        <h1>Pedidos</h1>

        <div class="search-form">
            <form method="POST" action="">
                <input type="text" name="searchName" placeholder="Pesquisar por Nome/Título do Produto">
                <input type="submit" value="Pesquisar">
            </form>
        </div>

        <div class="cart-container">
            <h2>Seu Carrinho</h2>
            <div class="cart-items">
                <table>
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Ações</th>
                    </tr>
                    <?php
                    $subtotal = 0;
                    foreach ($_SESSION['carrinho'] as $produto) {
                        echo "<tr>";
                        echo "<td>{$produto['nome']}</td>";
                        echo "<td>R$ " . number_format($produto['preco'], 2) . "</td>";
                        echo "<td><a href='pedidos.php?remove={$produto['produto_id']}' class='remove-button'>Remover</a></td>";
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
            <a href="carrinho.php" class="finalize-button">Finalizar Pedido</a>
            <a href="../paginacatalogo/exibir.php" class="finalize-button">Voltar</a>
        </div>

        <?php
        $sql = "SELECT produto_id, nome, preco, descricao FROM Produtos";

        if (isset($_POST['searchName']) && !empty($_POST['searchName'])) {
            $searchName = "%" . $_POST['searchName'] . "%";
            $sql .= " WHERE nome LIKE ?";
        }

        $stmt = $conn->prepare($sql);

        if (isset($searchName)) {
            $stmt->bind_param("s", $searchName);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        ?>

        <!-- Formulário de Resultados -->
        <form method="POST" action="carrinho.php">
            <div class="results-form">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Descrição</th>
                        <th>Adicionar ao Carrinho</th>
                    </tr>

                    <?php
                    if ($result !== false && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['produto_id']}</td>";
                            echo "<td>{$row['nome']}</td>";
                            echo "<td>R$ " . number_format($row['preco'], 2) . "</td>";
                            echo "<td>{$row['descricao']}</td>";
                            echo "<td><a href='pedidos.php?add={$row['produto_id']}' class='cart-button'>Adicionar</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Nenhum produto encontrado.</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </form>
    </div>
</body>
</html>