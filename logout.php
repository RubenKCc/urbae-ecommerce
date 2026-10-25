<?php
session_start();
session_unset();
session_destroy();

$voltar = $_SERVER['HTTP_REFERER'] ?? 'index.php';

// segurança: só permite páginas do teu site
if (!str_contains($voltar, $_SERVER['HTTP_HOST'])) {
    $voltar = 'index.php';
}

header("Location: $voltar");
exit;
