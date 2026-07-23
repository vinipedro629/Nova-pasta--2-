<?php
$pageTitle = 'Cadastrar Pergunta | Meu Caderno de Estudos';
$bodyClass = '';
$extraHead = '<link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css">';
$extraScripts = '<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script><script>window.quillEditor = new Quill(\'#editor\', {theme: \'snow\', modules: {toolbar: [[\'bold\', \'italic\', \'underline\'], [{ \'list\': \'ordered\' }, { \'list\': \'bullet\' }], [\'link\']]}}); if (window.quillEditor && document.getElementById(\'resposta\') && document.getElementById(\'resposta\').value) { window.quillEditor.clipboard.dangerouslyPasteHTML(document.getElementById(\'resposta\').value); }</script>';
require_once __DIR__ . '/php/cadastro-controller.php';
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/form-cadastro.php';
include __DIR__ . '/includes/footer.php';
