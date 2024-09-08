<!--- PAGINA DE CADASTRO, CADASTRO.PHP -->

<?php
require '../bancodados/conexao.php';

$message = ""; // Inicializa as mensagens.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome_completo'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];

    $query = "SELECT * FROM Usuarios WHERE cpf = '$cpf'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $message = "CPF já Cadastrado. Tente Novamente!";
    } else {
        $sql = "INSERT INTO Usuarios (nome_completo, email, cpf, senha) VALUES ('$nome', '$email', '$cpf', '$senha')";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Cadastro Realizado com Sucesso!";
            echo "<script>window.location = '../index.html';</script>";
            exit();
        } else {
            $message = "Erro ao Cadastrar: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre-se V-BR</title>
    <link rel="stylesheet" href="styleCadastro.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../img/logo.png"/>
</head>
<body>
    <div class="centered">
        <img src="../img/logo.png" alt="Logo" class="logo">
        <h1 class="text-3d">Cadastre-se V-BR</h1>
        <div class="card">
            <?php
                
                if (!empty($message)) {
                    echo "<div class='message'>$message</div>";
                }
            ?>
            <form method="post" action="cadastro.php">
                <div class="form-group">
                    <input type="text" name="nome_completo" placeholder="Nome Completo" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="E-mail" required>
                </div>
                <div class="form-group">
                    <input type="text" name="cpf" placeholder="CPF" required>
                </div>
                <div class="form-group">
                    <input type="password" name="senha" placeholder="Senha (mín. 8, máx. 10 caracteres)" pattern=".{8,10}" title="A senha deve ter de 8 a 10 caracteres numéricos" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Cadastrar" class="btn">
                    <a href="../index.html" class="btn">Pagina Inicial</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>