-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS petshop;
USE petshop;

-- Criar tabela de agendamentos
DROP TABLE IF EXISTS agendamentos;
CREATE TABLE agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NULL,
    nome_cliente VARCHAR(100) NOT NULL,
    nome_pet VARCHAR(100) NOT NULL,
    tipo_servico VARCHAR(255) NOT NULL,
    data_agendamento DATE NOT NULL,
    horario_agendamento TIME NOT NULL,
    contato_cliente VARCHAR(30) NOT NULL,
    metodo_pagamento VARCHAR(50) NOT NULL DEFAULT 'Dinheiro',
    valor_total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    status VARCHAR(20) DEFAULT 'Pendente'
);

-- Criar tabela de funcionários
DROP TABLE IF EXISTS funcionarios;
CREATE TABLE funcionarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);

-- Inserir funcionário de exemplo
INSERT INTO funcionarios (nome, email, senha)
VALUES ('emma', 'emma@petshop.com', 'emmamanu');

-- Criar tabela de clientes
DROP TABLE IF EXISTS clientes;
CREATE TABLE clientes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome_completo VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  telefone VARCHAR(30) NOT NULL,
  cpf VARCHAR(20) NOT NULL UNIQUE,
  senha_hash VARCHAR(255) NOT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Criar foreign key entre agendamentos e clientes
ALTER TABLE agendamentos
  ADD CONSTRAINT fk_agendamento_cliente
  FOREIGN KEY (cliente_id) REFERENCES clientes(id)
  ON DELETE SET NULL
  ON UPDATE CASCADE;
SELECT * FROM clientes;

ALTER TABLE funcionarios
ADD COLUMN ra VARCHAR(50) NOT NULL AFTER senha,
ADD COLUMN cpf VARCHAR(20) NOT NULL AFTER ra;

