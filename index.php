<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Caderno de Estudos</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body class="home-bg">

    <div class="container home-hero">

        <div class="hero">
            <div>
                <h1>📚 Meu Caderno de Estudos</h1>
                <p class="subtitulo">
                    Organize suas perguntas — cadastre e pesquise rapidamente.
                </p>
            </div>
            <div class="hero-acao">
                <a class="botao-link" href="cadastro.php">Cadastrar</a>
                <a class="botao-link botao-secundario" href="pesquisar.php">Pesquisar</a>
            </div>
        </div>

        <div class="painel-inicial">
            <section class="card-resumo">
                <h2>O que você pode fazer</h2>
                <p>Use o seu caderno para salvar perguntas e buscar respostas antigas.</p>
            </section>

            <section class="cards-features">
                <article class="card-feature">
                    <h3>Cadastro</h3>
                    <p>Adicione novas perguntas e respostas ao seu banco de estudos rapidamente.</p>
                    <a href="cadastro.php">Ir para cadastro</a>
                </article>
                <article class="card-feature">
                    <h3>Pesquisa</h3>
                    <p>Encontre perguntas por texto, resposta ou categoria.</p>
                    <a href="pesquisar.php">Ir para pesquisa</a>
                </article>
                <!-- Quiz e Flashcards removidos: mantidos em archive/ para rollback -->
            </section>
        </div>

    </div>

    <script src="js/script.js"></script>

</body>
</html>