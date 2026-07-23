<?php
require_once __DIR__ . '/conectar.php';

$editMode = false;
$editId = 0;
$pergunta = '';
$resposta = '';
$categoria = '';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $editId = intval($_GET['id']);
    $stmt = $conexao->prepare("SELECT * FROM perguntas WHERE id = ? LIMIT 1");
    $stmt->bind_param('i', $editId);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $editMode = true;
            $pergunta = $row['pergunta'];
            $resposta = $row['resposta'];
            $categoria = $row['categoria'];
        }
    }
    $stmt->close();
}

$conexao->close();
