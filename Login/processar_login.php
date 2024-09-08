<?php
session_start();

require '../bancodados/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];

    // Prevenir SQL injection.
    $stmt = $conn->prepare("SELECT * FROM Usuarios WHERE cpf=? AND senha=?");
    $stmt->bind_param("ss", $cpf, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($user['bloqueado'] == 1) {
                $_SESSION['mensagem_erro'] = "Usuário bloqueado. Não é possível efetuar o login.";
            } else {
                // Se a Autenticação for bem-sucedida.
                $_SESSION['usuario_cpf'] = $user['cpf'];
                header("Location: ../PaginaCatalogo/exibir.php");
                exit();
            }
        } else {
            $_SESSION['mensagem_erro'] = "CPF ou Senha inválidos. Tente novamente!";
        }
    } else {
        $_SESSION['mensagem_erro'] = "Erro na consulta: " . $conn->error;
    }

    $stmt->close();
}

// Se o código chegou aqui, algo deu errado no processamento do login.
$_SESSION['mensagem_erro'] = "Erro no processamento do login. Tente novamente mais tarde.";

header("Location: login.php"); // Redireciona de volta para a página de login.
exit();
?>