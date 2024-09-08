<?php
include_once('../bancodados/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dados do formulário
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria_id = $_POST['categoria_id'];

    // Query de inserção
    $sql = "INSERT INTO produtos (nome, descricao, preco, categoria_id) VALUES ('$nome', '$descricao', '$preco', '$categoria_id')";

    if ($conn->query($sql) === TRUE) {
        // Redirecionamento para a página de cadastro com mensagem de sucesso.
        header("Location: cadastro_produto.php?sucesso=1");
    } else {
        // Redirecionamento para a página de cadastro com mensagem de erro.
        header("Location: cadastro_produto.php?erro=1");
    }
}

$conn->close();
exit;
?>