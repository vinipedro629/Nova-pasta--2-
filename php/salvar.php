<?php

// Inclui a conexão com o banco
require_once "conectar.php";

// Verifica se a requisição foi enviada via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recebe os dados do formulário
    $pergunta = trim($_POST["pergunta"]);
    $resposta = trim($_POST["resposta"]);
    $categoria = trim($_POST["categoria"]);

    // Validação
    if (empty($pergunta) || empty($resposta) || empty($categoria)) {

        echo "Todos os campos são obrigatórios.";
        exit;

    }

    // Inserir no banco usando Prepared Statement
    $sql = "INSERT INTO perguntas (pergunta, resposta, categoria)
            VALUES (?, ?, ?)";

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param("sss", $pergunta, $resposta, $categoria);

    if ($stmt->execute()) {

        echo "Pergunta salva com sucesso!";

    } else {

        echo "Erro ao salvar: " . $stmt->error;

    }

    $stmt->close();

} else {

    echo "Acesso inválido.";

}

$conexao->close();

?>