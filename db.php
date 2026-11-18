<?php
declare(strict_types=1);

/** Connect with PDO; keep credentials out of the public repository. */
function database(): PDO
{
    $path = __DIR__ . '/config.php';
    if (!is_file($path)) {
        http_response_code(503);
        exit('Database configuration missing. See README.md.');
    }

    $config = require $path;
    try {
        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
            $config['host'],
            (int) $config['port'],
            $config['database']
        );
        return new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    } catch (PDOException $exception) {
        error_log('Database connection failed: ' . $exception->getMessage());
        http_response_code(503);
        exit('Unable to connect to the workshop database.');
    }
}
