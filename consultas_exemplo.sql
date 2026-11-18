-- ============================================================
--  CONSULTAS DE EXEMPLO (CRUD)
--  Servem de modelo para quem vai fazer as páginas PHP e para
--  explicar o banco na apresentação. Pode rodar na aba "SQL"
--  do phpMyAdmin para testar.
--  No PHP, troque os valores fixos por "?" (prepared statement).
-- ============================================================

USE sistema_prisional;

-- ---------- LOGIN ----------
-- Busca o usuário pelo e-mail; a senha é conferida no PHP com password_verify()
SELECT id, nome, senha, perfil FROM usuarios WHERE email = 'admin@prisao.com';

-- ---------- CREATE (cadastrar preso) ----------
INSERT INTO presos
    (nome, cpf, data_nascimento, sexo, crime, regime, pena_meses, data_entrada, data_saida_prevista, cela_id, cadastrado_por)
VALUES
    ('Pedro Henrique Alves', '55566677788', '1995-04-18', 'M', 'Furto (Art. 155)', 'fechado', 18, '2026-11-01', '2028-05-01', 2, 1);

-- ---------- READ (listar presos com a cela de cada um) ----------
-- LEFT JOIN: traz também os presos que estão sem cela
SELECT p.id, p.nome, p.cpf, p.crime, p.regime, p.status,
       c.pavilhao, c.numero AS cela
FROM presos p
LEFT JOIN celas c ON c.id = p.cela_id
ORDER BY p.nome;

-- Buscar um preso só (tela de edição)
SELECT * FROM presos WHERE id = 1;

-- Pesquisar por nome (campo de busca da listagem)
SELECT id, nome, cpf, status FROM presos WHERE nome LIKE '%silva%';

-- ---------- UPDATE (editar preso) ----------
UPDATE presos
SET regime = 'semiaberto', cela_id = 3, observacoes = 'Progressão de regime.'
WHERE id = 1;

-- ---------- DELETE (excluir preso) ----------
DELETE FROM presos WHERE cpf = '55566677788';

-- ---------- GESTÃO (números para o painel) ----------
-- Total de presos por status
SELECT status, COUNT(*) AS total FROM presos GROUP BY status;

-- Ocupação de cada cela (quantos presos x capacidade)
SELECT c.id, c.pavilhao, c.numero, c.capacidade,
       COUNT(p.id) AS ocupacao
FROM celas c
LEFT JOIN presos p ON p.cela_id = c.id AND p.status = 'preso'
GROUP BY c.id, c.pavilhao, c.numero, c.capacidade
ORDER BY c.pavilhao, c.numero;
