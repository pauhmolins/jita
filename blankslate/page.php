<?php

global $post;

$slug = $post->post_name;

$file = get_stylesheet_directory() . '/static/' . $slug . '/index.html';

if (file_exists($file)) {
    header('Content-Type: text/html; charset=utf-8');
    readfile($file);
    exit;
}

status_header(404);
echo "File not found";