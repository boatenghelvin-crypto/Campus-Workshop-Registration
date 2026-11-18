<?php
declare(strict_types=1);
require_once __DIR__ . '/functions.php';
$errors = $_SESSION['form_errors'] ?? [];
$old = $_SESSION['form_old'] ?? [];
unset($_SESSION['form_errors'], $_SESSION['form_old']);
$workshops = workshops();
function oldValue(array $old, string $field): string {
    return escape((string) ($old[$field] ?? ''));
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Campus Connect | Workshop Sign-Up</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <header class="site-header">
    <div class="wrap header-inner"><a href="index.php" class="brand">✦ Campus Connect</a><span class="header-label">Student Workshop Hub</span></div>
  </header>
  <main class="wrap grid">
    <section class="intro" aria-labelledby="intro-title">
      <p class="eyebrow">LEARN • CONNECT • GROW</p>
      <h1 id="intro-title">Small workshops.<br><em>Big ideas.</em></h1>
      <p class="lead">Discover practical workshops made for students. Choose a session, fill out the short form, and reserve your spot.</p>
      <div class="feature"><span class="feature-icon">01</span><div><strong>Pick a topic</strong><p>Explore technology and career skills.</p></div></div>
      <div class="feature"><span class="feature-icon">02</span><div><strong>Choose your format</strong><p>Join online or in person.</p></div></div>
      <div class="feature"><span class="feature-icon">03</span><div><strong>Get confirmation</strong><p>Your registration is safely recorded.</p></div></div>
    </section>
    <section class="panel" aria-labelledby="form-title">
      <div class="panel-header"><p class="eyebrow">WORKSHOP REGISTRATION</p><h2 id="form-title">Save your seat</h2><p>Fields marked * are required.</p></div>
      <?php if ($errors): ?>
        <div class="alert" role="alert"><strong>Please check your entries:</strong><ul><?php foreach ($errors as $error): ?><li><?= escape((string) $error) ?></li><?php endforeach; ?></ul></div>
      <?php endif; ?>
      <form action="submit.php" method="post">
        <input type="hidden" name="csrf_token" value="<?= escape(csrfToken()) ?>">
        <label for="full_name">Full name *</label>
        <input id="full_name" name="full_name" type="text" maxlength="100" autocomplete="name" required value="<?= oldValue($old, 'full_name') ?>" placeholder="e.g., Jordan Rivera">
        <label for="email">Email address *</label>
        <input id="email" name="email" type="email" maxlength="190" autocomplete="email" required value="<?= oldValue($old, 'email') ?>" placeholder="student@example.com">
        <label for="workshop">Workshop *</label>
        <select id="workshop" name="workshop" required><option value="">Select a workshop</option>
          <?php foreach ($workshops as $key => $title): ?>
          <option value="<?= escape($key) ?>" <?= ($old['workshop'] ?? '') === $key ? 'selected' : '' ?>><?= escape($title) ?></option>
          <?php endforeach; ?>
        </select>
        <label for="attendance_mode">Attendance format *</label>
        <select id="attendance_mode" name="attendance_mode" required>
          <option value="">Select a format</option>
          <option value="In person" <?= ($old['attendance_mode'] ?? '') === 'In person' ? 'selected' : '' ?>>In person</option>
          <option value="Online" <?= ($old['attendance_mode'] ?? '') === 'Online' ? 'selected' : '' ?>>Online</option>
        </select>
        <label for="notes">What do you hope to learn? <span class="optional">(optional)</span></label>
        <textarea id="notes" name="notes" maxlength="500" rows="3" placeholder="Share your learning goal..."><?= oldValue($old, 'notes') ?></textarea>
        <button type="submit">Register for workshop <span aria-hidden="true">→</span></button>
        <p class="privacy">Your information is used for this workshop registration. This demo does not send emails.</p>
      </form>
    </section>
  </main>
  <footer class="site-footer"><div class="wrap">© <?= date('Y') ?> Campus Connect • PHP + MySQL student project</div></footer>
</body>
</html>
