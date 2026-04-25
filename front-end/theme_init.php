<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Default
$theme = $_SESSION['theme'] ?? 'Light';
$lang  = $_SESSION['language'] ?? 'Indonesia';

// Body class untuk dark mode
$bodyClass = ($theme === 'Dark') ? 'dark' : '';

// Fungsi bantuan label bilingual
function __($indonesia, $english) {
    global $lang;
    return ($lang === 'English') ? $english : $indonesia;
}