<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../bancodados/conexao.php");

// Verifica se a função já foi declarada antes de declará-la
if (!function_exists('calcularSubtotal')) {
    // Função para calcular o subtotal
    function calcularSubtotal() {
        $subtotal = 0;
        foreach ($_SESSION['carrinho'] as $produto) {
            $subtotal += $produto['preco'];
        }
        return $subtotal;
    }
}

// Verifica se a função já foi declarada antes de declará-la
if (!function_exists('calcularTotalFinal')) {
    // Função para calcular o total final com descontos e transporte
    function calcularTotalFinal($subtotal, $cupomDesconto, $tipoTransporte) {
        // Verifica se o valor do cupom de desconto é válido e calcula o desconto em porcentagem
        if (is_numeric($cupomDesconto) && $cupomDesconto >= 0 && $cupomDesconto <= 100) {
            $desconto = ($cupomDesconto / 100) * $subtotal;
        } else {
            $desconto = 0;
        }

        return $subtotal - $desconto + $tipoTransporte;
    }
}

// Atualiza o subtotal com base nos cálculos realizados
function atualizarSubtotal() {
    $subtotal = calcularSubtotal();
    $_SESSION['subtotal'] = $subtotal;
}

// Atualiza o subtotal ao finalizar o pedido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['forma_pagamento'])) {
    $formaPagamento = $_POST['forma_pagamento'];
    $cupomDesconto = isset($_POST['cupom_desconto']) ? $_POST['cupom_desconto'] : 0;
    $tipoTransporte = isset($_POST['tipo_transporte']) ? $_POST['tipo_transporte'] : 0;

    $subtotal = calcularSubtotal();
    $_SESSION['desconto'] = calcularDesconto($subtotal, $cupomDesconto);
    $totalFinal = calcularTotalFinal($subtotal, $cupomDesconto, $tipoTransporte);

    $_SESSION['subtotal'] = $totalFinal; // Atualiza o subtotal

    header("Location: pedidos.php");
    exit;
}

// Verifica se a função já foi declarada antes de declará-la
if (!function_exists('calcularDesconto')) {
    // Função para calcular o desconto em porcentagem
    function calcularDesconto($subtotal, $cupomDesconto) {
        if (is_numeric($cupomDesconto) && $cupomDesconto >= 0 && $cupomDesconto <= 100) {
            return ($cupomDesconto / 100) * $subtotal;
        } else {
            return 0;
        }
    }
}
?>
