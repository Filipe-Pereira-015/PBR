<!-- EXCLUI O USUÁRIO DO SISTEMA -->

<?php
include('../bancodados/conexao.php');

if (isset($_GET['cpf'])) {
    $cpf_excluir = $_GET['cpf'];

    $sql = "DELETE FROM Usuarios WHERE cpf = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cpf_excluir);

    if ($stmt->execute()) {
        echo "Usuário Excluído com Sucesso!";
    } else {
        echo "Erro ao Excluir o Usuário: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

header("Location: painel.php");
exit;
?>