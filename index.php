<!DOCTYPE html>
<html>
<head>
    <title>Consulta de Alunos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<style>
    .custom-container {
        max-width: 87%;
        /* Defina a largura máxima desejada */
        margin-left: auto;
        margin-right: auto;
    }
</style>
<body>
    <div class="container mt-4 custom-container">
        <div class="row">
            <div class="col-md-6">
                <h2>Registrar Aluno</h2>

                <form action="submit.php" method="POST" class="mt-4">
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="serie">Série:</label>
                        <input type="text" id="serie" name="serie" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="curso">Curso Principal:</label>
                        <select id="curso" name="curso" class="form-control">
                            <option value=""></option>
                            <option value="1">Math</option>
                            <option value="2">Portugues</option>
                            <option value="3">physics</option>
                            <option value="4">filosofia</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mes">Mês:</label>
                        <select id="mes" name="mes" class="form-control">
                            <option value=""></option>
                            <option value="Janeiro">Janeiro</option>
                            <option value="Fevereiro">Fevereiro</option>
                            <option value="Março">Marco</option>
                            <option value="Abril">Abril</option>
                            <option value="Maio">Maio</option>
                            <option value="Junho">Junho</option>
                            <option value="Julho">Julho</option>
                            <option value="Agosto">Agosto</option>
                            <option value="Setembro">Setembro</option>
                            <option value="Outubro">Outubro</option>
                            <option value="Novembro">Novembro</option>
                            <option value="Dezembro">Dezembro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ano">Ano:</label>
                        <select name="ano" id="ano" class="form-control">
                            <option value=""></option>
                            <option value="2005">2005</option>
                            <option value="2006">2006</option>
                            <option value="2007">2007</option>
                            <option value="2008">2008</option>
                            <option value="2009">2009</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Período:</label>
                        <div class="form-check">
                            <input type="radio" name="periodo" value="1" class="form-check-input">
                            <label class="form-check-label">1</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="periodo" value="2" class="form-check-input">
                            <label class="form-check-label">2</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="periodo" value="3" class="form-check-input">
                            <label class="form-check-label">3</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="periodo" value="4" class="form-check-input">
                            <label class="form-check-label">4</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="periodo" value="5" class="form-check-input">
                            <label class="form-check-label">5</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Gosta de:</label>
                        <div class="form-check">
                            <input type="checkbox" name="gostaDe[]" value="Programação" class="form-check-input">
                            <label class="form-check-label">Programação</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="gostaDe[]" value="Música" class="form-check-input">
                            <label class="form-check-label">Música</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="gostaDe[]" value="Esportes" class="form-check-input">
                            <label class="form-check-label">Esportes</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="gostaDe[]" value="Leitura" class="form-check-input">
                            <label class="form-check-label">Leitura</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </form>
            </div>
            <div class="col-md-6">
                <h2>Consulta de Alunos</h2>

                <form action="index.php" method="GET" class="mt-4">
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

                // Processar os dados do formulário de consulta
                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    $consultaNome = isset($_GET["consultaNome"]) ? $_GET["consultaNome"] : "";

                    // Construir a consulta com base no nome do aluno
                    $whereClause = "";
                    if (!empty($consultaNome)) {
                        $whereClause = "WHERE aluno.nome = '$consultaNome'";
                    }

                    // Executar a consulta com a junção entre a tabela Aluno e a tabela CursoPrincipal
                    $sql = "SELECT aluno.nome, aluno.serie, curso_principal.nome AS curso_principal, aluno.mes, aluno.ano, aluno.periodo, aluno.gostaDe 
                        FROM aluno
                        JOIN curso_principal ON aluno.curso = curso_principal.id
                        $whereClause";
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
                                        <th>Ação</th>
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
                            echo '<td><button class="btn btn-danger" data-aluno="' . $row["nome"] . '">Excluir</button></td>';
                            echo '<td><a class="btn btn-primary" href="update.php?aluno=' . $row["nome"] . '">Atualizar</a></td>';
                            echo '</tr>';
                        }

                        echo '</tbody></table></div>';
                    } else {
                        echo '<div class="mt-4">Nenhum aluno encontrado.</div>';
                    }
                } else {
                    echo '<div class="mt-4">Erro ao processar a consulta: Método de requisição inválido.</div>';
                }

                // Fechar a conexão com o banco de dados
                $conn->close();
                ?>

            </div>
        </div>
    </div>

    <script>
        // Capturar todos os botões de exclusão
        var btnExcluir = document.querySelectorAll('.btn-danger');

        // Adicionar um evento de clique para cada botão
        btnExcluir.forEach(function(btn) {
            btn.addEventListener('click', function() {
                // Obter o nome do aluno a ser excluído do atributo "data-aluno"
                var aluno = this.getAttribute('data-aluno');

                // Confirmar a exclusão do aluno
                var confirmacao = confirm('Tem certeza que deseja excluir o aluno ' + aluno + '?');

                // Se o usuário confirmar a exclusão, redirecionar para a página de exclusão
                if (confirmacao) {
                    window.location.href = 'erase.php?aluno=' + encodeURIComponent(aluno);
                    // Recarregar a página principal
                    window.location.reload();
                }
            });
        });
    </script>
</body>
</html>
