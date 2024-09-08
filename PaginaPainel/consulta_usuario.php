<!--- CONSULTAR USUÁRIOS, PAINEL.PHP -->
<?php
include('../bancodados/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cpf_consulta'])) {
    $cpf = $_POST['cpf_consulta'];
    $sql = "SELECT * FROM Usuarios WHERE cpf = '$cpf'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table><tr><th>Nome</th><th>E-mail</th><th>CPF</th><th>Bloqueado</th><th>Autorizado</th><th>Ações</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["nome_completo"] . "</td><td>" . $row["email"] . "</td><td>" . $row["cpf"] . "</td><td>" . ($row["bloqueado"] ? "Sim" : "Não") . "</td>";

            // ACESSO AUTORIZADO.
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
}
$conn->close();
?>