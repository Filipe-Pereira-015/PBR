<?php
session_start();
include_once('../bancodados/conexao.php');

function getSearchCondition($field, $value) {
    return isset($value) && !empty($value) ? "$field LIKE '%$value%'" : '';
}

$searchID = $_POST['searchID'] ?? null;
$searchName = $_POST['searchName'] ?? null;

$sql = "SELECT produto_id, nome, preco, descricao FROM Produtos";

$searchConditions = array(
    getSearchCondition('produto_id', $searchID),
    getSearchCondition('nome', $searchName)
);

$searchConditions = array_filter($searchConditions);
if (!empty($searchConditions)) {
    $sql .= " WHERE " . implode(" AND ", $searchConditions);
}

$result = $conn->query($sql);
?>

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
    <h1>Consulta/Edição/Exclusão V-BR</h1>

    <form method="POST" action="">
        <div class="search-form">
            <input type="text" name="searchID" placeholder="Pesquisar por ID do Produto" value="<?php echo $searchID; ?>">
            <input type="text" name="searchName" placeholder="Pesquisar por Nome/Título do Produto" value="<?php echo $searchName; ?>">
            <input type="submit" value="Pesquisar">
        </div>
        <a href="cadastro_produto.php" class="button">Voltar ao Cadastro</a><br>
        <a href="../paginapainel/painel.php" class="button">Voltar ao Painel</a>
    </form>

    <!-- Form de Resultados -->
    <form method="POST" action="">
        <div class="results-form">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nome Produto</th>
                    <th>Preço</th>
                    <th>Descrição</th>
                    <th>Escolha uma Ação</th>
                </tr>

                <?php
                if ($result !== false && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['produto_id']}</td>";
                        echo "<td>{$row['nome']}</td>";
                        echo "<td>R$ {$row['preco']}</td>";
                        echo "<td>{$row['descricao']}</td>";
                        echo "<td><a href='edit.php?id={$row['produto_id']}' class='edit-button'>Editar</a> | <a href='delete.php?id={$row['produto_id']}' class='delete-button'>Excluir</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum Produto Encontrado.</td></tr>";
                }
                ?>
            </table>
        </div>
    </form>
</div>
</body>
</html>