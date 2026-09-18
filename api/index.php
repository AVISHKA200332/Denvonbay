<?php
/**
 * Denvonbay - Vercel Serverless Entrypoint & Router
 * -------------------------------------------------
 * Routes all serverless web requests on Vercel to appropriate PHP scripts,
 * sets correct environment/working directory, and serves static files if requested.
 */

// Global output buffering
if (!ob_get_level()) {
    ob_start();
}

$uri = $_SERVER['REQUEST_URI'] ?? '/';
$parsedPath = parse_url($uri, PHP_URL_PATH);
$path = trim($parsedPath, '/');

// Project root directory
$baseDir = dirname(__DIR__);
$realBase = realpath($baseDir);

// If root path is requested, serve index.php
if ($path === '' || $path === false) {
    $targetFile = 'index.php';
} else {
    $targetFile = $path;
}

// Check direct candidate path
$candidate = realpath($baseDir . '/' . $targetFile);

// If candidate is a folder, check for index.php within it (e.g. /admin/ -> /admin/index.php)
if ($candidate && is_dir($candidate)) {
    $subIndex = realpath($candidate . '/index.php');
    if ($subIndex && file_exists($subIndex)) {
        $candidate = $subIndex;
    }
}

// If no direct file found, check with .php appended (e.g. /about -> /about.php)
if (!$candidate || !file_exists($candidate)) {
    $withPhp = realpath($baseDir . '/' . $targetFile . '.php');
    if ($withPhp && file_exists($withPhp)) {
        $candidate = $withPhp;
    }
}

// Verify file exists and is strictly within project root (prevents path traversal)
if ($candidate && strpos($candidate, $realBase) === 0 && file_exists($candidate) && !is_dir($candidate)) {
    $ext = strtolower(pathinfo($candidate, PATHINFO_EXTENSION));

    // If static file requested through router, serve with proper content-type
    if ($ext !== 'php') {
        $mimeTypes = [
            'css'   => 'text/css',
            'js'    => 'application/javascript',
            'json'  => 'application/json',
            'png'   => 'image/png',
            'jpg'   => 'image/jpeg',
            'jpeg'  => 'image/jpeg',
            'gif'   => 'image/gif',
            'svg'   => 'image/svg+xml',
            'webp'  => 'image/webp',
            'ico'   => 'image/x-icon',
            'woff'  => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf'   => 'font/ttf',
            'pdf'   => 'application/pdf',
        ];

        $contentType = $mimeTypes[$ext] ?? 'application/octet-stream';
        header('Content-Type: ' . $contentType);
        header('Cache-Control: public, max-age=86400');
        readfile($candidate);
        exit;
    }

    // Set server script variables
    $relativeScript = str_replace('\\', '/', substr($candidate, strlen($realBase)));
    $_SERVER['SCRIPT_FILENAME'] = $candidate;
    $_SERVER['SCRIPT_NAME']     = $relativeScript;
    $_SERVER['PHP_SELF']        = $relativeScript;

    // Set working directory to the target file's directory
    // This guarantees both relative and __DIR__ based includes work seamlessly
    chdir(dirname($candidate));

    require $candidate;
    exit;
}

// 404 Fallback
http_response_code(404);
$custom404 = $baseDir . '/404.php';
if (file_exists($custom404)) {
    chdir($baseDir);
    require $custom404;
} else {
    echo "<h1>404 Not Found</h1><p>The requested page was not found.</p>";
}
