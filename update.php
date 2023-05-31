<!DOCTYPE html>
<html>
<head>
    <title>Atualizar Aluno</title>
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
                <h2>Atualizar Aluno</h2>
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
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $nome = $_POST["nome"];
                    $serie = $_POST["serie"];
                    $curso = $_POST["curso"];
                    $mes = $_POST["mes"];
                    $ano = $_POST["ano"];
                    $periodo = $_POST["periodo"];
                    $gostaDe = isset($_POST["gostaDe"]) ? $_POST["gostaDe"] : [];

                    // Atualizar os dados do aluno no banco de dados
                    $sql = "UPDATE aluno SET serie='$serie', curso='$curso', mes='$mes', ano='$ano', periodo='$periodo', gostaDe='" . implode(",", $gostaDe) . "' WHERE nome='$nome'";
                    if ($conn->query($sql) === TRUE) {
                        echo '<div class="mt-4">Dados do aluno atualizados com sucesso.</div>';
                        echo '<script>window.location.href = "index.php";</script>';
                    } else {
                        echo '<div class="mt-4">Erro ao atualizar os dados do aluno: ' . $conn->error . '</div>';
                    }
                }

                // Verificar se o parâmetro aluno foi passado na URL
                if (isset($_GET["aluno"])) {
                    $aluno = $_GET["aluno"];

                    // Buscar os dados do aluno no banco de dados
                    $sql = "SELECT aluno.nome, aluno.serie, curso_principal.nome AS curso_principal, aluno.mes, aluno.ano, aluno.periodo, aluno.gostaDe 
                            FROM aluno
                            JOIN curso_principal ON aluno.curso = curso_principal.id
                            WHERE aluno.nome = '$aluno'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Extrair os dados do aluno do resultado da consulta
                        $row = $result->fetch_assoc();
                        $nome = $row["nome"];
                        $serie = $row["serie"];
                        $curso = $row["curso_principal"];
                        $mes = $row["mes"];
                        $ano = $row["ano"];
                        $periodo = $row["periodo"];
                        $gostaDe = explode(",", $row["gostaDe"]);

                        // Exibir o formulário preenchido com os dados do aluno
                        echo '<form action="update.php" method="POST" class="mt-4">
                                <div class="form-group">
                                    <label for="nome">Nome:</label>
                                    <input type="text" id="nome" name="nome" class="form-control" value="' . $nome . '" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="serie">Série:</label>
                                    <input type="text" id="serie" name="serie" class="form-control" value="' . $serie . '">
                                </div>
                                <div class="form-group">
                                    <label for="curso">Curso Principal:</label>
                                    <select id="curso" name="curso" class="form-control" required>
                                        <option value=""></option>
                                        <option value="1">Math</option>
                                        <option value="2">Português</option>
                                        <option value="3">Physics</option>
                                        <option value="4">Filosofia</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="mes">Mês:</label>
                                    <select id="mes" name="mes" class="form-control" required>
                                        <option value=""></option>
                                        <option value="Janeiro">Janeiro</option>
                                        <option value="Fevereiro">Fevereiro</option>
                                        <option value="Março">Março</option>
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
                                    <select name="ano" id="ano" class="form-control" required>
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
                                        <input type="radio" name="periodo" value="1" class="form-check-input" ' . ($periodo == "1" ? "checked" : "") . '>
                                        <label class="form-check-label">1</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="periodo" value="2" class="form-check-input" ' . ($periodo == "2" ? "checked" : "") . '>
                                        <label class="form-check-label">2</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="periodo" value="3" class="form-check-input" ' . ($periodo == "3" ? "checked" : "") . '>
                                        <label class="form-check-label">3</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="periodo" value="4" class="form-check-input" ' . ($periodo == "4" ? "checked" : "") . '>
                                        <label class="form-check-label">4</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="periodo" value="5" class="form-check-input" ' . ($periodo == "5" ? "checked" : "") . '>
                                        <label class="form-check-label">5</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Gosta de:</label>
                                    <div class="form-check">
                                        <input type="checkbox" name="gostaDe[]" value="Programação" class="form-check-input" ' . (in_array("Programação", $gostaDe) ? "checked" : "") . '>
                                        <label class="form-check-label">Programação</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="gostaDe[]" value="Música" class="form-check-input" ' . (in_array("Música", $gostaDe) ? "checked" : "") . '>
                                        <label class="form-check-label">Música</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="gostaDe[]" value="Esportes" class="form-check-input" ' . (in_array("Esportes", $gostaDe) ? "checked" : "") . '>
                                        <label class="form-check-label">Esportes</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="gostaDe[]" value="Leitura" class="form-check-input" ' . (in_array("Leitura", $gostaDe) ? "checked" : "") . '>
                                        <label class="form-check-label">Leitura</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Atualizar</button>
                            </form>';
                } else {
                    echo '<div class="mt-4">Aluno não encontrado.</div>';
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
                    // A função "encodeURIComponent" é usada para escapar caracteres especiais no nome do aluno
                }
            });
        });
    </script>

<div class="mt-4">
    <a href="index.php" class="btn btn-secondary">Voltar para a página principal</a>
</div>

</body>
</html>
