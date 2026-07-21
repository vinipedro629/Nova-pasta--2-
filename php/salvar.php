<?php

// Inclui a conexão com o banco
require_once "conectar.php";

// logging simples
$logFile = __DIR__ . '/../logs/salvar.log';
function logSalvar($m){ global $logFile; $t=date('Y-m-d H:i:s'); @file_put_contents($logFile, "[$t] $m\n", FILE_APPEND); }
logSalvar("salvar.php called, method=" . $_SERVER['REQUEST_METHOD']);

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
        logSalvar("Pergunta inserida: " . substr($pergunta,0,50));

        // Conceder XP por cadastro (+10 XP) e atualizar contador de perguntas
        // Garante que a tabela progresso exista e atualiza os valores
        $check = $conexao->query("SELECT COUNT(*) AS c FROM progresso");
        if ($check) {
            $row = $check->fetch_assoc();
            if ($row['c'] == 0) {
                $conexao->query("INSERT INTO progresso (xp, nivel, perguntas_criadas, revisoes) VALUES (0,1,0,0)");
            }
        }

        if (!$conexao->query("UPDATE progresso SET xp = xp + 10, perguntas_criadas = perguntas_criadas + 1 LIMIT 1")) {
            logSalvar("ERROR: update progresso failed: " . $conexao->error);
        } else {
            logSalvar("Progresso atualizado: +10 XP");
        }

        // Recalcula level-up imediatamente
        $res = $conexao->query("SELECT * FROM progresso LIMIT 1");
        if ($res) {
            $p = $res->fetch_assoc();
            $xp = intval($p['xp']);
            $nivel = intval($p['nivel']);
            $xpNeeded = $nivel * 100;
            while ($xp >= $xpNeeded) {
                $xp -= $xpNeeded;
                $nivel++;
                $xpNeeded = $nivel * 100;
            }
            $stmtUp = $conexao->prepare("UPDATE progresso SET xp = ?, nivel = ? WHERE id = ? LIMIT 1");
            $stmtUp->bind_param('iii', $xp, $nivel, $p['id']);
            if (!$stmtUp->execute()) {
                logSalvar("ERROR: stmtUp execute failed: " . $stmtUp->error);
            } else {
                logSalvar("Progresso recalculado: xp={$xp} nivel={$nivel}");
            }
            $stmtUp->close();
        }
    } else {

        echo "Erro ao salvar: " . $stmt->error;
        logSalvar("Erro ao executar insert: " . $stmt->error);

    }

    $stmt->close();

} else {

    echo "Acesso inválido.";

}

$conexao->close();

?>