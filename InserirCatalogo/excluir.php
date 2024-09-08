<?php
include_once('../bancodados/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Obtém e valida o ID.
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    if ($id === false || $id <= 0) {
        echo "ID inválido.";
        exit();
    }

    $sql = "DELETE FROM Produtos WHERE produto_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: mdimg.php");
        exit();
    } else {
        echo "Erro ao Excluir o Registro: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>