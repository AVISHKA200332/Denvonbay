<?php
/**
 * Denvonbay - Database Connection
 * --------------------------------
 * Connects to MySQL using PDO.
 * Included by pages requiring database access.
 */

$host     = 'localhost';
$dbname   = 'denvonbay';
$username = 'root';
$password = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Log error details for server administrator
    error_log('Database connection error: ' . $e->getMessage());

    // Do NOT show raw error details to website visitors
    die('Database connection failed. Please try again later.');
}
