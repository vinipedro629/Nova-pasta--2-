<?php
// Carrega progresso server-side para garantir exibição imediata
$nivel_val = 1;
$xp_val = 0;
$xp_to_next_val = 100;
if (file_exists(__DIR__ . '/php/conectar.php')) {
    require_once __DIR__ . '/php/conectar.php';
    $res = $conexao->query("SELECT * FROM progresso LIMIT 1");
    if ($res) {
        $p = $res->fetch_assoc();
        if ($p) {
            $nivel_val = intval($p['nivel']);
            $xp_val = intval($p['xp']);
            $xp_to_next_val = $nivel_val * 100;
        }
    }
    $conexao->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Caderno de Estudos</title>

    <link rel="stylesheet" href="css/style.css?v=<?php echo file_exists(__DIR__.'/css/style.css')?filemtime(__DIR__.'/css/style.css'):time(); ?>">
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
                <div id="progressoBox" class="hero-progresso">
                    <div class="progresso-info">
                        <strong>Nível</strong>
                        <span id="nivel" class="nivel-badge"><?php echo $nivel_val; ?></span>
                    </div>
                    <div class="progresso-info">
                        <strong>XP</strong>
                        <span id="xp"><?php echo $xp_val; ?></span>/<span id="xpToNext"><?php echo $xp_to_next_val; ?></span>
                    </div>
                    <div class="xp-bar">
                        <div id="xpBar" class="xp-bar-fill" style="width:<?php echo ($xp_to_next_val>0)?round(($xp_val/$xp_to_next_val)*100):0; ?>%"></div>
                    </div>
                </div>

                <!-- Container para notificações/ganhos de XP -->
                <div id="xpNotifications" class="xp-notifications" aria-live="polite"></div>
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

    <!-- Inline debug script to verify browser executes inline JS (Edge diagnostic) -->
    <script>
        console.log('index.php inline debug script executed');
        // create a visible banner so user can visually confirm inline script ran
        (function(){
            try{
                var b = document.createElement('div');
                b.id = 'edge-debug-banner';
                b.textContent = 'DEBUG INLINE OK';
                b.style.position = 'fixed';
                b.style.right = '18px';
                b.style.top = '18px';
                b.style.zIndex = 99999;
                b.style.background = 'rgba(16,185,129,0.95)';
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