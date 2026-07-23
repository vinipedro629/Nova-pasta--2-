<?php
$scriptPath = __DIR__ . '/../js/script.js';
$scriptVersion = file_exists($scriptPath) ? filemtime($scriptPath) : time();
?>
<?php if (!empty($extraScripts)): ?>
    <?php echo $extraScripts; ?>
<?php endif; ?>
<script src="js/script.js?v=<?php echo $scriptVersion; ?>"></script>
</body>
</html>
