<!-- PAGINA PARA MODIFICAR INFORMAÇÕES, MODIFICAR_INFOR.PHP-->

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V-BR MODIFICAR INFORMAÇÕES</title>
    <link rel="stylesheet" href="stylepainel.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../img/logo.png" />
</head>
<body>
    <div class="container">
        <img src="../img/logo.png" alt="Logo" style="display: block; margin: 0 auto; max-width: 150px;">      
        <h1>MODIFICAR INFORMAÇÕES</h1>

        <?php
        session_start();
        include('../bancodados/conexao.php');

        if (!isset($_SESSION['usuario_cpf'])) {
            header("Location: ../login/loginpainel.php");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $cpf = $conn->real_escape_string($_GET['cpf']);

            if (isset($_POST['new_name']) && !empty($_POST['new_name'])) {
                $new_name = $conn->real_escape_string($_POST['new_name']);
                $sql = "UPDATE Usuarios SET nome_completo = '$new_name' WHERE cpf = '$cpf'";
                if ($conn->query($sql) !== TRUE) {
                    echo "Erro ao atualizar nome: " . $conn->error . "<br>";
                }
            }

            if (isset($_POST['new_email']) && !empty($_POST['new_email'])) {
                $new_email = $conn->real_escape_string($_POST['new_email']);
                $sql = "UPDATE Usuarios SET email = '$new_email' WHERE cpf = '$cpf'";
                if ($conn->query($sql) !== TRUE) {
                    echo "Erro ao atualizar e-mail: " . $conn->error . "<br>";
                }
            }

            if (isset($_POST['new_password']) && !empty($_POST['new_password'])) {
                $new_password = $conn->real_escape_string($_POST['new_password']);
                $sql = "UPDATE Usuarios SET senha = '$new_password' WHERE cpf = '$cpf'";
                if ($conn->query($sql) !== TRUE) {
                    echo "Erro ao atualizar senha: " . $conn->error . "<br>";
                }
            }
        }

        if (isset($_GET['cpf'])) {
            $cpf = $conn->real_escape_string($_GET['cpf']);

            $sql = "SELECT nome_completo, email, senha FROM Usuarios WHERE cpf = '$cpf'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Nome</th>";
                    echo "<th>E-mail</th>";
                    echo "<th>Senha</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>" . $row["nome_completo"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo '<td><input type="password" value="' . $row["senha"] . '" id="senha" name="senha" style="width: 100%"><br>';
                    echo '<input type="checkbox" onclick="mostrarSenha()"> Mostrar senha</td>';
                    echo "</tr>";
                    echo "</table>";
                }
            } else {
                echo "<p>Nenhum usuário encontrado.</p>";
            }
        }

        $conn->close();
        ?>

        <div class="edit-form">
            <form method="post">
                <input type="text" name="new_name" placeholder="Novo Nome">
                <button type="submit">Atualizar Nome</button>
            </form>

            <form method="post">
                <input type="text" name="new_email" placeholder="Novo E-mail">
                <button type="submit">Alterar E-mail Usuário</button>
            </form>

            <form method="post">
                <input type="password" name="new_password" placeholder="Nova Senha">
                <button type="submit">Alterar Senha Usuário</button>
            </form>
        </div>

        <script>
            function mostrarSenha() {
                var senhaInput = document.getElementById("senha");
                if (senhaInput.type === "password") {
                    senhaInput.type = "text";
                } else {
                    senhaInput.type = "password";
                }
            }
        </script>

        <a class="back-button" href="listar_usuarios.php">Voltar para Listar Usuários</a>
    </div>
</body>
</html>