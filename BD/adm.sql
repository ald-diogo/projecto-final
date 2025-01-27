CREATE TABLE administradores (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único para cada administrador
    email VARCHAR(255) NOT NULL UNIQUE, -- Email do administrador (único)
    senha VARCHAR(255) NOT NULL, -- Senha do administrador
    nome VARCHAR(255) NOT NULL, -- Nome do administrador (opcional, para facilitar identificação)
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Data de criação
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- Data da última atualização
);
INSERT INTO administradores (email, senha, nome) 
VALUES ('bibliotecaacj@bib.com', 'acj2025', 'Aristóteles pedro');
