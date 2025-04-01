<?php
add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
    \Carbon_Fields\Carbon_Fields::boot();
}

require_once __DIR__ . "/theme-options.php";
require_once __DIR__ . "/nav-meta.php";
require_once __DIR__ . "/post-meta.php";
require_once __DIR__ . "/term-meta.php";
require_once __DIR__ . "/gutenberg-blocks.php";