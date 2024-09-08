<?php
include_once('../bancodados/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $newTitle = $_POST['new_title'];
    $newSubtitle = $_POST['new_subtitle'];

    $sql = "UPDATE Produtos SET titulo = '$newTitle', subtitulo = '$newSubtitle' WHERE produto_id = $productId";

    if ($conn->query($sql) === TRUE) {
        echo "Dados atualizados com sucesso!";
    } else {
        echo "Erro ao atualizar dados: " . $conn->error;
    }
}

$conn->close();
?>