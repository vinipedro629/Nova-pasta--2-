<?php

// Arquivo de backup: php/quiz.php (ARCHIVE)
require_once "conectar.php";

$sql = "SELECT pergunta, resposta FROM perguntas ORDER BY id DESC";
$resultado = $conexao->query($sql);

$perguntas = [];

if ($resultado) {
    while ($linha = $resultado->fetch_assoc()) {
        $perguntas[] = [
            'pergunta' => $linha['pergunta'],
            'resposta' => $linha['resposta']
        ];
    }
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($perguntas, JSON_UNESCAPED_UNICODE);

$conexao->close();

?>
