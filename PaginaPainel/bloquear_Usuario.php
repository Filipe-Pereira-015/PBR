<!-- BLOQUEA ACESSO DO USUARIO AO SISTEMA -->
<?php
if (isset($_GET['cpf'])) {
    include('../bancodados/conexao.php');
    
    $cpf_bloquear = $_GET['cpf'];

    $sql = "UPDATE Usuarios SET bloqueado = 1 WHERE cpf = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cpf_bloquear);

    if ($stmt->execute()) {
        echo "Usuário Bloqueado com Sucesso!";
    } else {
        echo "Erro ao Bloquear o Usuário: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

header("Location: painel.php");
exit;
?>