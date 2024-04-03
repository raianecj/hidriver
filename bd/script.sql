-- Criação do banco de dados (opcional se já existir)
CREATE DATABASE IF NOT EXISTS hidriver;

-- Seleciona o banco de dados a ser usado
USE hidriver;

-- Criação da tabela
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(255),
    senha VARCHAR(100)
);

-- Inserção de dados na tabela
INSERT INTO usuarios (nome, email, senha) VALUES ('João', 'joao@example.com', '123456');
INSERT INTO usuarios (nome, email, senha) VALUES ('Maria', 'maria@example.com', '123456');
INSERT INTO usuarios (nome, email, senha) VALUES ('Pedro', 'pedro@example.com', '123456');

-- Consulta dos dados da tabela
SELECT * FROM NomeDaTabela;
