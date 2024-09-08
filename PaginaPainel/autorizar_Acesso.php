<!-- AUTORIZA ACESSO DO USUARIO AO SISTEMA -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['cpf'])) {
    include('../bancodados/conexao.php');

    $cpf = $_GET['cpf'];
    $sql = "UPDATE Usuarios SET acesso_autorizado = 1 WHERE cpf = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cpf);

    if ($stmt->execute()) {
        echo "Acesso ao Painel Permitido com Sucesso!";
    } else {
        echo "Erro ao Permitir Acesso: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>