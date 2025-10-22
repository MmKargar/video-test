<?php
/**
 * Video server with HTTP Range request support for Vercel
 * Enables proper video seeking in all browsers
 */

// In Vercel, we need to reference files relative to the project root
// $_SERVER['DOCUMENT_ROOT'] or using relative path from api directory
$videoFile = $_SERVER['DOCUMENT_ROOT'] . '/fe3d32918a6f41c5b429472794f8ba69.webm';

// Fallback: try relative path if DOCUMENT_ROOT doesn't work
if (!file_exists($videoFile)) {
    $videoFile = dirname(__DIR__) . '/fe3d32918a6f41c5b429472794f8ba69.webm';
}

if (!file_exists($videoFile)) {
    http_response_code(404);
    header('Content-Type: application/json');
    die(json_encode([
        'error' => 'Video file not found',
        'searched_paths' => [
            $_SERVER['DOCUMENT_ROOT'] . '/fe3d32918a6f41c5b429472794f8ba69.webm',
            dirname(__DIR__) . '/fe3d32918a6f41c5b429472794f8ba69.webm'
        ]
    ]));
}

$fileSize = filesize($videoFile);
$mimeType = 'video/webm';

// Get the range header
$range = isset($_SERVER['HTTP_RANGE']) ? $_SERVER['HTTP_RANGE'] : null;

if ($range) {
    // Parse the range header
    list($unit, $range) = explode('=', $range, 2);

    if ($unit === 'bytes') {
        // Parse the range
        $ranges = explode(',', $range);
        $range = $ranges[0]; // Only handle the first range

        list($start, $end) = explode('-', $range);

        $start = intval($start);
        $end = ($end === '') ? ($fileSize - 1) : intval($end);

        // Validate range
        if ($start > $end || $start < 0 || $end >= $fileSize) {
            header('HTTP/1.1 416 Requested Range Not Satisfiable');
            header("Content-Range: bytes */$fileSize");
            exit;
        }

        $length = $end - $start + 1;

        // Send partial content response
        http_response_code(206);
        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . $length);
        header("Content-Range: bytes $start-$end/$fileSize");
        header('Accept-Ranges: bytes');
        header('Cache-Control: no-cache');

        // Open file and seek to start position
        $fp = fopen($videoFile, 'rb');
        fseek($fp, $start);

        // Send the requested chunk
        $remaining = $length;
        $chunkSize = 8192; // 8KB chunks

        while ($remaining > 0 && !feof($fp)) {
            $read = min($chunkSize, $remaining);
            echo fread($fp, $read);
            $remaining -= $read;
            flush();
        }

        fclose($fp);
    }
} else {
    // No range requested, send entire file
    header('HTTP/1.1 200 OK');
    header('Content-Type: ' . $mimeType);
    header('Content-Length: ' . $fileSize);
    header('Accept-Ranges: bytes');
    header('Cache-Control: no-cache');

    readfile($videoFile);
}

exit;
