<?php
if (!isset($pageTitle) || empty($pageTitle)) {
    $pageTitle = 'Meu Caderno de Estudos';
}
if (!isset($bodyClass)) {
    $bodyClass = '';
}
$stylePath = __DIR__ . '/../css/style.css';
$styleVersion = file_exists($stylePath) ? filemtime($stylePath) : time();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo $styleVersion; ?>">
    <?php if (!empty($extraHead)): ?>
        <?php echo $extraHead; ?>
    <?php endif; ?>
</head>
<body<?php echo !empty($bodyClass) ? ' class="' . htmlspecialchars($bodyClass, ENT_QUOTES, 'UTF-8') . '"' : ''; ?> >
