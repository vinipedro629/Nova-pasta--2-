<?php
require_once "conectar.php";

// logging simples
$logFile = __DIR__ . '/../logs/progresso.log';
function logMsg($m){ global $logFile; $t = date('Y-m-d H:i:s'); @file_put_contents($logFile, "[$t] $m\n", FILE_APPEND); }

logMsg("progresso.php called, method=" . $_SERVER['REQUEST_METHOD']);

header('Content-Type: application/json; charset=utf-8');

// Garante que exista uma linha de progresso (single-user)
$check = $conexao->query("SELECT COUNT(*) AS c FROM progresso");
if ($check) {
    $row = $check->fetch_assoc();
    if ($row['c'] == 0) {
        $conexao->query("INSERT INTO progresso (xp, nivel, perguntas_criadas, revisoes) VALUES (0,1,0,0)");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $res = $conexao->query("SELECT * FROM progresso LIMIT 1");
    $p = $res->fetch_assoc();
    $p['xp_to_next'] = intval($p['nivel']) * 100;
    echo json_encode($p, JSON_UNESCAPED_UNICODE);
    $conexao->close();
    exit;
}

// POST -> adicionar XP / ações
$action = $_POST['action'] ?? '';

if ($action === 'cadastro') {
    $conexao->query("UPDATE progresso SET xp = xp + 10, perguntas_criadas = perguntas_criadas + 1 LIMIT 1");
} elseif ($action === 'revisao') {
    $conexao->query("UPDATE progresso SET xp = xp + 5, revisoes = revisoes + 1 LIMIT 1");
} elseif (isset($_POST['xp'])) {
    $xpAdd = intval($_POST['xp']);
    $conexao->query("UPDATE progresso SET xp = xp + $xpAdd LIMIT 1");
}

// Recalcula level-up
$res = $conexao->query("SELECT * FROM progresso LIMIT 1");
if ($res) {
    $p = $res->fetch_assoc();
    $xp = intval($p['xp']);
    $nivel = intval($p['nivel']);
    $xpNeeded = $nivel * 100;
    $leveled = false;
    while ($xp >= $xpNeeded) {
        $xp -= $xpNeeded;
        $nivel++;
        $xpNeeded = $nivel * 100;
        $leveled = true;
    }
    // Atualiza valores finais
    $stmt = $conexao->prepare("UPDATE progresso SET xp = ?, nivel = ? WHERE id = ? LIMIT 1");
    $stmt->bind_param('iii', $xp, $nivel, $p['id']);
    $stmt->execute();
    $stmt->close();

    $p['xp'] = $xp;
    $p['nivel'] = $nivel;
    $p['xp_to_next'] = $nivel * 100;
    echo json_encode($p, JSON_UNESCAPED_UNICODE);
}

$conexao->close();

?>
