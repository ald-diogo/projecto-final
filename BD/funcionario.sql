CREATE TABLE funcionarios (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único para cada funcionário
    nome VARCHAR(100) NOT NULL,        -- Nome do funcionário
    login VARCHAR(50) NOT NULL UNIQUE, -- Login único para autenticação
    senha VARCHAR(255) NOT NULL,      -- Senha criptografada
    data_nascimento DATE NOT NULL,    -- Data de nascimento
    telefone VARCHAR(15) NOT NULL,    -- Telefone do funcionário
    morada VARCHAR(255) NOT NULL,     -- Endereço do funcionário
    identidade VARCHAR(50) NOT NULL,  -- Número de identidade
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Data de criação do registro
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- Última atualização
);
