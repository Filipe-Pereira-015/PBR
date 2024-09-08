<?php
session_start();

include('../bancodados/conexao.php');

if (!isset($_SESSION['usuario_cpf'])) {
    header("Location: ../login/loginpainel.php");
    exit();
}

?>

<?php

include('../bancodados/conexao.php'); 

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['imagem'])) {
        $diretorio_destino_exibir = '../paginacatalogo/imagens/'; // Diretório da página exibir.php

        if (!is_dir($diretorio_destino_exibir)) {
            mkdir($diretorio_destino_exibir, 0777, true);
        }

        $imagem = $_FILES['imagem'];
        $titulo = $_POST['titulo'];
        $subtitulo = $_POST['subtitulo'];

        // Renomeia a imagem com o título fornecido.
        $nome_arquivo = $titulo . '_' . basename($imagem['name']);
        $caminho_imagem_exibir = $diretorio_destino_exibir . $nome_arquivo;

        if (move_uploaded_file($imagem['tmp_name'], $caminho_imagem_exibir)) {
            // Inserir no banco de dados.
            $query = $conn->prepare("INSERT INTO Produtos (nome, imagem_path, titulo, subtitulo) VALUES (?, ?, ?, ?)");
            $query->bind_param("ssss", $nome_arquivo, $caminho_imagem_exibir, $titulo, $subtitulo);

            if ($query->execute()) {
                // Produto inserido com sucesso, agora redireciona para a página de exibição.
                header("Location: ../paginacatalogo/exibir.php");
                exit();
            } else {
                echo "Erro: " . $query->error;
            }

            $query->close();
        } else {
            echo "Erro no Upload da Imagem.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V-BR Inserir ao Catálogo</title>
    <link rel="stylesheet" href="styleInserir.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../img/logo.png"/>
</head>
<body>
    <div class="header">
        <img src="../img/logo.png" alt="Logo">
        <h1>V-BR Inserir ao Catálogo</h1>
    </div>

    <div class="content">
        <div class="form-container">
            <form action="../paginacatalogo/exibir.php" method="post" enctype="multipart/form-data">
                <img id="imgPreview" src="#" alt="Preview da Imagem" style="max-width:100%; display:none;">
                <input type="file" name="imagem" accept="image/*" onchange="previewImage(event)">
                <input type="text" name="titulo" placeholder="Título">
                <input type="text" name="subtitulo" placeholder="Subtítulo">
                <input type="submit" value="Enviar">
                <a href="../paginacatalogo/exibir.php" class="redirect-button" style="background-color: #5f5; color: #fff;">Exibir</a>
            </form>

            <div class="search-form">
                <form action="" method="post">
                    <input type="text" name="search_title" placeholder="Pesquisar por título">
                    <input type="submit" value="Pesquisar" style="background-color: #e74c3c; color: #fff;">
                </form>
            </div>
        </div>

        <div class="search-results">
            <?php
            include_once('../bancodados/conexao.php');

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_title'])) {
                $searchTitle = $_POST['search_title'];
                $sql = "SELECT produto_id, imagem_path, titulo, subtitulo FROM Produtos WHERE titulo = '$searchTitle'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo '<table>';
                    echo '<tr><th>Imagem</th><th>Título</th><th>Subtítulo</th><th>Ações</th></tr>';
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td><img src="' . $row["imagem_path"] . '" alt="' . $row["titulo"] . '" style="max-width:100px;"></td>';
                        echo '<td>' . $row["titulo"] . '</td>';
                        echo '<td>' . $row["subtitulo"] . '</td>';
                        echo '<td class="product-form-column">';
                        echo '<div class="product-form">';
                        echo '<form class="edit-form" action="editar_titulo.php?id=' . $row["produto_id"] . '" method="post">';
                        echo '<input type="text" name="novo_titulo" placeholder="Novo Título">';
                        echo '<input type="submit" value="Salvar Título" style="background-color: #3498db; color: #fff;">';
                        echo '</form>';
                        echo '<form class="edit-form" action="editar_subtitulo.php?id=' . $row["produto_id"] . '" method="post">';
                        echo '<input type="text" name="novo_subtitulo" placeholder="Novo Subtítulo">';
                        echo '<input type="submit" value="Salvar Subtítulo" style="background-color: #FFD700; color: #000;">';
                        echo '</form>';
                        echo '<form class="edit-form" action="alterar_imagem.php?id=' . $row["produto_id"] . '" method="post" enctype="multipart/form-data">';
                        echo '<input type="file" name="nova_imagem" accept="image/*">';
                        echo '<input type="submit" value="Alterar Imagem" style="background-color: #e74c3c; color: #fff;">';
                        echo '</form>';
                        echo '<a href="excluir.php?id=' . $row["produto_id"] . '" style="background-color: #000; color: #fff;">Excluir</a>';
                        echo '</div>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                } else {
                    echo '<p>Nenhuma imagem encontrada com esse título.</p>';
                }
            }

            $conn->close();
            ?>
        </div>
    </div>
    <script>
        function previewImage(event) {
            var img = document.getElementById('imgPreview');
            img.style.display = 'block';
            img.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
</body>
</html>