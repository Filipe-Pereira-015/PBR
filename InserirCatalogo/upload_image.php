<?php
$uploadDir = 'uploads/images/';

if (!file_exists($uploadDir) && !mkdir($uploadDir, 0777, true)) {
    die("Erro: Não foi possível criar o diretório de upload.");
}

if ($_FILES['image-file']) {
    $fileName = $_FILES['image-file']['name'];
    $tempName = $_FILES['image-file']['tmp_name'];

    $targetFilePath = $uploadDir . basename($fileName);

    if (move_uploaded_file($tempName, $targetFilePath)) {
        echo "Arquivo enviado com sucesso: " . basename($fileName);
    } else {
        echo "Desculpe, houve um erro ao enviar o arquivo.";
    }
}
?>