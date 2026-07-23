<?php
require_once "php/conectar.php";

$editMode = false;
$editId = 0;
$pergunta = '';
$resposta = '';
$categoria = '';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $editId = intval($_GET['id']);
    $stmt = $conexao->prepare("SELECT * FROM perguntas WHERE id = ? LIMIT 1");
    $stmt->bind_param('i', $editId);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $editMode = true;
            $pergunta = $row['pergunta'];
            $resposta = $row['resposta'];
            $categoria = $row['categoria'];
        }
    }
    $stmt->close();
}
$conexao->close();
?>
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

        <form id="formPergunta" action="<?php echo $editMode ? 'php/editar.php' : 'php/salvar.php'; ?>" method="post">

            <div class="campo">

                <label for="pergunta">Pergunta</label>

                <input
                    type="text"
                    id="pergunta"
                    name="pergunta"
                    placeholder="Digite sua pergunta..."
                    value="<?php echo htmlspecialchars($pergunta, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"
                    required>

            </div>

            <div class="campo">

                <label for="resposta">Resposta</label>

                <div id="editor" class="editor"></div>
                <textarea id="resposta" name="resposta" hidden><?php echo htmlspecialchars($resposta, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></textarea>

            </div>

            <?php if ($editMode): ?>
            <input type="hidden" name="id" value="<?php echo $editId; ?>">
            <?php endif; ?>
            <div class="campo">

                <label for="categoria">Categoria</label>

                <input
                    type="text"
                    id="categoria"
                    name="categoria"
                    placeholder="Digite a categoria..."
                    value="<?php echo htmlspecialchars($categoria, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"
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
        if (window.quillEditor && document.getElementById('resposta') && document.getElementById('resposta').value) {
            window.quillEditor.clipboard.dangerouslyPasteHTML(document.getElementById('resposta').value);
        }
    </script>
    <script src="js/script.js"></script>

</body>

</html>