<?php
include_once('../bancodados/conexao.php');

// Verifica se os dados foram enviados via POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém e valida o CPF do usuário através do URL.
    $cpf = isset($_GET['cpf']) ? $_GET['cpf'] : '';
    if (!preg_match('/^\d{11}$/', $cpf)) {
        echo "CPF inválido.";
        exit();
    }

    // Obtém e valida os novos dados do usuário.
    $new_name = isset($_POST['new_name']) ? $conn->real_escape_string($_POST['new_name']) : '';
    $new_email = isset($_POST['new_email']) ? $conn->real_escape_string($_POST['new_email']) : '';

    $sql = "UPDATE Usuarios SET nome_completo = ?, email = ? WHERE cpf = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $new_name, $new_email, $cpf);

    if ($stmt->execute()) {
        // Redireciona para a página de detalhes do usuário após a atualização.
        header("Location: ver_usuario.php?cpf=$cpf&msg=success");
        exit();
    } else {
        echo "Erro na Atualização: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>