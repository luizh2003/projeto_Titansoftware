-- Criação do banco de dados (se necessário)
CREATE DATABASE IF NOT EXISTS testesql;

-- Selecionar o banco de dados correto
USE testesql;

-- Criação das tabelas
CREATE TABLE produtos (
    cod_prod INT(8) NOT NULL,
    loj_prod INT(8) NOT NULL,
    desc_prod CHAR(40),
    dt_inclu_prod DATE,
    preco_prod DECIMAL(8,3),
    PRIMARY KEY (cod_prod, loj_prod)
);

CREATE TABLE estoque (
    cod_prod INT(8) NOT NULL,
    loj_prod INT(8) NOT NULL,
    qtd_prod DECIMAL(15,3),
    PRIMARY KEY (cod_prod, loj_prod)
);

CREATE TABLE lojas (
    loj_prod INT(8) NOT NULL,
    desc_loj CHAR(40),
    PRIMARY KEY (loj_prod)
);

-- Inserção de dados na tabela 'produtos'
INSERT INTO produtos (cod_prod, loj_prod, desc_prod, dt_inclu_prod, preco_prod)
VALUES (170, 2, 'LEITE CONDENSADO MOCOCA', '2010-12-30', 45.40);

-- Atualização de preço do produto
UPDATE produtos
SET preco_prod = 95.40
WHERE cod_prod = 170 AND loj_prod = 2;

-- Seleção de todos os produtos das lojas 1 e 2
SELECT * 
FROM produtos 
WHERE loj_prod IN (1, 2);

-- Seleção da menor e maior data de inclusão de produtos
SELECT MIN(dt_inclu_prod) AS menor_data, MAX(dt_inclu_prod) AS maior_data
FROM produtos;

-- Contagem total de registros na tabela 'produtos'
SELECT COUNT(*) AS total_registros
FROM produtos;

-- Seleção de produtos que começam com a letra 'L'
SELECT * 
FROM produtos 
WHERE desc_prod LIKE 'L%';

-- Soma dos preços dos produtos por loja
SELECT loj_prod, SUM(preco_prod) AS total_preco
FROM produtos
GROUP BY loj_prod;

-- Soma dos preços dos produtos por loja, onde o total é maior que R$100.000
SELECT loj_prod, SUM(preco_prod) AS total_preco
FROM produtos
GROUP BY loj_prod
HAVING total_preco > 100000;

-- Seleção de produtos e informações de estoque e loja para a loja com cod_prod = 1
SELECT p.loj_prod, l.desc_loj, p.cod_prod, p.desc_prod, p.preco_prod, e.qtd_prod
FROM produtos p
JOIN lojas l ON p.loj_prod = l.loj_prod
JOIN estoque e ON p.cod_prod = e.cod_prod AND p.loj_prod = e.loj_prod
WHERE p.loj_prod = 1;

-- Seleção de produtos que não possuem entrada na tabela de estoque
SELECT p.*
FROM produtos p
LEFT JOIN estoque e ON p.cod_prod = e.cod_prod AND p.loj_prod = e.loj_prod
WHERE e.cod_prod IS NULL;

-- Seleção de produtos na tabela de estoque que não existem na tabela de produtos
SELECT e.*
FROM estoque e
LEFT JOIN produtos p ON e.cod_prod = p.cod_prod AND e.loj_prod = p.loj_prod
WHERE p.cod_prod IS NULL;
