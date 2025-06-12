<?php
session_start();

$page = basename($_GET['page'] ?? 'home');  // Fallback to home if no page is set
$page_path = __DIR__ . '/pages/' . $page . '.php';  // Absolute path for better reliability

if (file_exists($page_path)) {
    include($page_path);
} else {
    echo "Page not found.";
}
?>
