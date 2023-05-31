<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "couto_para_form";
$port = "3306";

$conn = new mysqli($servername, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o parâmetro "aluno" foi passado na URL
if (isset($_GET['aluno'])) {
    $aluno = $_GET['aluno'];

    // Preparar a consulta de exclusão
    $sql = "DELETE FROM aluno WHERE nome = ?";

    // Preparar a declaração
    $stmt = $conn->prepare($sql);

    // Vincular o parâmetro
    $stmt->bind_param("s", $aluno);

    // Executar a consulta de exclusão
    if ($stmt->execute()) {
        echo "Aluno excluído com sucesso.";
    } else {
        echo "Erro ao excluir o aluno: " . $stmt->error;
    }

    // Fechar a declaração e a conexão
    $stmt->close();
    $conn->close();
} else {
    echo "Aluno não especificado.";
}
?>
