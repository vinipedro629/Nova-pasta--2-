<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Pergunta | Meu Caderno de Estudos</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="container">

        <header>

            <h1>📚 Meu Caderno de Estudos</h1>

            <p>Cadastre uma nova pergunta e sua resposta.</p>

        </header>

        <form id="formPergunta" action="php/salvar.php" method="post">

            <div class="campo">

                <label for="pergunta">Pergunta</label>

                <input
                    type="text"
                    id="pergunta"
                    name="pergunta"
                    placeholder="Digite sua pergunta..."
                    required>

            </div>

            <div class="campo">

                <label for="resposta">Resposta</label>

                <textarea
                    id="resposta"
                    name="resposta"
                    rows="8"
                    placeholder="Digite a resposta..."
                    required></textarea>

            </div>

            <div class="campo">

                <label for="categoria">Categoria</label>

                <input
                    type="text"
                    id="categoria"
                    name="categoria"
                    placeholder="Digite a categoria..."
                    required>

            </div>

            <div class="botoes">

                <button type="submit">
                    💾 Salvar
                </button>

                <button type="reset">
                    🗑 Limpar
                </button>

                <button type="button" onclick="window.location.href='index.php'">
                    ⬅ Voltar
                </button>

            </div>

        </form>

    </div>

    <script src="https://cdn.tiny.cloud/1/4fhqogrwifkjirqea2qpnlyed5zulzivoyx9x87dsy7nuukj/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#resposta',
            height: 320,
            menubar: false,
            plugins: 'lists link',
            toolbar: 'undo redo | bold italic underline | bullist numlist | link',
            branding: false,
            content_style: 'body { font-family: Arial, Helvetica, sans-serif; font-size: 14px; }'
        });
    </script>
    <script src="js/script.js"></script>

</body>

</html>