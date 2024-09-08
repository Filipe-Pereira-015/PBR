<?php
include_once('../bancodados/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['novo_subtitulo']) && isset($_GET['id'])) {
    $novoSubtitulo = $_POST['novo_subtitulo'];
    $produto_id = $_GET['id'];

    // Atualização do subtítulo.
    $sql = "UPDATE Produtos SET subtitulo = ? WHERE produto_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $novoSubtitulo, $produto_id);

    if ($stmt->execute()) {
        // Redirecionamento para a página de exibição.
        header("Location: MDIMG.php");
        exit;
    } else {
        echo "Erro ao Atualizar o Subtítulo: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>