<?php
$pageTitle = 'Pesquisar | Meu Caderno de Estudos';
$bodyClass = '';
require_once __DIR__ . '/php/pesquisar-controller.php';
$extraScripts = '';
include __DIR__ . '/includes/header.php';
?>

<div class="container">
    <header>
        <h1>🔎 Pesquisar Perguntas</h1>
        <p>Pesquise por uma pergunta, resposta ou categoria.</p>
    </header>

    <div class="pesquisa">
        <input type="text" id="buscar" placeholder="Digite uma palavra para pesquisar...">
        <button id="btnPesquisar">🔍 Pesquisar</button>
    </div>

    <hr>

    <div id="resultadoPesquisa">
        <h2>Resultados</h2>
        <?php include __DIR__ . '/pesquisar-template.php'; ?>
    </div>

    <div class="botoes">
        <button type="button" onclick="window.location.href='index.php'">🏠 Início</button>
        <button type="button" onclick="window.location.href='cadastro.php'">➕ Novo Cadastro</button>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
