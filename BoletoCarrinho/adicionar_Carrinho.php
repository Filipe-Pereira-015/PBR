<?php
session_start();

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = array();
}

include_once('../bancodados/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $produto_id = $_GET['id'];
    $sql = "SELECT * FROM Produtos WHERE produto_id = $produto_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $produto = $result->fetch_assoc();
        $_SESSION['carrinho'][] = $produto;
    } else {
        echo "Produto não Encontrado.";
    }
}

if (isset($_GET['return_url']) && !empty($_GET['return_url'])) {
    header("Location: " . $_GET['return_url']);
    exit();
}

$conn->close();
?>