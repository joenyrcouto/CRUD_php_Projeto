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
    </style>
</head>
<body>
    <div class="container">
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

            // Operação de Inserção de Aluno
            if (isset($_POST['insert_aluno'])) {
                $matricula = $_POST['matr'];
                $nome = $_POST['nome'];
                $curso = $_POST['curso'];
                $mes = $_POST['mes'];
                $ano = $_POST['ano'];
                $periodo = $_POST['periodo'];
                $gostaDe = implode(", ", $_POST['gostaDe']);
                
                // Verifica se a matrícula já existe
                $selectQuery = "SELECT matr FROM aluno WHERE matr = '$matricula'";
                $result = mysqli_query($conexao, $selectQuery);
                if (mysqli_num_rows($result) > 0) {
                    echo '<div class="alert alert-danger">Erro ao inserir registro de Aluno: Matrícula já existente</div>';
                } else {
                    $insertQuery = "INSERT INTO aluno (matr, nome, curso, mes, ano, periodo, gostaDe) VALUES ('$matricula', '$nome', '$curso', '$mes', '$ano', '$periodo', '$gostaDe')";
                    if (mysqli_query($conexao, $insertQuery)) {
                        echo '<div class="alert alert-success">Registro de Aluno inserido com sucesso!</div>';
                    } else {
                        echo '<div class="alert alert-danger">Erro ao inserir registro de Aluno: ' . mysqli_error($conexao) . '</div>';
                    }
                }
            }

            // Operação de Leitura de Aluno
            if (isset($_POST['read_aluno'])) {
                $matricula = $_POST['matr'];
                $selectQuery = "SELECT * FROM aluno WHERE matr = '$matricula'";
                $result = mysqli_query($conexao, $selectQuery);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $nome = $row['nome'];
                    $curso = $row['curso'];
                    $mes = $row['mes'];
                    $ano = $row['ano'];
                    $periodo = $row['periodo'];
                    $gostaDe = explode(", ", $row['gostaDe']);
                } else {
                    echo '<div class="alert alert-warning">Registro de Aluno não encontrado</div>';
                    $nome = "";
                    $curso = "";
                    $mes = "";
                    $ano = "";
                    $periodo = "";
                    $gostaDe = [];
                }
            }

            // Operação de Atualização de Aluno
            if (isset($_POST['update_aluno'])) {
                $matricula = $_POST['matr'];
                $nome = $_POST['nome'];
                $curso = $_POST['curso'];
                $mes = $_POST['mes'];
                $ano = $_POST['ano'];
                $periodo = $_POST['periodo'];
                $gostaDe = implode(", ", $_POST['gostaDe']);
                
                $updateQuery = "UPDATE aluno SET nome = '$nome', curso = '$curso', mes = '$mes', ano = '$ano', periodo = '$periodo', gostaDe = '$gostaDe' WHERE matr = '$matricula'";
                if (mysqli_query($conexao, $updateQuery)) {
                    echo '<div class="alert alert-success">Registro de Aluno atualizado com sucesso!</div>';
                } else {
                    echo '<div class="alert alert-danger">Erro ao atualizar registro de Aluno: ' . mysqli_error($conexao) . '</div>';
                }
            }

            // Operação de Exclusão de Aluno
            if (isset($_POST['delete_aluno'])) {
                $matricula = $_POST['matr'];
                $deleteQuery = "DELETE FROM aluno WHERE matr = '$matricula'";
                if (mysqli_query($conexao, $deleteQuery)) {
                    echo '<div class="alert alert-success">Registro de Aluno excluído com sucesso!</div>';
                } else {
                    echo '<div class="alert alert-danger">Erro ao excluir registro de Aluno: ' . mysqli_error($conexao) . '</div>';
                }
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
                    echo '<td>' . $row['curso'] . '</td>';
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
                    <input type="text" class="form-control" id="matricula" name="matr" value="<?php echo isset($matricula) ? $matricula : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo isset($nome) ? $nome : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="curso">Curso</label>
                    <input type="text" class="form-control" id="curso" name="curso" value="<?php echo isset($curso) ? $curso : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="mes">Mês</label>
                    <select class="form-control" id="mes" name="mes">
                        <option value="Janeiro" <?php echo isset($mes) && $mes == 'Janeiro' ? 'selected' : ''; ?>>Janeiro</option>
                        <option value="Fevereiro" <?php echo isset($mes) && $mes == 'Fevereiro' ? 'selected' : ''; ?>>Fevereiro</option>
                        <option value="Março" <?php echo isset($mes) && $mes == 'Março' ? 'selected' : ''; ?>>Março</option>
                        <!-- Adicionar os outros meses aqui -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="ano">Ano</label>
                    <select class="form-control" id="ano" name="ano">
                        <option value="2021" <?php echo isset($ano) && $ano == '2021' ? 'selected' : ''; ?>>2021</option>
                        <option value="2022" <?php echo isset($ano) && $ano == '2022' ? 'selected' : ''; ?>>2022</option>
                        <option value="2023" <?php echo isset($ano) && $ano == '2023' ? 'selected' : ''; ?>>2023</option>
                        <!-- Adicionar os outros anos aqui -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="periodo">Período</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="periodo" id="periodo1" value="1" <?php echo isset($periodo) && $periodo == '1' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="periodo1">1</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="periodo" id="periodo2" value="2" <?php echo isset($periodo) && $periodo == '2' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="periodo2">2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="periodo" id="periodo3" value="3" <?php echo isset($periodo) && $periodo == '3' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="periodo3">3</label>
                    </div>
                    <!-- Adicionar os outros períodos aqui -->
                </div>
                <div class="form-group">
                    <label for="gostaDe">Gosta de:</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="gostaDe[]" id="gostaDe1" value="Matemática" <?php echo isset($gostaDe) && in_array('Matemática', $gostaDe) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="gostaDe1">Matemática</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="gostaDe[]" id="gostaDe2" value="Ciências" <?php echo isset($gostaDe) && in_array('Ciências', $gostaDe) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="gostaDe2">Ciências</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="gostaDe[]" id="gostaDe3" value="História" <?php echo isset($gostaDe) && in_array('História', $gostaDe) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="gostaDe3">História</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="gostaDe[]" id="gostaDe4" value="Geografia" <?php echo isset($gostaDe) && in_array('Geografia', $gostaDe) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="gostaDe4">Geografia</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="gostaDe[]" id="gostaDe5" value="Português" <?php echo isset($gostaDe) && in_array('Português', $gostaDe) ? 'checked' : ''; ?>>
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
                    <input type="text" class="form-control" id="id" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="nome_curso">Nome do Curso</label>
                    <input type="text" class="form-control" id="nome_curso" name="nome_curso" value="<?php echo isset($nome_curso) ? $nome_curso : ''; ?>">
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
</body>
</html>
