<?php
session_start();
include_once('../bancodados/conexao.php');

function redirectToConsulta() {
    header("Location: consulta.php");
    exit();
}

// Método POST, trata os dados.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $produto_id = $_POST['produto_id'];
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $descricao = $_POST['descricao'];

    $sql = "UPDATE Produtos SET nome='$nome', preco='$preco', descricao='$descricao' WHERE produto_id='$produto_id'";

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        redirectToConsulta();
    } else {
        echo "Erro ao Atualizar o Produto: " . $conn->error;
    }
}

// Método GET, exibe o formulário de edição.
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $produto_id = $_GET['id'];
    $sql = "SELECT * FROM Produtos WHERE produto_id='$produto_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
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
        <h1>Modificar Produtos</h1>
        <form method="post" action="">
            <input type="hidden" name="produto_id" value="<?php echo $row['produto_id']; ?>">
            <label for="nome">Nome do Produto:</label>
            <input type="text" name="nome" value="<?php echo $row['nome']; ?>">
            <label for="preco">Preço:</label>
            <input type="text" name="preco" value="<?php echo $row['preco']; ?>">
            <label for="descricao">Descrição:</label>
            <input type="text" name="descricao" value="<?php echo $row['descricao']; ?>">
            <input type="submit" value="Salvar">
        </form>
    </div>
</body>
</html>
<?php
    } else {
        echo "Produto não Encontrado";
    }
    $conn->close();
}
?>