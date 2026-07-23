<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Pergunta | Meu Caderno de Estudos</title>

    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css">
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

                <div id="editor" class="editor"></div>
                <textarea id="resposta" name="resposta" hidden></textarea>

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

    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        window.quillEditor = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    ['link']
                ]
            }
        });
    </script>
    <script src="js/script.js"></script>

</body>

</html>