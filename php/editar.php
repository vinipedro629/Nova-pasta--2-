<?php

require_once "conectar.php";

// Verifica se os dados foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = intval($_POST["id"]);
    $pergunta = trim($_POST["pergunta"]);
    $resposta = trim($_POST["resposta"]);
    $categoria = trim($_POST["categoria"]);

    // Validação
    if (
        empty($id) ||
        empty($pergunta) ||
        empty($resposta) ||
        empty($categoria)
    ) {

        die("Todos os campos são obrigatórios.");

    }

    // Atualizar registro
    $sql = "UPDATE perguntas
            SET pergunta = ?,
                resposta = ?,
                categoria = ?
            WHERE id = ?";

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param(
        "sssi",
        $pergunta,
        $resposta,
        $categoria,
        $id
    );

    if ($stmt->execute()) {

        echo "Pergunta atualizada com sucesso!";

    } else {

        echo "Erro ao atualizar: " . $stmt->error;

    }

    $stmt->close();

} else {

    echo "Acesso inválido.";

}

$conexao->close();

?>