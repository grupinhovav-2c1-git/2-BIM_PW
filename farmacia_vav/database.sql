CREATE DATABASE IF NOT EXISTS farmacia_vav
CHARACTER SET utf8mb4 
COLLATE utf8mb4_general_ci;

USE farmacia_vav;

CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    fabricante VARCHAR(100) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    estoque INT NOT NULL
);
