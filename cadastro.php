<?php
require_once __DIR__ . '/php/cadastro-controller.php';

$pageTitle = 'Cadastrar Pergunta | Meu Caderno de Estudos';
$bodyClass = '';
$extraHead = '<link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css">';
$extraScripts = <<<'HTML'
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    if (typeof Quill !== 'undefined') {
        try {
            window.quillEditor = new Quill('#editor', {
                theme: 'snow',
                modules: {
                    toolbar: { container: '#toolbar' }
                }
            });
            const respostaTextarea = document.getElementById('resposta');
            if (respostaTextarea && respostaTextarea.value) {
                window.quillEditor.clipboard.dangerouslyPasteHTML(respostaTextarea.value);
            }
            if (respostaTextarea) {
                respostaTextarea.style.display = 'none';
            }
        } catch (e) {
            console.error('Quill initialization failed:', e);
            const editor = document.getElementById('editor');
            if (editor) {
                editor.style.display = 'none';
            }
        }
    } else {
        console.error('Quill is not loaded');
    }
</script>
HTML;

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/form-cadastro.php';
include __DIR__ . '/includes/footer.php';
?>
