CREATE TABLE IF NOT EXISTS usuario (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  nome varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  senha varchar(255) NOT NULL,
  perfil varchar(255) NOT NULL DEFAULT 'admin'
);