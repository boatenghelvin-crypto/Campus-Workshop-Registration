<?php
declare(strict_types=1);
require_once __DIR__ . '/functions.php';
$confirmation = $_SESSION['registration_success'] ?? null;
unset($_SESSION['registration_success']);
if (!is_array($confirmation)) {
    header('Location: index.php', true, 303);
    exit;
}
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Registration Saved | Campus Connect</title><link rel="stylesheet" href="assets/style.css"></head>
<body>
<header class="site-header"><div class="wrap header-inner"><a href="index.php" class="brand">✦ Campus Connect</a><span class="header-label">Student Workshop Hub</span></div></header>
<main class="wrap success-wrap"><section class="panel success-panel"><div class="success-icon" aria-hidden="true">✓</div><p class="eyebrow">REGISTRATION SAVED</p><h1>You're on the list!</h1><p>Thanks, <strong><?= escape((string) $confirmation['name']) ?></strong>. Your registration for <strong><?= escape((string) $confirmation['workshop']) ?></strong> was saved to the database.</p><a class="button-link" href="index.php">Register for another workshop →</a></section></main>
<footer class="site-footer"><div class="wrap">© <?= date('Y') ?> Campus Connect • PHP + MySQL student project</div></footer>
</body></html>
