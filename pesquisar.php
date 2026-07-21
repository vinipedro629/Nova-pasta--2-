<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar | Meu Caderno de Estudos</title>

    <link rel="stylesheet" href="css/style.css?v=<?php echo file_exists(__DIR__.'/css/style.css')?filemtime(__DIR__.'/css/style.css'):time(); ?>">
</head>

<body>

    <div class="container">

        <header>

            <h1>🔎 Pesquisar Perguntas</h1>

            <p>Pesquise por uma pergunta, resposta ou categoria.</p>

        </header>

        <div class="pesquisa">

            <input
                type="text"
                id="buscar"
                placeholder="Digite uma palavra para pesquisar...">

            <button id="btnPesquisar">
                🔍 Pesquisar
            </button>

        </div>

        <hr>

        <div id="resultadoPesquisa">

            <h2>Resultados</h2>

            <div class="cardPergunta">

                <h3>Pergunta</h3>

                <p>Aqui aparecerá a pergunta encontrada.</p>

                <h3>Resposta</h3>

                <p>Aqui aparecerá a resposta.</p>

                <span class="categoria">
                    Categoria: Programação
                </span>

            </div>

        </div>

        <div class="botoes">

            <button type="button" onclick="window.location.href='index.php'">
                🏠 Início
            </button>

            <button type="button" onclick="window.location.href='cadastro.php'">
                ➕ Novo Cadastro
            </button>

        </div>

    </div>

    <!-- Inline debug to verify JS execution in Edge -->
    <script>
        console.log('pesquisar.php inline debug script executed');
        (function(){
            try{
                var b = document.createElement('div');
                b.id = 'edge-debug-banner-pesquisar';
                b.textContent = 'DEBUG INLINE OK (pesquisar)';
                b.style.position = 'fixed';
                b.style.right = '18px';
                b.style.top = '58px';
                b.style.zIndex = 99999;
                b.style.background = 'rgba(59,130,246,0.95)';
                b.style.color = '#fff';
                b.style.padding = '8px 12px';
                b.style.borderRadius = '8px';
                b.style.boxShadow = '0 8px 20px rgba(2,6,23,0.35)';
                b.style.fontWeight = '700';
                document.body.appendChild(b);
                setTimeout(function(){ try{ b.remove(); } catch(e){} }, 2500);
            } catch(e){ console.error('debug banner error', e); }
        })();
    </script>

    <script src="js/script.js?v=<?php echo file_exists(__DIR__.'/js/script.js')?filemtime(__DIR__.'/js/script.js'):time(); ?>"></script>

</body>

</html>