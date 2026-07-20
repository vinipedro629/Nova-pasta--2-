<?php

// =======================================
// EXCLUIR PERGUNTA
// =======================================

require_once "conectar.php";

// Verifica se o ID foi informado
if (!isset($_GET["id"]) || empty($_GET["id"])) {
    die("ID da pergunta não informado.");
}

$id = (int) $_GET["id"];

// Verifica se a pergunta existe
$sql = "SELECT id FROM perguntas WHERE id = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    die("Pergunta não encontrada.");
}

$stmt->close();

// Excluir registro
$sql = "DELETE FROM perguntas WHERE id = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    header("Location: ../pesquisar.html?msg=excluido");
    exit;

} else {

    echo "Erro ao excluir a pergunta.";

}

$stmt->close();
$conexao->close();

?>