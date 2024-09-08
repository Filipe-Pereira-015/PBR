<?php
include_once('../bancodados/conexao.php');

$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$codigo_unico = $_POST['codigo_unico'];
$preco = $_POST['preco'];
$categoria_id = $_POST['categoria_id'];

$sql = "INSERT INTO Produtos (nome, descricao, codigo_unico, preco, categoria_id) VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdsi", $nome, $descricao, $codigo_unico, $preco, $categoria_id);

if ($stmt->execute()) {
    echo "Produto Adicionado com Sucesso.";
} else {
    if ($conn->errno == 1452) {
        echo "Erro ao Adicionar o Produto: A Categoria Especificada não Existe. Verifique a Categoria e Tente Novamente.";
    } else {
        echo "Erro ao Adicionar o Produto: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>