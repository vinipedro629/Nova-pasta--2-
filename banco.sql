-- ==========================================
-- BANCO DE DADOS
-- Meu Caderno de Estudos
-- ==========================================

-- Criar o banco de dados
CREATE DATABASE IF NOT EXISTS meu_caderno
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Usar o banco
USE meu_caderno;

-- ==========================================
-- TABELA DE PERGUNTAS
-- ==========================================

CREATE TABLE IF NOT EXISTS perguntas (

    id INT AUTO_INCREMENT PRIMARY KEY,

    pergunta TEXT NOT NULL,

    resposta LONGTEXT NOT NULL,

    categoria VARCHAR(100) NOT NULL,

    favorito TINYINT(1) NOT NULL DEFAULT 0,

    nivel ENUM(
        'Fácil',
        'Médio',
        'Difícil'
    ) DEFAULT 'Médio',

    acertos INT DEFAULT 0,

    erros INT DEFAULT 0,

    visualizacoes INT DEFAULT 0,

    ultima_revisao DATETIME NULL,

    proxima_revisao DATETIME NULL,

    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP

);

-- ==========================================
-- ÍNDICES
-- ==========================================

CREATE INDEX idx_categoria
ON perguntas(categoria);

CREATE INDEX idx_favorito
ON perguntas(favorito);

CREATE INDEX idx_nivel
ON perguntas(nivel);

-- ==========================================
-- DADOS DE EXEMPLO
-- ==========================================

INSERT INTO perguntas
(
    pergunta,
    resposta,
    categoria,
    favorito,
    nivel
)

VALUES

(
    'O que é HTML?',
    'HTML é uma linguagem de marcação utilizada para estruturar páginas da web.',
    'Programação',
    1,
    'Fácil'
),

(
    'O que é CSS?',
    'CSS é utilizado para estilizar páginas da web.',
    'Programação',
    0,
    'Fácil'
),

(
    'O que é JavaScript?',
    'JavaScript é uma linguagem de programação responsável pela interatividade das páginas.',
    'Programação',
    0,
    'Médio'
),

(
    'O que é PHP?',
    'PHP é uma linguagem de programação executada no servidor e muito utilizada para sistemas web.',
    'Programação',
    1,
    'Médio'
);