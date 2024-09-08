<!--- PROCESSAMENTO DO LOGIN DO PAINEL E VERIFICAÇÃO COM BD, PROCESSAR_LOGINPAINEL.PHP -->

<?php
session_start();

require '../bancodados/conexao.php';

if (isset($_SESSION['usuario_cpf'])) {
    header("Location: ../paginapainel/painel.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];

    $stmt = $conn->prepare("SELECT * FROM Usuarios WHERE cpf = ? AND senha = ?");
    $stmt->bind_param("ss", $cpf, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($user['bloqueado'] == 1) {
                $_SESSION['mensagem_erro'] = "Usuário bloqueado. Não é possível efetuar o login.";
            } else {
                if ($user['acesso_autorizado'] == 1) {
                    $_SESSION['usuario_cpf'] = $user['cpf'];
                    header("Location: ../paginapainel/painel.php");
                    exit();
                } else {
                    $_SESSION['mensagem_erro'] = "Acesso não autorizado. Por favor, contate o administrador.";
                }
            }
        } else {
            $_SESSION['mensagem_erro'] = "CPF ou senha inválidos. Tente novamente.";
        }
    } else {
        $_SESSION['mensagem_erro'] = "Erro na consulta: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}

header("Location: loginpainel.php");
exit();
?>