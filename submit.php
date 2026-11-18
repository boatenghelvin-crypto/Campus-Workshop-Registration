<?php
declare(strict_types=1);
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php', true, 303);
    exit;
}

// Token prevents cross-site form submissions.
$providedToken = (string) ($_POST['csrf_token'] ?? '');
if (!hash_equals(csrfToken(), $providedToken)) {
    http_response_code(403);
    exit('Session expired. Return to the form and try again.');
}

$fields = ['full_name', 'email', 'workshop', 'attendance_mode', 'notes'];
$data = [];
foreach ($fields as $field) {
    $value = $_POST[$field] ?? '';
    $data[$field] = is_string($value) ? trim($value) : '';
}

$errors = [];
if (mb_strlen($data['full_name']) < 2 || mb_strlen($data['full_name']) > 100) {
    $errors[] = 'Name must be 2–100 characters.';
}
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($data['email']) > 190) {
    $errors[] = 'Enter a valid email address.';
}
if (!array_key_exists($data['workshop'], workshops())) {
    $errors[] = 'Choose one of the listed workshops.';
}
if (!in_array($data['attendance_mode'], ['Online', 'In person'], true)) {
    $errors[] = 'Choose an attendance format.';
}
if (mb_strlen($data['notes']) > 500) {
    $errors[] = 'Learning goals must be 500 characters or fewer.';
}

if ($errors) {
    $_SESSION['form_errors'] = $errors;
    $_SESSION['form_old'] = $data;
    redirectToForm();
}

try {
    // Prepared statements protect user-entered form data from SQL injection.
    $statement = database()->prepare(
        'INSERT INTO registrations (full_name, email, workshop_code, attendance_mode, notes)
         VALUES (:full_name, :email, :workshop, :attendance_mode, :notes)'
    );
    $statement->execute([
        ':full_name' => $data['full_name'],
        ':email' => strtolower($data['email']),
        ':workshop' => $data['workshop'],
        ':attendance_mode' => $data['attendance_mode'],
        ':notes' => $data['notes'] === '' ? null : $data['notes'],
    ]);
} catch (PDOException $exception) {
    error_log('Registration insert failed: ' . $exception->getMessage());
    $_SESSION['form_errors'] = ['Registration could not be saved. Please try again later.'];
    $_SESSION['form_old'] = $data;
    redirectToForm();
}

$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
$_SESSION['registration_success'] = ['name' => $data['full_name'], 'workshop' => workshops()[$data['workshop']]];
header('Location: success.php', true, 303);
exit;
