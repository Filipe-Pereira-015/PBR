<!-- PAGINA DE LISTAR USUÁRIOS DO BD, LISTAR_USUARIOS.PHP -->
<?php
session_start();

include('../bancodados/conexao.php');

if (!isset($_SESSION['usuario_cpf'])) {
    header("Location: ../login/loginpainel.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V-BR Usuários</title>
    <link rel="stylesheet" href="stylepainel.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../img/logo.png" />
</head>

<body>
    <div class="container">
        <img src="../img/logo.png" alt="Logo" style="display: block; margin: 0 auto; max-width: 150px;">
        <h1>V-BR USUÁRIOS</h1>
        <a href="Painel.php" class="user-info">Voltar ao Painel</a>

        <label for="ordenacao">Ordenar por Chave Primária:</label>
        <select id="ordenacao">
            <option value="0">Nome</option>
            <option value="1">E-mail</option>
            <option value="2">CPF</option>
        </select>

        <select id="direcao">
            <option value="asc">Ascendente</option>
            <option value="desc">Descendente</option>
        </select>

        <button onclick="concluirOrdenacao()">Concluir</button>

        <table id="usuariosTable">
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>CPF</th>
            </tr>

            <?php
            include('../bancodados/conexao.php');

            $sql = "SELECT * FROM Usuarios";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr onclick=\"window.location='modificar_infor.php?cpf=" . $row['cpf'] . "'\">";
                    echo "<td>" . $row["nome_completo"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["cpf"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Nenhum usuário encontrado.</td></tr>";
            }

            $conn->close();
            ?>
        </table>
    </div>

    <script src="listarPorOrdem.js"></script>

    <script>
    function concluirOrdenacao() {
        var ordenacao = document.getElementById("ordenacao").value;
        var direcao = document.getElementById("direcao").value;

        ordenarPorChavePrimaria(ordenacao, direcao);
    }
</script>

</body>

</html>
