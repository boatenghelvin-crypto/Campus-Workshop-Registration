<?php
declare(strict_types=1);

// Shared helpers for sessions, output escaping, and the sign-up form.
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function workshops(): array
{
    return [
        'web-design' => 'Introduction to Web Design',
        'cybersecurity' => 'Cybersecurity Basics',
        'data-skills' => 'Data Skills with Spreadsheets',
        'career-prep' => 'Resume and Interview Preparation',
    ];
}

function csrfToken(): string
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function redirectToForm(): never
{
    header('Location: index.php', true, 303);
    exit;
}
