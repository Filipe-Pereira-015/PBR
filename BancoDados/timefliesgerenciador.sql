-- Conexão com o servidor MySQL
DROP DATABASE IF EXISTS timefliesgerenciador;
CREATE DATABASE IF NOT EXISTS timefliesgerenciador;
USE timefliesgerenciador;

-- Tabela de Usuarios
CREATE TABLE IF NOT EXISTS Usuarios (
    usuario_id INT PRIMARY KEY AUTO_INCREMENT,
    nome_completo VARCHAR(80) NOT NULL,
    email VARCHAR(80) NOT NULL,
    cpf VARCHAR(11) NOT NULL,
    senha VARCHAR(10) NOT NULL CHECK (LENGTH(senha) BETWEEN 8 AND 10),
    bloqueado BOOLEAN NOT NULL DEFAULT FALSE,
    acesso_autorizado BOOLEAN NOT NULL DEFAULT FALSE
);



INSERT INTO Usuarios (nome_completo, email, cpf, senha, acesso_autorizado) VALUES
('Filipe Pereira', 'filipemarreira5@gmail.com', '08510756147', '123456789', TRUE), -- Administrador
('Usuário 1', 'usuario1@email.com', '23456789012', 'senha456', FALSE); -- Usuário normal