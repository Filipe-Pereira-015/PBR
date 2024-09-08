<?php
include('../bancodados/conexao.php');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['nova_imagem']) && isset($_GET['id'])) {
    $produto_id = $_GET['id'];
    $imagem_nova = $_FILES['nova_imagem'];

    $diretorio_destino = '../paginacatalogo/imagens/';

    // Verifica se o diretório de destino existe, senão, cria o diretório.
    if (!file_exists($diretorio_destino) && !is_dir($diretorio_destino)) {
        mkdir($diretorio_destino, 0777, true);
    }

    if (!is_writable($diretorio_destino)) {
        chmod($diretorio_destino, 0777);
    }

    if ($imagem_nova['error'] === UPLOAD_ERR_OK) {
        $tipo_imagem = exif_imagetype($imagem_nova['tmp_name']);
        $tipos_permitidos = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF];

        if (in_array($tipo_imagem, $tipos_permitidos)) {
            $extensao = pathinfo($imagem_nova['name'], PATHINFO_EXTENSION);
            $novo_nome = 'nova_imagem_' . $produto_id . '.' . $extensao;
            $caminho_completo = $diretorio_destino . $novo_nome;

            if (move_uploaded_file($imagem_nova['tmp_name'], $caminho_completo)) {

                $query = $conn->prepare("UPDATE Produtos SET imagem_path = ? WHERE produto_id = ?");
                $query->bind_param("si", $caminho_completo, $produto_id);

                if ($query->execute()) {
                    echo "Imagem Atualizada com Sucesso.";
                } else {
                    echo "Erro ao Atualizar a Imagem: " . $query->error;
                }

                $query->close();
                header("Location: MDIMG.php");
                exit;
            } else {
                echo "Erro ao Mover o Arquivo para o Diretório de Destino.";
            }
        } else {
            echo "Tipo de Arquivo Inválido. Por favor, Carregue uma Imagem.";
        }
    } else {
        echo "Ocorreu um Erro no Upload do Arquivo. Código do erro: " . $imagem_nova['error'];
    }
}

$conn->close();
?>