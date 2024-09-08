<!-- DESBLOQUEA O USUÁRIO -->

<?php
include('../bancodados/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['cpf'])) {
    $cpf = $_GET['cpf'];

    $sql = "UPDATE Usuarios SET bloqueado = 0 WHERE cpf = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cpf);

    if ($stmt->execute()) {
        echo "Usuário Desbloqueado com Sucesso.";
    } else {
        echo "Erro ao Desbloquear o Usuário: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

// Redirecionamento para painel.php após o desbloqueio.
header("Location: painel.php");
exit;
?>