<?php
include_once('../bancodados/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $produto_id = $_GET['id'];

    $sql = "DELETE FROM Produtos WHERE produto_id='$produto_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: consulta.php");
        exit();
    } else {
        echo "Erro ao Deletar o Produto: " . $conn->error;
    }
}

$conn->close();
?>