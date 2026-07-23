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
            <div id="toolbar">
                <button type="button" class="ql-bold"></button>
                <button type="button" class="ql-italic"></button>
                <button type="button" class="ql-underline"></button>
                <button type="button" class="ql-list" value="ordered"></button>
                <button type="button" class="ql-list" value="bullet"></button>
                <button type="button" class="ql-link"></button>
            </div>
            <div id="editor" class="editor" style="min-height: 220px; background: #fff;
                border: 1px solid #d1d5db; border-radius: 0.75rem;
                padding: 0.75rem;
                box-sizing: border-box;
                margin-top: 0.75rem;"></div>
            <textarea id="resposta" name="resposta" style="display:none;"><?php echo htmlspecialchars($resposta, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></textarea>
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
            <button type="submit">💾 Salvar</button>
            <button type="reset">🗑 Limpar</button>
            <button type="button" onclick="window.location.href='index.php'">⬅ Voltar</button>
        </div>
    </form>
</div>
