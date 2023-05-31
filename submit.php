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
    $gostaDe = isset($_POST["gostaDe"]) ? implode(", ", $_POST["gostaDe"]) : "";

    // Executar a consulta
    $sql = "INSERT INTO Aluno (nome, serie, curso, mes, ano, periodo, gostaDe) VALUES ('$nome', '$serie', $curso, '$mes', '$ano', '$periodo', '$gostaDe')";
    if ($conn->query($sql) === TRUE) {
        // Registro bem-sucedido
        // Recarregar a página principal
        echo "<script>window.location.href = 'index.php';</script>";
    } else {
        echo "Erro ao executar a consulta: " . $conn->error;
    }
} else {
    echo "Erro ao registrar os dados: " . $conn->error;
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
