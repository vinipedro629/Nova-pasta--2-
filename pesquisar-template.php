<?php if (empty($linhas)): ?>
    <h3>Nenhuma pergunta encontrada.</h3>
<?php else: ?>
    <?php foreach ($linhas as $linha): ?>
        <?php
            $id = $linha['id'];
            $pergunta = $linha['pergunta'];
            $resposta = $linha['resposta'];
            $categoria = $linha['categoria'];
        ?>
        <?php include __DIR__ . '/includes/question-card.php'; ?>
    <?php endforeach; ?>
<?php endif; ?>
