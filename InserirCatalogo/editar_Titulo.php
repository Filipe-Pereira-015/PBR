<?php
include_once('../bancodados/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['novo_titulo']) && isset($_GET['id'])) {
    $novoTitulo = $_POST['novo_titulo'];
    $produto_id = $_GET['id'];

    // Atualização do título.
    $sql = "UPDATE Produtos SET titulo = ? WHERE produto_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $novoTitulo, $produto_id);

    if ($stmt->execute()) {
        // Redirecionamento para a página de exibição.
        header("Location: MDIMG.php");
        exit;
    } else {
        echo "Erro ao Atualizar o Título: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
