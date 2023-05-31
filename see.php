<!DOCTYPE html>
<html>
<head>
    <title>Consulta de Alunos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Consulta de Alunos</h2>

        <form action="see.php" method="GET" class="mt-4">
            <div class="form-group">
                <label for="consultaNome">Nome do Aluno:</label>
                <input type="text" id="consultaNome" name="consultaNome" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Consultar</button>
        </form>

        <?php
        // Estabelecer a conexão com o banco de dados
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "couto_para_form";
        $port = "3306";

        $conn = new mysqli($servername, $username, $password, $database, $port);

        // Verificar a conexão
        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }

        // Processar os dados do formulário
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $consultaNome = $_GET["consultaNome"];

            // Executar a consulta com a junção entre a tabela Aluno e a tabela CursoPrincipal
            $sql = "SELECT aluno.nome, aluno.serie, curso_principal.nome AS curso_principal, aluno.mes, aluno.ano, aluno.periodo, aluno.gostaDe 
                    FROM aluno
                    JOIN curso_principal ON aluno.curso = curso_principal.id
                    WHERE aluno.nome = '$consultaNome'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Exibir os resultados da consulta
                echo '<div class="mt-4"><h4>Resultados:</h4></div>';
                echo '<div class="table-responsive mt-2">';
                echo '<table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Série</th>
                                <th>Curso Principal</th>
                                <th>Mês</th>
                                <th>Ano</th>
                                <th>Período</th>
                                <th>Gosta de</th>
                            </tr>
                        </thead>
                        <tbody>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row["nome"] . '</td>';
                    echo '<td>' . $row["serie"] . '</td>';
                    echo '<td>' . $row["curso_principal"] . '</td>';
                    echo '<td>' . $row["mes"] . '</td>';
                    echo '<td>' . $row["ano"] . '</td>';
                    echo '<td>' . $row["periodo"] . '</td>';
                    echo '<td>' . $row["gostaDe"] . '</td>';
                    echo '</tr>';
                }

                echo '</tbody></table></div>';
            } else {
                echo '<div class="mt-4">Nenhum aluno encontrado com esse nome.</div>';
            }
        } else {
            echo '<div class="mt-4">Erro ao processar a consulta: Método de requisição inválido.</div>';
        }

        // Fechar a conexão com o banco de dados
        $conn->close();
        ?>
    </div>
</body>
</html>
