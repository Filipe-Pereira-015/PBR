<!-- PERMITE ACESSO AO PAINEL -->

<?php
// Incluir o arquivo de conexão
include('../bancodados/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['cpf'])) {
    $cpf = $_GET['cpf'];

    $sql = "UPDATE Usuarios SET acesso_autorizado = 1 WHERE cpf = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cpf);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Acesso autorizado para o CPF: $cpf.";
    } else {
        echo "Erro ao autorizar o acesso: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Requisição inválida.";
}

$conn->close();
?>