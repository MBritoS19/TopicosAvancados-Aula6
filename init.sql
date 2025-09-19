-- Define o conjunto de caracteres para a conexão e para os dados
SET NAMES 'utf8mb4';
SET CHARACTER SET utf8mb4;

-- Remove o banco de dados 'britinho' se ele já existir.
DROP DATABASE IF EXISTS britinho;

-- Cria o banco de dados 'britinho' com suporte a caracteres especiais e acentuação.
CREATE DATABASE britinho
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Usa o banco de dados recém-criado para as próximas operações.
USE britinho;

-- Cria a tabela 'Clientes' com as especificações de caracteres.
CREATE TABLE Clientes (
    Id_Cliente INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL,
    Endereco VARCHAR(255),
    Cidade VARCHAR(50),
    Telefone VARCHAR(20)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Insere os dados dos clientes.
INSERT INTO Clientes (Nome, Endereco, Cidade, Telefone) VALUES
('Ana Silva', 'Rua das Flores, 123', 'São Paulo', '(11) 98765-4321'),
('Bruno Costa', 'Avenida Principal, 456', 'Rio de Janeiro', '(21) 91234-5678'),
('Carla Dias', 'Praça da Matriz, 789', 'Belo Horizonte', '(31) 95555-4444'),
('Daniel Farias', 'Rua da Moeda, 321', 'Recife', '(81) 99988-7766'),
('Eduarda Lima', 'Avenida Boa Viagem, 1500', 'Recife', '(81) 98123-4567'),
('Fábio Pereira', 'Rua Augusta, 999', 'São Paulo', '(11) 97654-3210'),
('Gabriela Nunes', 'Travessa das Palmeiras, 45', 'Manaus', '(92) 99111-2222'),
('Heitor Almeida', 'Rua 25 de Março, 780', 'São Paulo', '(11) 98877-6655'),
('Isabela Santos', 'Avenida Atlântica, 2020', 'Rio de Janeiro', '(21) 99876-5432'),
('João Rodrigues', 'Rua dos Andradas, 500', 'Porto Alegre', '(51) 98400-1122'),
('Larissa Mendes', 'Setor Hoteleiro Sul, Quadra 5', 'Brasília', '(61) 99655-8899'),
('Marcos Oliveira', 'Avenida Afonso Pena, 1200', 'Belo Horizonte', '(31) 98765-1234'),
('Natália Azevedo', 'Rua da Bahia, 1850', 'Belo Horizonte', '(31) 99234-5678'),
('Otávio Barros', 'Rua Padre Eutíquio, 745', 'Belém', '(91) 98112-3344'),
('Patrícia Rocha', 'Avenida Sete de Setembro, 300', 'Salvador', '(71) 99100-2030'),
('Ricardo Gomes', 'Rua das Laranjeiras, 58', 'Rio de Janeiro', '(21) 98888-9999'),
('Sofia Carvalho', 'Eixo Monumental, S/N', 'Brasília', '(61) 98181-8282'),
('Thiago Ferreira', 'Avenida Ipiranga, 200', 'São Paulo', '(11) 97575-8585'),
('Úrsula Vasconcelos', 'Rua do Imperador, 1010', 'Petrópolis', '(24) 99876-4321'),
('Vitor Hugo', 'Avenida Paulista, 1578', 'São Paulo', '(11) 95432-1098'),
('Wagner Souza', 'Rua XV de Novembro, 180', 'Curitiba', '(41) 99900-0099'),
('Xavier Pires', 'Alameda Dr. Carlos de Carvalho, 900', 'Curitiba', '(41) 98877-1122'),
('Yasmin Correia', 'Avenida Beira Mar, 4050', 'Fortaleza', '(85) 99777-6655'),
('Amanda Guimarães', 'Rua Oscar Freire, 550', 'São Paulo', '(11) 98234-4321'),
('Bento Ribeiro', 'Rua da Consolação, 2100', 'São Paulo', '(11) 97123-8765'),
('Clara Monteiro', 'Avenida Rio Branco, 1', 'Rio de Janeiro', '(21) 99555-1212'),
('Davi Nogueira', 'Rua Barão do Rio Branco, 1400', 'Fortaleza', '(85) 98555-5858'),
('Elisa Matos', 'Rua da Aurora, 1255', 'Recife', '(81) 99333-4444'),
('Flávio Teixeira', 'Avenida Borges de Medeiros, 800', 'Porto Alegre', '(51) 99600-0660'),
('Zeca Martins', 'Travessa dos Sonhos, 101', 'Salvador', '(71) 98888-7777');

-- Seleciona todos os dados da tabela 'Clientes' para verificação.
SELECT * FROM Clientes;