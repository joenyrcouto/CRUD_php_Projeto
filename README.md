CREATE TABLE Curso_principal (
    id INT not null PRIMARY KEY,
    nome Varchar(255) not null
);

CREATE TABLE Aluno (
  matr INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(255),
  serie VARCHAR(255),
  curso INT,
  mes VARCHAR(255),
  ano INT,
  periodo INT,
  gostaDe VARCHAR(255),
  FOREIGN KEY (curso) REFERENCES Curso_principal(id)
);
