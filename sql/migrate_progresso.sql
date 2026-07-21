-- Migração para criar tabela progresso
CREATE TABLE IF NOT EXISTS progresso (
  id INT AUTO_INCREMENT PRIMARY KEY,
  xp INT NOT NULL DEFAULT 0,
  nivel INT NOT NULL DEFAULT 1,
  perguntas_criadas INT NOT NULL DEFAULT 0,
  revisoes INT NOT NULL DEFAULT 0,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insere linha inicial para sistema single-user
INSERT INTO progresso (xp, nivel, perguntas_criadas, revisoes)
SELECT 0,1,0,0 FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM progresso LIMIT 1);
