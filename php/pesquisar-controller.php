<?php
require_once __DIR__ . '/conectar.php';

$busca = '';
if (isset($_GET['busca'])) {
    $busca = trim($_GET['busca']);
}

$sql = "SELECT * FROM perguntas
        WHERE pergunta LIKE ?
        OR resposta LIKE ?
        OR categoria LIKE ?
        ORDER BY id DESC";

$stmt = $conexao->prepare($sql);
$texto = "%" . $busca . "%";
$stmt->bind_param('sss', $texto, $texto, $texto);
$stmt->execute();
$resultado = $stmt->get_result();

$linhas = [];
while ($linha = $resultado->fetch_assoc()) {
    $linhas[] = [
        'id' => intval($linha['id']),
        'pergunta' => htmlspecialchars($linha['pergunta'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
        'resposta' => strip_tags($linha['resposta'], '<b><strong><i><em><u><ul><ol><li><p><br><h1><h2><h3><h4><h5><h6><a><table><thead><tbody><tr><td><th>'),
        'categoria' => htmlspecialchars($linha['categoria'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
    ];
}

$stmt->close();
$conexao->close();
