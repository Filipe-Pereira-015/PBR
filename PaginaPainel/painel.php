<!-- PÁGINA PAINEL, PAINEL.PHP -->

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
    <title>V-BR Painel Gerencial</title>
    <link rel="stylesheet" href="stylepainel.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../img/logo.png" />
</head>
<body>
    <div class="container">
        <img src="../img/logo.png" alt="Logo" style="display: block; margin: 0 auto; max-width: 150px;">
        <div class="user-info">
                    <form method="post" action="<?= $_SERVER["PHP_SELF"] ?>">
                    <label for="cpf_consulta">Insira o CPF do Usuário:</label>
                    <input type="text" id="cpf_consulta" name="cpf_consulta" required>
                    <input type="submit" value="Consultar">
                </form>
                <div class="consulta-resultado">
                    <?php
                    
                    include('../bancodados/conexao.php');

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $cpf = $_POST['cpf_consulta'];
                        $sql = "SELECT * FROM Usuarios WHERE cpf = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $cpf);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            echo "<table><tr><th>Nome</th><th>E-mail</th><th>CPF</th><th>Bloqueado</th><th>Autorizado</th><th>Ações</th></tr>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr><td>" . $row["nome_completo"] . "</td><td>" . $row["email"] . "</td><td>" . $row["cpf"] . "</td><td>" . ($row["bloqueado"] ? "Sim" : "Não") . "</td>";

                                $acesso_autorizado = isset($row['acesso_autorizado']) ? $row['acesso_autorizado'] : 0;
                                echo "<td>" . ($acesso_autorizado ? "Autorizado" : "Não Autorizado") . "</td>";

                                echo "<td>";
                                if ($row["bloqueado"]) {
                                    echo "<a href='desbloquear_usuario.php?cpf=" . $row['cpf'] . "'>Desbloquear</a>";
                                } else {
                                    echo "<a href='bloquear_usuario.php?cpf=" . $row['cpf'] . "'>Bloquear Acesso</a>";
                                }
                                echo " | ";
                                echo "<a href='excluir_usuario.php?cpf=" . $row['cpf'] . "'>Excluir Usuário</a>";
                                echo " | ";
                                if ($acesso_autorizado) {
                                    echo "<a href='bloquear_acesso_painel.php?cpf=" . $row['cpf'] . "'>Bloquear Acesso ao Painel</a>";
                                } else {
                                    echo "<a href='autorizar_acesso_painel.php?cpf=" . $row['cpf'] . "'>Autorizar Acesso ao Painel</a>";
                                }
                                echo "</td></tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "Nenhum resultado encontrado.";
                        }
                        $stmt->close();
                    }
                    ?>
                </div>
                <div class="user-info">
                    <a href="listar_usuarios.php" class="button">Listar Todos Usuários</a>
                    <a href="../inserircatalogo/mdimg.php" class="button">Add ao Catálogo</a>
                    <a href="../paginaprodutos/cadastro_produto.php" class="button">Add Produtos</a>
                    <a href="../paginacatalogo/exibir.php" class="button">Ver Catálogo</a>
                    <a href="../paginaprodutos/consulta.php" class="button">Consultar Produtos</a>
                    <a href="../paginacadastro/cadastro.php" class="button">Cadastrar Usuário</a>
                </div>

                <?phP
                include('informacoes.php');
                ?>
        </div>
        <div class="dashboard">
            <div>
                <h3>Desempenho</h3>
                <p>Tempo de carregamento: X segundos</p>
                <p>Tráfego Mensal: Y visitantes</p>
            </div>
            <div>
                <h3>Atividade Recente</h3>
                <p>Último login: Nome do usuário - Data/Hora</p>
                <p>Última ação realizada: Descrição da ação</p>
            </div>
        </div>
        <div class="user-info">
            <a href="logoutpainel.php">Sair da Página</a>
        </div>
    </div>

</body>
</html>