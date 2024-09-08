<?php
include('../bancodados/conexao.php');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Função para atualizar o produto.
function atualizarProduto($titulo, $subtitulo, $imagem, $caminho_imagem, $produto_id, $conn) {
    $verifica_produto = $conn->prepare("SELECT produto_id, nome, imagem_path, titulo, subtitulo FROM Produtos WHERE nome = ?");
    $verifica_produto->bind_param("s", $titulo);
    $verifica_produto->execute();
    $verifica_produto->store_result();

    if ($verifica_produto->num_rows > 0) {
        $verifica_produto->bind_result($produto_id, $nome, $imagem_antiga, $titulo_antigo, $subtitulo_antigo);
        $verifica_produto->fetch();

        $alteracoes = array();

        if ($titulo !== $titulo_antigo) {
            $alteracoes['titulo'] = $titulo;
        }

        if ($subtitulo !== $subtitulo_antigo) {
            $alteracoes['subtitulo'] = $subtitulo;
        }

        if (!empty($alteracoes)) {
            $query = $conn->prepare("UPDATE Produtos SET titulo = ?, subtitulo = ?, imagem_path = ?, data_modificacao = NOW() WHERE produto_id = ?");
            $query->bind_param("sssi", $titulo, $subtitulo, $caminho_imagem, $produto_id);
            $query->execute();

            echo "Produto Atualizado com Sucesso!";
            echo "Alterações: " . implode(", ", $alteracoes);
        } else {
            echo "Produto já existe, mas nenhuma alteração detectada.";
        }

        $verifica_produto->close();
        $query->close();
    } else {
        $query = $conn->prepare("INSERT INTO Produtos (nome, imagem_path, titulo, subtitulo, data_modificacao) VALUES (?, ?, ?, ?, NOW())");
        $query->bind_param("ssss", $titulo, $caminho_imagem, $titulo, $subtitulo);

        if ($query->execute()) {
            echo "Novo Produto Inserido com Sucesso!";
        } else {
            echo "Erro: " . $query->error;
        }

        $query->close();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['imagem'])) {
        $diretorio_destino = 'imagens/';

        if (!is_dir($diretorio_destino)) {
            mkdir($diretorio_destino, 0777, true);
        }

        $imagem = $_FILES['imagem'];
        $titulo = $_POST['titulo'];
        $subtitulo = $_POST['subtitulo'];
        $caminho_imagem = $diretorio_destino . basename($imagem['name']);

        if (move_uploaded_file($imagem['tmp_name'], $caminho_imagem)) {
            // evitar cache da imagem.
            $timestamp = time();
            $caminho_imagem = $caminho_imagem . "?t=" . $timestamp;

            // Chama a função para atualizar o produto.
            atualizarProduto($titulo, $subtitulo, $imagem, $caminho_imagem, $produto_id, $conn);
        } else {
            echo "Erro no Upload da Imagem.";
        }
    }
}

$conn->close();
?>