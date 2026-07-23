<div class="cardPergunta">
    <h2>Pergunta</h2>
    <p><?php echo $pergunta; ?></p>

    <button class="btn-mostrar-resposta" type="button">Mostrar resposta</button>

    <div class="resposta-oculta" style="display:none;">
        <h2>Resposta</h2>
        <div class="resposta-conteudo"><?php echo $resposta; ?></div>
    </div>

    <div class="card-acoes">
        <a class="btn-editar" href="cadastro.php?id=<?php echo $id; ?>">Editar</a>
        <a class="btn-excluir" href="php/excluir.php?id=<?php echo $id; ?>" onclick="return confirm('Tem certeza que deseja excluir esta pergunta?');">Excluir</a>
    </div>

    <span class="categoria"><?php echo $categoria; ?></span>
    <hr>
</div>
