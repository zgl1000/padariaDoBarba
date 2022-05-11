CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(30),
    email VARCHAR(100),
    senha VARCHAR(32),
    chave VARCHAR(20),
    admin bit
)