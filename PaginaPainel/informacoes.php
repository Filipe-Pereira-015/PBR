<!-- CONSULTA INFORMAÇÃOES E EXIBE NO PAINEL ACIMA DO DASHBOARD -->

<?php
// Incluir o arquivo de conexão
include('../bancodados/conexao.php');

// Consultar a quantidade de usuários cadastrados.
$sqlUsuarios = "SELECT COUNT(*) as totalUsuarios FROM Usuarios";
$resultUsuarios = $conn->query($sqlUsuarios);
$rowUsuarios = $resultUsuarios->fetch_assoc();
$totalUsuarios = $rowUsuarios['totalUsuarios'];

// Consultar o valor total de todos os produtos cadastrados.
$sqlProdutos = "SELECT SUM(preco) as valorTotalProdutos FROM Produtos";
$resultProdutos = $conn->query($sqlProdutos);
$rowProdutos = $resultProdutos->fetch_assoc();
$valorTotalProdutos = $rowProdutos['valorTotalProdutos'];

// Consultar a quantidade de usuários bloqueados.
$sqlUsuariosBloqueados = "SELECT COUNT(*) as totalUsuariosBloqueados FROM Usuarios WHERE bloqueado = 1";
$resultUsuariosBloqueados = $conn->query($sqlUsuariosBloqueados);
$rowUsuariosBloqueados = $resultUsuariosBloqueados->fetch_assoc();
$totalUsuariosBloqueados = $rowUsuariosBloqueados['totalUsuariosBloqueados'];

// Consultar a quantidade de usuários com acesso autorizado.
$sqlUsuariosAutorizados = "SELECT COUNT(*) as totalUsuariosAutorizados FROM Usuarios WHERE acesso_autorizado = 1";
$resultUsuariosAutorizados = $conn->query($sqlUsuariosAutorizados);
$rowUsuariosAutorizados = $resultUsuariosAutorizados->fetch_assoc();
$totalUsuariosAutorizados = $rowUsuariosAutorizados['totalUsuariosAutorizados'];

$conn->close();
?>

<table class="user-info">
    <tr>
        <td><strong>Total de Usuários:</strong></td>
        <td><?php echo $totalUsuarios; ?></td>
    </tr>
    <tr>
        <td><strong>Valor Total dos Produtos:</strong></td>
        <td>R$ <?php echo number_format($valorTotalProdutos, 2, ',', '.'); ?></td>
    </tr>
    <tr>
        <td><strong>Usuários Bloqueados:</strong></td>
        <td><?php echo $totalUsuariosBloqueados; ?></td>
    </tr>
    <tr>
        <td><strong>Usuários com Acesso Autorizado:</strong></td>
        <td><?php echo $totalUsuariosAutorizados; ?></td>
    </tr>
</table>