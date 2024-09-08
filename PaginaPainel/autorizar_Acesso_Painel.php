<!-- AUTORIZAÇÃO ACESSO AO PAINEL -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['cpf'])) {
    include('../bancodados/conexao.php');
    $cpf = $_GET['cpf'];

    $sql = "UPDATE Usuarios SET acesso_autorizado = 1 WHERE cpf = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cpf);

    if ($stmt->execute()) {
        echo "Acesso Autorizado para o CPF: $cpf.";
    } else {
        echo "Erro ao Autorizar o Acesso: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: painel.php");
    exit;
} else {
    echo "Requisição Inválida.";
}
?>