<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Viagens V-BR</title>
    <link rel="stylesheet" href="styleCatalogo.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../img/logo.png"/>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <div class="logo">
                <img src="../img/logo.png" alt="Logo">
            </div>
            <h1>Catálogo Viagens V-BR</h1>
        </div>

        <ul class="social-icons">
            <li>
                <a href="https://outlook.live.com/owa/" target="_self">
                    <img class="icon" alt="E-mail" src="../img/gmailpng.png">
                </a>
                <a href="https://web.whatsapp.com/" target="self">
                    <img class="icon" alt="WhatsApp" src="../img/WhatsApp.png">
                </a>
                <a href="https://www.instagram.com/" target="self">
                    <img class="icon" alt="Instagram" src="../img/instagram.png">
                </a>
                <a href="https://www.facebook.com/" target="_self">
                    <img class="icon" alt="Facebook" src="../img/facebook.png">
                </a>
            </li>
            <li>
                <a href="../boletocarrinho/pedidos.php" target="_self">
                    <img class="icon" alt="Carrinho" src="../img/carrinho.png">
                </a>
                <a href="logoutExibir.php" target="_self">
                    <img class="icon" alt="Sair" src="../img/sair.png">
                </a>
                <a href="../index.html" target="_self">
                    <img class="icon" alt="Página Inicial" src="../img/casa.png">
                </a>   
            </li>
        </ul>
        <div class="navigation-buttons">
    <button onclick="scrollToTop()">Topo</button>
    <button onclick="scrollToMiddle()">Meio</button>
    <button onclick="scrollToBottom()">Final</button>
</div>

        <div class="card-container">
            <?php
            include('../bancodados/conexao.php'); 

            if ($conn->connect_error) {
                die("Conexão falhou: " . $conn->connect_error);
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
                        
                        $query = $conn->prepare("INSERT INTO Produtos (nome, imagem_path, titulo, subtitulo) VALUES (?, ?, ?, ?)");
                        $query->bind_param("ssss", $titulo, $caminho_imagem, $titulo, $subtitulo);

                        if ($query->execute()) {
                            echo "Produto Inserido com Sucesso!";
                        } else {
                            echo "Erro: " . $query->error;
                        }

                        $query->close();
                    } else {
                        echo "Erro no Upload da Imagem.";
                    }
                }
            }

            $sql = "SELECT produto_id, nome, imagem_path, titulo, subtitulo FROM Produtos WHERE imagem_path IS NOT NULL";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card">';
                    echo '<img src="' . $row["imagem_path"] . '" alt="' . $row["nome"] . '">';
                    echo '<div class="card-content">';
                    echo '<h3>' . $row["titulo"] . '</h3>';
                    echo '<p>' . $row["subtitulo"] . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "Nenhum Produto Encontrado.";
            }

            $conn->close();
            ?>
        </div>
    </div>
    
    <script>
        function openImage(imagePath) {
            window.open(imagePath, '_self');
        }
    </script>
    <script>
    function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function scrollToMiddle() {
    const middle = document.body.scrollHeight / 2;
    window.scrollTo({ top: middle, behavior: 'smooth' });
}

function scrollToBottom() {
    const bottom = document.body.scrollHeight;
    window.scrollTo({ top: bottom, behavior: 'smooth' });
}

</script>
<script>

document.querySelectorAll('.card img').forEach(img => {
    img.addEventListener('click', () => {
        img.classList.toggle('fullscreen');
    });
});

<?php
include_once('../bancodados/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_title'])) {
    $searchTitle = $_POST['search_title'];
    $sql = "SELECT produto_id, imagem_path, titulo, subtitulo FROM Produtos WHERE titulo = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $searchTitle);
    $stmt->execute();
    
    $result = $stmt->get_result();

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

    $stmt->close();
}

$conn->close();
?>

</script>
</body>
</html>