<?php

// ======================================
// PESQUISAR PERGUNTAS
// ======================================

require_once "conectar.php";

// Recebe o texto pesquisado
$busca = "";

if (isset($_GET["busca"])) {
    $busca = trim($_GET["busca"]);
}

// Consulta
$sql = "SELECT * FROM perguntas
        WHERE pergunta LIKE ?
        OR resposta LIKE ?
        OR categoria LIKE ?
        ORDER BY id DESC";

$stmt = $conexao->prepare($sql);

$texto = "%" . $busca . "%";

$stmt->bind_param("sss", $texto, $texto, $texto);

$stmt->execute();

$resultado = $stmt->get_result();

// Nenhum resultado
if ($resultado->num_rows == 0) {

    echo "<h3>Nenhuma pergunta encontrada.</h3>";

} else {

    while ($linha = $resultado->fetch_assoc()) {

        $id = intval($linha['id']);
        $pergunta = htmlspecialchars($linha['pergunta'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $resposta = strip_tags($linha['resposta'], '<b><strong><i><em><u><ul><ol><li><p><br><h1><h2><h3><h4><h5><h6><a><table><thead><tbody><tr><td><th>');
        $categoria = htmlspecialchars($linha['categoria'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        echo "

        <div class='cardPergunta'>

            <h2>Pergunta</h2>

            <p>{$pergunta}</p>

            <button class='btn-mostrar-resposta' type='button'>Mostrar resposta</button>

            <div class='resposta-oculta' style='display:none;'>
                <h2>Resposta</h2>
                <div class='resposta-conteudo'>{$resposta}</div>
            </div>

            <div class='card-acoes'>
                <a class='btn-editar' href='cadastro.php?id={$id}'>Editar</a>
                <a class='btn-excluir' href='php/excluir.php?id={$id}' onclick=\"return confirm('Tem certeza que deseja excluir esta pergunta?');\">Excluir</a>
            </div>

            <span class='categoria'>
                {$categoria}
            </span>

            <hr>

        </div>

        ";

    }

}

$stmt->close();
$conexao->close();

?>