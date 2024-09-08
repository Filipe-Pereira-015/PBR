-- DELETANDO O BD
DROP DATABASE sistema_gerenciamentoVBR;

-- CRIANDO O BD
CREATE DATABASE sistema_gerenciamentoVBR;
USE sistema_gerenciamentoVBR;

-- TABELA PRODUTOS
CREATE TABLE Produtos (
    produto_id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(80) NOT NULL,
    descricao TEXT NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    categoria_id INT NOT NULL,
    imagem_path VARCHAR(255), -- Caminho para a imagem
    titulo VARCHAR(255), -- Título da imagem
    subtitulo VARCHAR(255) -- Subtítulo da imagem
);

-- TABELA DE USUÁRIO
CREATE TABLE Usuarios (
    usuario_id INT PRIMARY KEY AUTO_INCREMENT,
    nome_completo VARCHAR(80) NOT NULL,
    email VARCHAR(80) NOT NULL,
    cpf VARCHAR(11) NOT NULL,
    senha VARCHAR(10) NOT NULL CHECK (LENGTH(senha) BETWEEN 8 AND 10),
    bloqueado BOOLEAN NOT NULL DEFAULT FALSE,
    acesso_autorizado BOOLEAN NOT NULL DEFAULT FALSE
);

-- TABELA DE PEDIDOS
CREATE TABLE Pedidos (
    pedido_id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    data_pedido DATE NOT NULL,
    valor_total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(usuario_id)
);

-- TABELA DE ITENS_PEDIDOS
CREATE TABLE Itens_Pedido (
    item_id INT PRIMARY KEY AUTO_INCREMENT,
    pedido_id INT,
    produto_id INT,
    quantidade INT NOT NULL,
    valor_unitario DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES Pedidos(pedido_id),
    FOREIGN KEY (produto_id) REFERENCES Produtos(produto_id)
);

-- Tabela de Boletos
CREATE TABLE Boletos (
    boleto_id INT PRIMARY KEY AUTO_INCREMENT,
    numero_fiscal VARCHAR(50) NOT NULL,
    data_geracao DATE NOT NULL,
    conteudo_pdf BLOB NOT NULL
);

INSERT INTO Usuarios (nome_completo, email, cpf, senha, acesso_autorizado) VALUES
('Adm', 'adm@gmail.com', '012345678910', '123456789', TRUE), -- Administrador
('Filipe Pereira', 'filipemarreira5@gmail.com', '08510756147', '123456789', TRUE), -- Administrador
('Cliente1', 'c1@gmail.com', '11111111111111', '123456789', FALSE), -- Usuário normal
('Cliente2', 'c2@gmail.com', '22222222222222', '123456789', FALSE), -- Usuário normal
('Cliente3', 'c3@gmail.com', '33333333333333', '123456789', FALSE), -- Usuário normal
('Cliente4', 'c4@gmail.com', '44444444444444', '123456789', FALSE), -- Usuário normal
('Cliente5', 'c5@gmail.com', '55555555555555', '123456789', FALSE); -- Usuário normal


INSERT INTO Produtos (nome, descricao, preco, categoria_id, imagem_path, titulo, subtitulo) VALUES
('Pacote para Bahia', 'Descrição do pacote para Bahia.', 1200.00, 1, 'bahia.jpg', 'Bahia', 'Pacote de Viagem'),
('Pacote para Brasília', 'Descrição do pacote para Brasília.', 1400.00, 2, 'brasilia.jpg', 'Brasília', 'Pacote de Viagem'),
('Pacote para Rio Grande do Norte', 'Descrição do pacote para o Rio Grande do Norte.', 1800.00, 3, 'natureza.jpg', 'Rio Grande do Norte', 'Pacote de Viagem'),
('Pacote para Ilha Bela', 'Descrição do pacote para Iha Bela.', 1600.00, 4, 'ilhabela.jpeg', 'Ilha Bela', 'Pacote de Viagem'),
('Pacote para Porto Seguro', 'Descrição do pacote para Porto Seguro.', 1800.00, 5, 'portoseguro.jpg', 'Porto Seguro', 'Pacote de Viagem'),
('Pacote para Recife', 'Descrição do pacote para Recife.', 100000.00, 6, 'recife.jpeg', 'Recife', 'Pacote de Viagem'),
('Pacote para Rio de Janeiro', 'Descrição do pacote para o Rio de Janeiro.', 140000.00, '7', 'riodejaneiro.jpg', 'Rio de Janeiro', 'Pacote de Viagem'),
('Pacote para São Paulo', 'Descrição do pacote para São Paulo.', 16000.00, 1, 'saopaulo.jpg', 'São Paulo', 'Pacote de Viagem');
