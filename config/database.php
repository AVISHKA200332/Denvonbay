<?php
if (!ob_get_level()) {
    ob_start();
}
/**
 * Denvonbay - Database Connection
 * --------------------------------
 * Connects to MySQL using PDO.
 * Included by pages requiring database access.
 */

// 1. Check for remote cloud database URL (e.g. Railway, PlanetScale, TiDB, Supabase)
$databaseUrl = getenv('DATABASE_URL') ?: getenv('MYSQL_URL');

if ($databaseUrl) {
    $dbParts = parse_url($databaseUrl);
    $host     = $dbParts['host'] ?? 'localhost';
    $port     = $dbParts['port'] ?? 3306;
    $dbname   = ltrim($dbParts['path'] ?? '', '/');
    $username = $dbParts['user'] ?? '';
    $password = $dbParts['pass'] ?? '';
} else {
    // 2. Or standard environment variables (Vercel Project Settings)
    $host     = getenv('DB_HOST') ?: 'localhost';
    $port     = getenv('DB_PORT') ?: '3306';
    $dbname   = getenv('DB_NAME') ?: 'denvonbay';
    $username = getenv('DB_USER') ?: 'root';
    $password = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : '';
}

$pdo = null;

// Attempt MySQL connection
try {
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT            => 2,
    ];

    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        $options
    );

} catch (\Throwable $mysqlError) {
    // 3. Fallback: If MySQL is not reachable (e.g. on Vercel preview/serverless), use bundled SQLite
    $sqliteSource = __DIR__ . '/../database/denvonbay.sqlite';
    $sqliteTemp   = sys_get_temp_dir() . '/denvonbay.sqlite';

    // On Vercel Lambda, root filesystem is read-only. Copy sqlite to /tmp so SQLite can lock/read-write safely.
    if (file_exists($sqliteSource)) {
        if (!file_exists($sqliteTemp)) {
            @copy($sqliteSource, $sqliteTemp);
        }
    }

    $activeSqlite = file_exists($sqliteTemp) ? $sqliteTemp : (file_exists($sqliteSource) ? $sqliteSource : null);

    if ($activeSqlite) {
        try {
            $pdo = new PDO('sqlite:' . $activeSqlite);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $pdo->exec('PRAGMA foreign_keys = ON;');
        } catch (\Throwable $sqliteError) {
            error_log('Database SQLite fallback notice: ' . $sqliteError->getMessage());
            $pdo = null;
        }
    } else {
        error_log('Database notice: No MySQL or SQLite available. Using fallback static data.');
        $pdo = null;
    }
}
