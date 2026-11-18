-- ============================================================
--  SISTEMA DE GESTÃO PRISIONAL - SCRIPT DO BANCO DE DADOS
--  Disciplina: ARA2739 - Desenvolvimento Web (2026.2)
--  Banco: MySQL / MariaDB (XAMPP)
--
--  Como usar: abra o phpMyAdmin > aba "Importar" > escolha este
--  arquivo > "Executar". Ele cria o banco, as tabelas e alguns
--  dados de exemplo.
-- ============================================================

-- Cria o banco (se ainda não existir) com suporte a acentos
CREATE DATABASE IF NOT EXISTS sistema_prisional
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE sistema_prisional;

-- Apaga as tabelas antigas para o script poder ser executado de novo.
-- A ordem importa: primeiro a tabela que TEM chave estrangeira (presos),
-- depois as tabelas que ela referencia.
DROP TABLE IF EXISTS presos;
DROP TABLE IF EXISTS celas;
DROP TABLE IF EXISTS usuarios;

-- ------------------------------------------------------------
-- Tabela: usuarios
-- Quem pode fazer login no sistema (administradores e agentes).
-- ------------------------------------------------------------
CREATE TABLE usuarios (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nome       VARCHAR(100) NOT NULL,
    email      VARCHAR(100) NOT NULL UNIQUE,          -- usado no login, não pode repetir
    senha      VARCHAR(255) NOT NULL,                 -- guarda o HASH da senha (password_hash do PHP), nunca a senha pura
    perfil     ENUM('admin', 'agente') NOT NULL DEFAULT 'agente',
    criado_em  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabela: celas
-- Celas da unidade, organizadas por pavilhão.
-- ------------------------------------------------------------
CREATE TABLE celas (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    pavilhao    VARCHAR(20) NOT NULL,                 -- ex.: 'A', 'B'
    numero      VARCHAR(10) NOT NULL,                 -- ex.: '101'
    capacidade  INT NOT NULL DEFAULT 4,               -- quantos presos cabem na cela
    UNIQUE KEY uk_cela (pavilhao, numero)             -- não pode existir a mesma cela duas vezes no pavilhão
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabela: presos
-- Cadastro principal do sistema (é nela que o CRUD acontece).
-- ------------------------------------------------------------
CREATE TABLE presos (
    id                    INT AUTO_INCREMENT PRIMARY KEY,
    nome                  VARCHAR(100) NOT NULL,
    cpf                   CHAR(11) NOT NULL UNIQUE,   -- só os 11 números, sem ponto e traço
    data_nascimento       DATE NOT NULL,
    sexo                  ENUM('M', 'F') NOT NULL,
    crime                 VARCHAR(150) NOT NULL,      -- ex.: 'Furto (Art. 155)'
    regime                ENUM('fechado', 'semiaberto', 'aberto') NOT NULL DEFAULT 'fechado',
    pena_meses            INT NOT NULL,               -- tamanho da pena em meses
    data_entrada          DATE NOT NULL,
    data_saida_prevista   DATE NULL,
    status                ENUM('preso', 'liberado', 'transferido') NOT NULL DEFAULT 'preso',
    cela_id               INT NULL,                   -- em qual cela está (NULL = sem cela)
    cadastrado_por        INT NULL,                   -- qual usuário fez o cadastro
    observacoes           TEXT NULL,
    criado_em             TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em         TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Chaves estrangeiras: ligam o preso à cela e ao usuário.
    -- ON DELETE SET NULL: se a cela ou o usuário for excluído,
    -- o preso continua cadastrado, só fica com o campo vazio.
    CONSTRAINT fk_preso_cela    FOREIGN KEY (cela_id)        REFERENCES celas(id)    ON DELETE SET NULL,
    CONSTRAINT fk_preso_usuario FOREIGN KEY (cadastrado_por) REFERENCES usuarios(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================================
--  DADOS DE EXEMPLO (fictícios, só para testar e apresentar)
-- ============================================================

-- Usuário inicial para o primeiro login:
--   e-mail: admin@prisao.com      senha: admin123
-- O valor abaixo é o hash dessa senha, no formato do password_hash() do PHP.
-- No login, o PHP confere com: password_verify($senhaDigitada, $usuario['senha'])
INSERT INTO usuarios (nome, email, senha, perfil) VALUES
('Administrador', 'admin@prisao.com', '$2y$10$1FTY.suXGh0KPiHtV0/4ruG5GgsUFlfKdEPqI6xQa7A617bn/jdeq', 'admin');

INSERT INTO celas (pavilhao, numero, capacidade) VALUES
('A', '101', 4),
('A', '102', 4),
('B', '201', 6),
('B', '202', 2);

INSERT INTO presos
    (nome, cpf, data_nascimento, sexo, crime, regime, pena_meses, data_entrada, data_saida_prevista, status, cela_id, cadastrado_por, observacoes)
VALUES
('João Carlos da Silva',   '11122233344', '1990-05-12', 'M', 'Furto (Art. 155)',        'fechado',    36, '2025-03-10', '2028-03-10', 'preso',       1, 1, NULL),
('Marcos Antônio Pereira', '22233344455', '1985-11-30', 'M', 'Roubo (Art. 157)',        'fechado',    72, '2024-08-01', '2030-08-01', 'preso',       1, 1, 'Trabalha na cozinha.'),
('Rafael Souza Lima',      '33344455566', '1998-02-20', 'M', 'Estelionato (Art. 171)',  'semiaberto', 24, '2025-09-15', '2027-09-15', 'preso',       3, 1, NULL),
('Ana Paula Ferreira',     '44455566677', '1993-07-08', 'F', 'Receptação (Art. 180)',   'aberto',     12, '2025-01-20', '2026-01-20', 'liberado', NULL, 1, 'Pena cumprida.');
