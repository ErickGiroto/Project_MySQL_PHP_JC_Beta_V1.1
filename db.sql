------------------------------------Criação do Banco------------------------------
CREATE DATABASE quitanda_bom_preco;

------------------------------------Usuários--------------------------------------
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    pergunta1 VARCHAR(255) NOT NULL,
    resposta1 VARCHAR(255) NOT NULL,
    pergunta2 VARCHAR(255) NOT NULL,
    resposta2 VARCHAR(255) NOT NULL,
    pergunta3 VARCHAR(255) NOT NULL,
    resposta3 VARCHAR(255) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE usuarios ADD tipo_usuario ENUM('admin', 'funcionario') NOT NULL DEFAULT 'funcionario';
ALTER TABLE usuarios MODIFY COLUMN tipo_usuario ENUM('admin', 'funcionario', 'gerencia', 'estoque', 'rh', 'comercial') NOT NULL DEFAULT 'funcionario';

------------------------------------Produtos Tipo--------------------------------
CREATE TABLE produto_tipo (
    cod VARCHAR(50) PRIMARY KEY, 
    produto VARCHAR(255) NOT NULL, 
    tipo VARCHAR(100) NOT NULL,
    tipo_alimento VARCHAR(100) NOT NULL
);

------------------------------------Produtos Estoque ----------------------------
CREATE TABLE produto_quantidade (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Alterei para ter um ID único
    cod VARCHAR(50), 
    produto VARCHAR(255) NOT NULL, 
    tipo VARCHAR(100) NOT NULL,
    tipo_alimento VARCHAR(100) NOT NULL,
    qtd INT NOT NULL, 
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    usuario_registro VARCHAR(255) NOT NULL, 
    FOREIGN KEY (usuario_registro) REFERENCES usuarios(email),
    nome_usuario VARCHAR(255) NOT NULL
);
------------------------------------Empresa-------------------------------------
CREATE TABLE empresas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    razao_social VARCHAR(255) NOT NULL,
    cnpj VARCHAR(18) NOT NULL UNIQUE,
    endereco VARCHAR(255) NOT NULL,
    bairro VARCHAR(100) NOT NULL,
    municipio VARCHAR(100) NOT NULL,
    estado VARCHAR(2) NOT NULL,
    cep VARCHAR(9) NOT NULL,
    pais VARCHAR(100) NOT NULL,
    numero VARCHAR(10) NOT NULL,
    observacao TEXT,
    usuario_registro VARCHAR(255) NOT NULL, -- Email do usuário que fez o cadastro
    nome_usuario VARCHAR(255) NOT NULL, -- Nome do usuário que fez o cadastro
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

------------------------------------Cliente Empresa--------------------------------
CREATE TABLE empresa_cliente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    razao_social VARCHAR(255) NOT NULL,
    cnpj VARCHAR(18) NOT NULL,
    nome VARCHAR(255) NOT NULL,
    telefone1 VARCHAR(20) NOT NULL,
    telefone2 VARCHAR(20),
    email VARCHAR(255) NOT NULL,
    departamento VARCHAR(100) NOT NULL,
    observacao TEXT,
    usuario_registro VARCHAR(255) NOT NULL,
    nome_usuario VARCHAR(255) NOT NULL,
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


------------------------------------Pedido Comercial(Primaria)--------------------------------

CREATE TABLE pedidos_comercial (
    id INT AUTO_INCREMENT PRIMARY KEY,
    razao_social VARCHAR(255) NOT NULL,
    cnpj VARCHAR(18) NOT NULL,
    cod VARCHAR(50) NOT NULL,
    produto VARCHAR(255) NOT NULL,
    tipo VARCHAR(100) NOT NULL,
    tipo_alimento VARCHAR(100) NOT NULL,
    qtd INT NOT NULL,
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    usuario_registro VARCHAR(255) NOT NULL,
    nome_usuario VARCHAR(255) NOT NULL,
    FOREIGN KEY (usuario_registro) REFERENCES usuarios(email)
);

ALTER TABLE pedidos_comercial ADD COLUMN num_pedido VARCHAR(50) NOT NULL;
ALTER TABLE pedidos_comercial ADD COLUMN status VARCHAR(20) NOT NULL DEFAULT 'Não Iniciado';
ALTER TABLE pedidos_comercial ADD COLUMN valor_unitario DECIMAL(10, 2) NOT NULL;
ALTER TABLE pedidos_comercial ADD COLUMN valor_total DECIMAL(10, 2) NOT NULL;
ALTER TABLE pedidos_comercial ADD COLUMN data_de_entrega DATE;

------------------------------------Funcionário Registro--------------------------------

CREATE TABLE funcionario_registro (
    id INT AUTO_INCREMENT PRIMARY KEY, -- ID único para a tabela
    cod VARCHAR(50) UNIQUE NOT NULL, -- Código do funcionário
    nome_completo VARCHAR(255) NOT NULL, -- Nome completo obrigatório
    nome_social VARCHAR(255), -- Nome social (opcional)
    nome_pai VARCHAR(255), -- Nome do pai (opcional)
    nome_mae VARCHAR(255), -- Nome da mãe (opcional)
    pronome VARCHAR(50), -- Pronome (opcional)
    sexo VARCHAR(50), -- Sexo (opcional)
    data_de_nascimento DATE NOT NULL, -- Data de nascimento obrigatória
    estado_civil VARCHAR(50) NOT NULL, -- Estado civil obrigatório
    cpf VARCHAR(14) NOT NULL UNIQUE, -- CPF único e obrigatório
    rg VARCHAR(20) NOT NULL, -- RG obrigatório
    cnh VARCHAR(20) NOT NULL, -- CNH obrigatória
    telefone_1 VARCHAR(20) NOT NULL, -- Telefone principal obrigatório
    telefone_emergencia VARCHAR(20) NOT NULL, -- Telefone de emergência obrigatório
    email VARCHAR(255) NOT NULL UNIQUE, -- E-mail único e obrigatório
    naturalidade VARCHAR(100) NOT NULL, -- Naturalidade obrigatória
    nacionalidade VARCHAR(100) NOT NULL, -- Nacionalidade obrigatória
    endereco VARCHAR(255) NOT NULL, -- Endereço obrigatório
    bairro VARCHAR(100) NOT NULL, -- Bairro obrigatório
    cep VARCHAR(10) NOT NULL, -- CEP obrigatório
    estado VARCHAR(50) NOT NULL, -- Estado obrigatório
    num_casa VARCHAR(10), -- Número da casa (opcional)
    filho1 VARCHAR(255), -- Data de nascimento do filho 1 (opcional)
    data_nascimento_filho1 DATE,
    filho2 VARCHAR(255),
    data_nascimento_filho2 DATE,
    filho3 VARCHAR(255),
    data_nascimento_filho3 DATE,
    filho4 VARCHAR(255),
    data_nascimento_filho4 DATE,
    filho5 VARCHAR(255),
    data_nascimento_filho5 DATE,
    filho6 VARCHAR(255),
    data_nascimento_filho6 DATE,
    filho7 VARCHAR(255),
    data_nascimento_filho7 DATE,
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Data de registro automática
    usuario_registro VARCHAR(255) NOT NULL, -- Usuário que cadastrou
    nome_usuario VARCHAR(255) NOT NULL, -- Nome do usuário que cadastrou
    FOREIGN KEY (usuario_registro) REFERENCES usuarios(email) -- Relacionado à tabela de usuários
);


------------------------------------Funcionário Imagem--------------------------------
CREATE TABLE funcionario_imagens (
    id INT AUTO_INCREMENT PRIMARY KEY, -- ID único para a tabela
    cod VARCHAR(50) NOT NULL, -- Código do funcionário (referenciado à tabela funcionario_registro)
    imagem LONGBLOB NOT NULL, -- Imagem em formato binário
    usuario_registro VARCHAR(255) NOT NULL, -- Usuário que registrou a imagem
    nome_usuario VARCHAR(255) NOT NULL, -- Nome do usuário que registrou a imagem
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Data de registro automática
    FOREIGN KEY (cod) REFERENCES funcionario_registro(cod) -- Chave estrangeira para funcionario_registro
);

------------------------------------PDF
https://getcomposer.org/download/
>Install dentro da pasta PHP
    >composer --version
        >Caso nao encontre, tem que adicionar no PATH Ambientes de Variavéis


> git bash dentro da pasta do projeto
    >composer require tecnickcom/tcpdf
    >composer require setasign/fpdf

    >baixar e extrair arquivos
        >Acesse o repositório oficial do TCPDF no GitHub: https://github.com/tecnickcom/TCPDF.
