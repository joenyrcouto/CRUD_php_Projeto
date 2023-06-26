<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD com PHP</title>
    <!-- Adicionando os arquivos CSS do framework Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Estilos personalizados */
        .container {
            margin-top: 50px;
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 97%px;
            margin: 0 auto;
        }
        body {
            background-image: url('imagem.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        }
    </style>
</head>
<body>
    <div class="container" style="background-color: white;">
        <h1 style="text-align: center;">CRUD com PHP</h1>
        <hr>

        <div class="form-container">
            <?php
            $host = 'localhost';
            $port = '3306';
            $dbname = 'couto_para_form';
            $username = 'root';
            $password = '';

            // Conexão com o banco de dados
            $conexao = mysqli_connect($host, $username, $password, $dbname, $port);
            if (!$conexao) {
                die('Falha na conexão com o banco de dados: ' . mysqli_connect_error());
            } else {
                echo '<div class="alert alert-success">Conexão com o banco de dados estabelecida!</div>';
            }

            class Aluno {
                public $matricula;
                public $nome;
                public $curso;
                public $mes;
                public $ano;
                public $periodo;
                public $gostaDe;
                public $conexao;

                public function __construct($matricula, $nome, $curso, $mes, $ano, $periodo, $gostaDe, $conexao){
                    $this->matricula = $matricula;
                    $this->nome = $nome;
                    $this->curso = $curso;
                    $this->mes = $mes;
                    $this->ano = $ano;
                    $this->periodo = $periodo;
                    $this->gostaDe = $gostaDe;
                    $this->conexao = $conexao;
                }

                    public function insertaluno(){
                    // Verifica se a matrícula já existe
                    $selectQuery = "SELECT matr FROM aluno WHERE matr = '" . $this->matricula . "'";
                    $result = mysqli_query($this->conexao, $selectQuery);
                    if (mysqli_num_rows($result) > 0) {
                        echo '<div class="alert alert-danger">Erro ao inserir registro de Aluno: Matrícula já existente</div>';
                    } else {
                        $insertQuery = "INSERT INTO aluno (matr, nome, curso, mes, ano, periodo, gostaDe) VALUES ('$this->matricula', '$this->nome', '$this->curso', '$this->mes', '$this->ano', '$this->periodo', '$this->gostaDe')";
                        if (mysqli_query($this->conexao, $insertQuery)) {
                            echo '<div class="alert alert-success">Registro de Aluno inserido com sucesso!</div>';
                        } else {
                            echo '<div class="alert alert-danger">Erro ao inserir registro de Aluno: ' . mysqli_error($this->conexao) . '</div>';
                        }
                    }
                }

                public function updatealuno(){
                    $updateQuery = "UPDATE aluno SET nome = ' $this->nome', curso = '$this->curso', mes = '$this->mes', ano = '$this->ano', periodo = '$this->periodo', gostaDe = '$this->gostaDe' WHERE matr = '$this->matricula'";
                if (mysqli_query($this->conexao, $updateQuery)) {
                    echo '<div class="alert alert-success">Registro de Aluno atualizado com sucesso!</div>';
                } else {
                    echo '<div class="alert alert-danger">Erro ao atualizar registro de Aluno: ' . mysqli_error($this->conexao) . '</div>';
                }
                }

                public function deletealuno(){
                $deleteQuery = "DELETE FROM aluno WHERE matr = '$this->matricula'";
                if (mysqli_query($this->conexao, $deleteQuery)) {
                    echo '<div class="alert alert-success">Registro de Aluno excluído com sucesso!</div>';
                } else {
                    echo '<div class="alert alert-danger">Erro ao excluir registro de Aluno: ' . mysqli_error($this->conexao) . '</div>';
                }
                }

                public function readaluno(){
                    $selectQuery = "SELECT * FROM aluno WHERE matr = '$this->matricula'";
                    $result = mysqli_query($this->conexao, $selectQuery);
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $this->nome = $row['nome'];
                        $this->curso = $row['curso'];
                        $this->mes = $row['mes'];
                        $this->ano = $row['ano'];
                        $this->periodo = $row['periodo'];
                        $this->gostaDe = explode(", ", $row['gostaDe']);
                    } else {
                        echo '<div class="alert alert-warning">Registro de Aluno não encontrado</div>';
                        $this->nome = "";
                        $this->curso = "";
                        $this->mes = "";
                        $this->ano = "";
                        $this->periodo = "";
                        $this->gostaDe = [];
                    }
                }

            }

            // Operação de Leitura de Aluno
            if (isset($_POST['read_aluno'])) {
                $Aluno = new Aluno($_POST['matr'], "", "", "", "", "", "", $conexao);
                $Aluno->readaluno();
            }

            // Operação de Inserção de Aluno
if (isset($_POST['insert_aluno'])) {
        $Aluno = new Aluno($_POST['matr'], $_POST['nome'], $_POST['curso'], $_POST['mes'], $_POST['ano'], $_POST['periodo'], implode(", ", $_POST['gostaDe']), $conexao);
        $Aluno->insertaluno();
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
}

// Operação de Atualização de Aluno
if (isset($_POST['update_aluno'])) {
    $Aluno = new Aluno($_POST['matr'], $_POST['nome'], $_POST['curso'], $_POST['mes'], $_POST['ano'], $_POST['periodo'], implode(", ", $_POST['gostaDe']), $conexao);
    $Aluno->updatealuno();
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Operação de Exclusão de Aluno
if (isset($_POST['delete_aluno'])) {
    $Aluno = new Aluno($_POST['matr'], "", "", "", "", "", "", $conexao);
    $Aluno->deletealuno();
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

            // Listagem dos alunos existentes
            $selectAllQuery = "SELECT * FROM aluno";
            $result = mysqli_query($conexao, $selectAllQuery);
            if (mysqli_num_rows($result) > 0) {
                echo '<h2>Registros de Alunos existentes:</h2>';
                echo '<table class="table">';
                echo '<thead class="thead-light">';
                echo '<tr>';
                echo '<th scope="col">Matrícula</th>';
                echo '<th scope="col">Nome</th>';
                echo '<th scope="col">Curso</th>';
                echo '<th scope="col">Mês</th>';
                echo '<th scope="col">Ano</th>';
                echo '<th scope="col">Período</th>';
                echo '<th scope="col">Gosta de</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . $row['matr'] . '</td>';
                    echo '<td>' . $row['nome'] . '</td>';
                    
                    // Consulta para obter o nome do curso
            $cursoId = $row['curso'];
            $cursoQuery = "SELECT nome FROM curso_principal WHERE id = '$cursoId'";
            $cursoResult = mysqli_query($conexao, $cursoQuery);
            $cursoRow = mysqli_fetch_assoc($cursoResult);
            echo '<td>' . $cursoRow['nome'] . '</td>';

                    echo '<td>' . $row['mes'] . '</td>';
                    echo '<td>' . $row['ano'] . '</td>';
                    echo '<td>' . $row['periodo'] . '</td>';
                    echo '<td>' . $row['gostaDe'] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo 'Nenhum registro de Aluno encontrado';
            }

            // Fechando a conexão com o banco de dados
            mysqli_close($conexao);
            ?>

            <form method="post" class="mt-3">
                <div class="form-group">
                    <label for="matricula">Matrícula</label>
                    <input type="text" class="form-control" id="matricula" name="matr" value="<?php echo isset($Aluno->matricula) ? $Aluno->matricula : ''; ?>"  minlength="1">
                </div>
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo isset($Aluno->nome) ? $Aluno->nome : ''; ?>"  minlength="2">
                </div>

                <div class="form-group">
    <label for="curso">Curso</label>
    <select class="form-control" id="curso" name="curso" >
        <?php
        $host = 'localhost';
            $port = '3306';
            $dbname = 'couto_para_form';
            $username = 'root';
            $password = '';

            // Conexão com o banco de dados
            $conexao = mysqli_connect($host, $username, $password, $dbname, $port);
            if (!$conexao) {
                die('Falha na conexão com o banco de dados: ' . mysqli_connect_error());
            } else {
                echo '<div class="alert alert-success">Conexão com o banco de dados estabelecida!</div>';
            }
        // Consulta para obter os cursos principais
        $cursosQuery = "SELECT id, nome FROM curso_principal";
        $cursosResult = mysqli_query($conexao, $cursosQuery);

        if (mysqli_num_rows($cursosResult) > 0) {
            while ($curso = mysqli_fetch_assoc($cursosResult)) {
                $selected = isset($Aluno->curso) && $Aluno->curso == $curso['id'] ? 'selected' : '';
                echo '<option value="' . $curso['id'] . '" ' . $selected . '>' . $curso['nome'] . '</option>';
            }
        }
        ?>
    </select>
</div>

                <div class="form-group">
                    <label for="mes">Mês</label>
                    <select class="form-control" id="mes" name="mes">
                        <option value="Janeiro" <?php echo isset($Aluno->mes) && $Aluno->mes == 'Janeiro' ? 'selected' : ''; ?>>Janeiro</option>
                        <option value="Fevereiro" <?php echo isset($Aluno->mes) && $Aluno->mes == 'Fevereiro' ? 'selected' : ''; ?>>Fevereiro</option>
                        <option value="Março" <?php echo isset($Aluno->mes) && $Aluno->mes == 'Março' ? 'selected' : ''; ?>>Março</option>
                        <!-- Adicionar os outros meses aqui -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="ano">Ano</label>
                    <select class="form-control" id="ano" name="ano">
                        <option value="2021" <?php echo isset($Aluno->ano) && $Aluno->ano == '2021' ? 'selected' : ''; ?>>2021</option>
                        <option value="2022" <?php echo isset($Aluno->ano) && $Aluno->ano == '2022' ? 'selected' : ''; ?>>2022</option>
                        <option value="2023" <?php echo isset($Aluno->ano) && $Aluno->ano == '2023' ? 'selected' : ''; ?>>2023</option>
                        <!-- Adicionar os outros anos aqui -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="periodo">Período</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="periodo" id="periodo1" value="1" <?php echo isset($Aluno->periodo) && $Aluno->periodo == '1' ? 'checked' : ''; ?> >
                        <label class="form-check-label" for="periodo1">1</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="periodo" id="periodo2" value="2" <?php echo isset($Aluno->periodo) && $Aluno->periodo == '2' ? 'checked' : ''; ?> >
                        <label class="form-check-label" for="periodo2">2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="periodo" id="periodo3" value="3" <?php echo isset($Aluno->periodo) && $Aluno->periodo == '3' ? 'checked' : ''; ?> >
                        <label class="form-check-label" for="periodo3">3</label>
                    </div>
                    <!-- Adicionar os outros períodos aqui -->
                </div>
                <div class="form-group">
                    <label for="gostaDe">Gosta de:</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="gostaDe[]" id="gostaDe1" value="Matemática" <?php echo isset($Aluno->gostaDe) && in_array('Matemática', $Aluno->gostaDe) ? 'checked' : ''; ?> >
                        <label class="form-check-label" for="gostaDe1">Matemática</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="gostaDe[]" id="gostaDe2" value="Ciências" <?php echo isset($Aluno->gostaDe) && in_array('Ciências', $Aluno->gostaDe) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="gostaDe2">Ciências</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="gostaDe[]" id="gostaDe3" value="História" <?php echo isset($Aluno->gostaDe) && in_array('História', $Aluno->gostaDe) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="gostaDe3">História</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="gostaDe[]" id="gostaDe4" value="Geografia" <?php echo isset($Aluno->gostaDe) && in_array('Geografia', $Aluno->gostaDe) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="gostaDe4">Geografia</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="gostaDe[]" id="gostaDe5" value="Português" <?php echo isset($Aluno->gostaDe) && in_array('Português', $Aluno->gostaDe) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="gostaDe5">Português</label>
                    </div>
                </div>
                    <!-- Adicionar as outras opções de gostos aqui -->
                    <div class="btn-group" role="group">
                    <button type="submit" class="btn btn-primary" name="insert_aluno">Inserir</button>
                    <button type="submit" class="btn btn-secondary" name="read_aluno">Buscar</button>
                    <button type="submit" class="btn btn-info" name="update_aluno">Atualizar</button>
                    <button type="submit" class="btn btn-danger" name="delete_aluno">Excluir</button>
                </div>
                </div>
            </form>
            <br>
        </div>
    </div>
</body>

<body>
    <div class="container">

        <div class="form-container">
            <?php
            $host = 'localhost';
            $port = '3306';
            $dbname = 'couto_para_form';
            $username = 'root';
            $password = '';

            // Conexão com o banco de dados
            $conexao = mysqli_connect($host, $username, $password, $dbname, $port);
            if (!$conexao) {
                die('Falha na conexão com o banco de dados: ' . mysqli_connect_error());
            } else {
                echo '<div class="alert alert-success">Conexão com o banco de dados estabelecida!</div>';
            }

            // Operação de Inserção de Curso Principal
            if (isset($_POST['insert_curso'])) {
                $id = $_POST['id'];
                $nome_curso = $_POST['nome_curso'];

                // Verifica se o ID já existe
                $selectQuery = "SELECT id FROM curso_principal WHERE id = '$id'";
                $result = mysqli_query($conexao, $selectQuery);
                if (mysqli_num_rows($result) > 0) {
                    echo '<div class="alert alert-danger">Erro ao inserir registro: ID já existente</div>';
                } else {
                    $insertQuery = "INSERT INTO curso_principal (id, nome) VALUES ('$id', '$nome_curso')";
                    if (mysqli_query($conexao, $insertQuery)) {
                        echo '<div class="alert alert-success">Registro de Curso Principal inserido com sucesso!</div>';
                    } else {
                        echo '<div class="alert alert-danger">Erro ao inserir registro: ' . mysqli_error($conexao) . '</div>';
                    }
                }
            }

            // Operação de Leitura de Curso Principal
            if (isset($_POST['read_curso'])) {
                $id = $_POST['id'];
                $selectQuery = "SELECT nome FROM curso_principal WHERE id = '$id'";
                $result = mysqli_query($conexao, $selectQuery);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $nome_curso = $row['nome'];
                } else {
                    echo '<div class="alert alert-warning">Registro de Curso Principal não encontrado</div>';
                    $nome_curso = "";
                }
            }

            // Operação de Atualização de Curso Principal
            if (isset($_POST['update_curso'])) {
                $id = $_POST['id'];
                $nome_curso = $_POST['nome_curso'];
                $updateQuery = "UPDATE curso_principal SET nome = '$nome_curso' WHERE id = '$id'";
                if (mysqli_query($conexao, $updateQuery)) {
                    echo '<div class="alert alert-success">Registro de Curso Principal atualizado com sucesso!</div>';
                } else {
                    echo '<div class="alert alert-danger">Erro ao atualizar registro: ' . mysqli_error($conexao) . '</div>';
                }
            }

            // Operação de Exclusão de Curso Principal
if (isset($_POST['delete_curso'])) {
    $id = $_POST['id'];

    // Verifica se o curso é chave estrangeira de algum aluno
    $checkQuery = "SELECT id FROM aluno WHERE curso = '$id'";
    $checkResult = mysqli_query($conexao, $checkQuery);
    if (mysqli_num_rows($checkResult) > 0) {
        echo '<div class="alert alert-danger">Erro ao excluir registro: O curso é uma chave estrangeira em outro registro e não pode ser excluído!</div>';
    } else {
        // Verifica se o curso é chave estrangeira de algum outro registro (outra tabela)
        // Adicione aqui a consulta para verificar outras tabelas, se necessário

        // Se não houver registros correspondentes em nenhuma tabela, exclui o curso principal
        $deleteQuery = "DELETE FROM curso_principal WHERE id = '$id'";
        if (mysqli_query($conexao, $deleteQuery)) {
            echo '<div class="alert alert-success">Registro de Curso Principal excluído com sucesso!</div>';
        } else {
            echo '<div class="alert alert-danger">Erro ao excluir registro: ' . mysqli_error($conexao) . '</div>';
        }
    }
}


            // Listagem dos registros existentes de Curso Principal
            $selectAllCursoQuery = "SELECT * FROM curso_principal";
            $resultCurso = mysqli_query($conexao, $selectAllCursoQuery);
            if (mysqli_num_rows($resultCurso) > 0) {
                echo '<h2>Registros existentes de Curso Principal:</h2>';
                echo '<table class="table">';
                echo '<thead class="thead-light">';
                echo '<tr>';
                echo '<th scope="col">ID</th>';
                echo '<th scope="col">Nome do Curso</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ($row = mysqli_fetch_assoc($resultCurso)) {
                    echo '<tr>';
                    echo '<td>' . $row['id'] . '</td>';
                    echo '<td>' . $row['nome'] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo 'Nenhum registro de Curso Principal encontrado';
            }

            // Fechando a conexão com o banco de dados
            mysqli_close($conexao);
            ?>

            <h2>Formulário de Curso Principal</h2>
            <form method="post" class="mt-3">
                <div class="form-group">
                    <label for="id">ID</label>
                    <input type="text" class="form-control" id="id" name="id" value="<?php echo isset($id) ? $id : ''; ?>"  minlength="1">
                </div>
                <div class="form-group">
                    <label for="nome_curso">Nome do Curso</label>
                    <input type="text" class="form-control" id="nome_curso" name="nome_curso" value="<?php echo isset($nome_curso) ? $nome_curso : ''; ?>"  minlength="5">
                </div>
                <div class="btn-group" role="group">
                    <button type="submit" name="insert_curso" class="btn btn-primary">Inserir Curso Principal</button>
                    <button type="submit" name="read_curso" class="btn btn-secondary">Consultar Curso Principal</button>
                    <button type="submit" name="update_curso" class="btn btn-info">Atualizar Curso Principal</button>
                    <button type="submit" name="delete_curso" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este curso?')">Excluir Curso Principal</button>
                </div>
            </form>
        </div>
    </div>
    <br>
</body>
</html>
