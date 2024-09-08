<!-- CONSULTAR_USUARIO.PHP -->
<?php
include('../bancodados/conexao.php');

// Verifica se a conexão está definida antes de usar
if (!isset($conn)) {
    include('../bancodados/conexao.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o CPF foi enviado via formulário
    if (!empty($_POST["cpf"])) {
        $cpfConsulta = mysqli_real_escape_string($conn, $_POST["cpf"]);

        // Utilizando declaração preparada para evitar SQL Injection
        $sql = "SELECT * FROM Usuarios WHERE cpf = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $cpfConsulta);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            $mensagem = "Usuário não encontrado.";
        }

        $stmt->close();
    } else {
        $mensagem = "Por favor, digite um CPF.";
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
    <title>Consultar Usuário</title>
    <link rel="stylesheet" href="stylepainel.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../img/logo.png" />
</head>

<body>
    <div class="container">
        <img src="../img/logo.png" alt="Logo" style="display: block; margin: 0 auto; max-width: 150px;">
        <h1>Consultar Usuário</h1>
        <a href="Painel.php" class="user-info">Voltar ao Painel</a>

        <form method="post" action="consultarUsuario.php">
            <label for="cpf">Digite o CPF do usuário:</label>
            <input type="text" name="cpf" id="cpf" required>
            <input type="submit" value="Consultar">
        </form>

        <?php if (isset($mensagem)) : ?>
            <p><?php echo $mensagem; ?></p>
        <?php elseif (isset($row)) : ?>
            <table>
                <tr>
                    <th>Nome Completo</th>
                    <td><?php echo $row["nome_completo"]; ?></td>
                </tr>
                <tr>
                    <th>E-mail</th>
                    <td><?php echo $row["email"]; ?></td>
                </tr>
                <tr>
                    <th>uf</th>
                    <td><?php echo $row["uf"]; ?></td>
                </tr>

            </table>
        <?php endif; ?>
    </div>
</body>

</html>
