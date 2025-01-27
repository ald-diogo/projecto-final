-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS biblioteca;

-- Usar o banco de dados
USE biblioteca;

-- Criar tabela de usuários
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefone VARCHAR(15) NOT NULL,
    status ENUM('ativo', 'inativo') DEFAULT 'ativo',
    data_cadastro DATE NOT NULL,
    senha VARCHAR(255) NOT NULL
);

-- Exemplo de tabela para funcionários (caso necessário)
CREATE TABLE funcionarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefone VARCHAR(15),
    cargo VARCHAR(50),
    senha VARCHAR(255) NOT NULL
);

-- Exemplo de tabela para livros (caso necessário)
CREATE TABLE livros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    autor VARCHAR(100) NOT NULL,
    genero VARCHAR(50),
    status ENUM('disponível', 'emprestado') DEFAULT 'disponível',
    data_cadastro DATE NOT NULL
);

-- Exemplo de tabela para empréstimos (caso necessário)
CREATE TABLE emprestimos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    livro_id INT NOT NULL,
    data_emprestimo DATE NOT NULL,
    data_devolucao DATE,
    status ENUM('ativo', 'finalizado') DEFAULT 'ativo',
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (livro_id) REFERENCES livros(id)
);
