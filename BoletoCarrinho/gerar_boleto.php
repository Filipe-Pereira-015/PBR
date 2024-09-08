<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    
// Verifica se o usuário está logado.
if (!isset($_SESSION['usuario_cpf'])) {
    header("Location: ../login/login.php");
    exit();
}

// Verifica se o formulário foi enviado.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome']) && isset($_POST['localEntrega']) && !empty($_POST['nome']) && !empty($_POST['localEntrega'])) {
        // Ambos os campos estão preenchidos, podemos prosseguir.
        $nome = $_POST['nome'];
        $localEntrega = $_POST['localEntrega'];
    } else {
        // Redirecionar se o formulário estiver incompleto.
        header('Location: gerar_boleto.php');
        exit;
    }
}

// Lógica para adicionar produtos ao carrinho.
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produto']) && isset($_POST['preco'])) {
    $produto = $_POST['produto'];
    $preco = $_POST['preco'];

    $_SESSION['carrinho'][] = [
        'nome' => $produto,
        'preco' => $preco,
    ];
}

// Calcula o valor total da compra.
$totalCompra = 0;
if (!empty($_SESSION['carrinho'])) {
    $itensCarrinho = $_SESSION['carrinho'];
    foreach ($itensCarrinho as $produto) {
        $totalCompra += $produto['preco'];
    }
}

if (isset($_POST['encerrar_compra'])) {
    // Limpar o carrinho e redirecionar para exibir.php
    $_SESSION['carrinho'] = [];
    header('Location: ../paginacatalogo/exibir.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V-BR Boleto</title>
    <link rel="stylesheet" href="styleBoleto.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../img/logo.png"/>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="../img/logo.png" alt="V-BR">
        </div>
        <div class="informacoes-instituicao">
            <p>
                Viagens pelo Brasil V-BR<br>
                End:Quadra SQN 314 Bloco C<br>
                Asa Norte, Brasília-DF
            </p>
        </div>
        <?php if (!isset($nome) || !isset($localEntrega)) : ?>
            <p><strong>Preenchimento Obrigatório</strong></p>
            <form method="POST">
                <label for="nome"><strong>Nome do Pagador:</strong></label>
                <input type="text" id="nome" name="nome">
                <label for="localEntrega"><strong>Local de Entrega:</strong></label>
                <input type="text" id="localEntrega" name="localEntrega">
                <br>
                <input type="submit" value="Gerar Boleto">
            </form>
        <?php else : ?>
            <div class="title">
                Boleto <?php echo date('H.is'); ?>
            </div>
            <div class="details">
                <table>
                    <tr>
                        <th>Detalhes Fiscais</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>Nome do Pagador:</td>
                        <td><?php echo $nome; ?></td>
                    </tr>
                    <tr>
                        <td>CNPJ:</td>
                        <td>90.619.355/0001-56</td>
                    </tr>
                    <tr>
                        <td>Data de Emissão:</td>
                        <td><?php echo date('d/m/Y H:i:s'); ?></td>
                    </tr>
                    <tr>
                        <td>Número Fiscal:</td>
                        <td><?php echo date('H.is'); ?></td>
                    </tr>
                    <tr>
                        <td>CFOP:</td>
                        <td>6353 - Prestação de serviço de transporte a estabelecimento comercial</td>
                    </tr>
                </table>
            </div>
            <table class="produtos">
                <tr>
                    <th>Produto</th>
                    <th>Preço</th>
                </tr>
                <?php
                // Exibir os produtos adquiridos.
                if (!empty($_SESSION['carrinho'])) {
                    $itensCarrinho = $_SESSION['carrinho'];
                    foreach ($itensCarrinho as $produto) {
                        echo "<tr>";
                        echo "<td>{$produto['nome']}</td>";
                        echo "<td>R$ {$produto['preco']}</td>";
                        echo "</tr>";
                    }
                }
                ?>
                <tr>
                    <td><strong>Total da Compra</strong></td>
                    <td><strong>R$ <?php echo number_format($totalCompra, 2); ?></strong></td>
                </tr>
            </table>
            <div class="aviso">
                O boleto deve ser pago/quitado em até 72 horas após a aquisição dos produtos aqui listados, em caso de não pagamento o pedido será cancelado!
            </div>
            <div class="informacoes-adicionais">
                <table>
                    <tr>
                        <th>Informações Adicionais</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>Local de Entrega:</td>
                        <td><?php echo $localEntrega; ?></td>
                    </tr>
                    <tr>
                        <td>Data da Compra:</td>
                        <td><?php echo date('d/m/Y'); ?></td>
                    </tr>
                    <tr>
                        <td>Data Estimada de Entrega:</td>
                        <td><?php echo date('d/m/Y', strtotime("+15 weekdays")); ?></td>
                    </tr>
                </table>
            </div>
            <div class="barra">
                <img src="../img/barra.png" alt="Código de Barra">
            </div>
            <div class="imprimir">
                <button onclick="window.print()">Imprimir Boleto</button>
                <div class="imprimir">
                <form action="../paginacatalogo/exibir.php" method="POST" target="_self">
                    <button type="submit" name="encerrar_compra">Encerrar e Fechar</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
    <?php
    require_once('../tcpdf/tcpdf.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['gerar_pdf'])) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    ?>
</body>
</html>