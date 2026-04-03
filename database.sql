-- Records Store Database
-- Run this file to create and populate the database from scratch.

CREATE DATABASE IF NOT EXISTS records
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE records;

-- --------------------------------------------------------
-- Table: genero
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS genero (
    id_genero INT          NOT NULL AUTO_INCREMENT,
    genero    VARCHAR(100) NOT NULL,
    PRIMARY KEY (id_genero)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO genero (genero) VALUES
    ('Rock'),
    ('Metal'),
    ('Reggae'),
    ('MPB'),
    ('Blues');

-- --------------------------------------------------------
-- Table: utilizadores
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS utilizadores (
    id       INT          NOT NULL AUTO_INCREMENT,
    login    VARCHAR(100) NOT NULL,
    email    VARCHAR(150) NOT NULL,
    password VARCHAR(255) NOT NULL,
    admin    TINYINT(1)   NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample admin user  (password: admin123)
-- Hash generated with password_hash('admin123', PASSWORD_DEFAULT)
INSERT INTO utilizadores (login, email, password, admin) VALUES
    ('admin', 'admin@records.com', '$2y$10$j0j302yvPQwDb2PU4/VTPeHLNWDk.aNRjKEBpYDSgltJLrMvxp9xm', 1);

-- Sample regular user  (password: user123)
INSERT INTO utilizadores (login, email, password, admin) VALUES
    ('user', 'user@records.com', '$2y$10$0a9Y3h./0J.hroSGwgGw4eaEmDbpAoKA072xhYgu0zHwQIEgSsr4e', 0);

-- --------------------------------------------------------
-- Table: discos
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS discos (
    id          INT            NOT NULL AUTO_INCREMENT,
    nome        VARCHAR(150)   NOT NULL,
    preco       DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    id_generoFK INT            NOT NULL,
    imagem      VARCHAR(255)   NOT NULL DEFAULT '',
    PRIMARY KEY (id),
    CONSTRAINT fk_genero FOREIGN KEY (id_generoFK) REFERENCES genero (id_genero)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample discs using the images in /imagens/
-- genre ids: 1=Rock, 2=Metal, 3=Reggae, 4=MPB, 5=Blues
INSERT INTO discos (nome, preco, id_generoFK, imagem) VALUES
    ('Metallica - Black Album',         12.99, 2, 'imagens/metallica.jpg'),
    ('AC/DC - Back in Black',           11.99, 2, 'imagens/acdc.jpg'),
    ('Bob Marley - Legend',             10.99, 3, 'imagens/bob_marley.jpg'),
    ('Gilberto Gil - Refazenda',         9.99, 4, 'imagens/gilberto_gil.jpg'),
    ('Chico Buarque - Construção',       9.99, 4, 'imagens/chico1.jpg'),
    ('Disco Clássico Vol. 1',            7.99, 1, 'imagens/disco.jpg'),
    ('Disco Clássico Vol. 2',            7.99, 1, 'imagens/disco1.jpg'),
    ('Disco Clássico Vol. 3',            7.99, 1, 'imagens/disco2.jpg'),
    ('Disco Clássico Vol. 4',            7.99, 1, 'imagens/disco3.jpg');
